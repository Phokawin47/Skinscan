<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\ScanHistory;
use App\Models\ScanResult;
use App\Models\AcneType;

class ScanResultController extends Controller
{
    public function store(Request $request)
    {
        // 1) รับ base64 จาก request (แนะนำให้ส่งเป็น JSON ไม่ใช่ form-urlencoded)
        $base64 = $request->input('result_image_base64');

        // ต้องมีรูปเสมอ
        if (empty($base64)) {
            return response()->json([
                'message' => 'result_image_base64 is required.'
            ], 422);
        }

        // 2) เคสส่งแบบ form-urlencoded จะทำให้ '+' กลายเป็น ' ' ให้แปลงกลับ
        $base64 = str_replace(' ', '+', $base64);

        // ตัด prefix ถ้ามี
        $data = preg_replace('/^data:image\/[a-zA-Z0-9.+-]+;base64,/', '', $base64);

        // decode และตรวจสอบความถูกต้อง
        $binary = base64_decode($data, true); // strict = true
        if ($binary === false || strlen($binary) === 0) {
            return response()->json([
                'message' => 'Invalid base64 image data.'
            ], 422);
        }

        // 3) เซฟไฟล์ลง disk public
        $filename = 'scan_results/' . Str::uuid() . '.png';
        $ok = Storage::disk('public')->put($filename, $binary);
        if (!$ok) {
            return response()->json([
                'message' => 'Failed to write image to storage.'
            ], 500);
        }

        // ยืนยันว่ามีไฟล์จริง
        if (!Storage::disk('public')->exists($filename)) {
            return response()->json([
                'message' => 'Image write seems completed but file not found afterwards.'
            ], 500);
        }

        // 4) Validate ฟิลด์อื่น
        $v = Validator::make($request->all(), [
            'skin_type'         => ['nullable','string','max:50'],
            'result.detections' => ['array'],
            'user_id'           => ['nullable','integer'],
        ]);
        if ($v->fails()) {
            // ลบไฟล์ที่เพิ่งสร้างเพื่อไม่ให้ค้าง
            Storage::disk('public')->delete($filename);
            return response()->json(['message'=>'Validation error','errors'=>$v->errors()], 422);
        }

        return DB::transaction(function () use ($request, $filename) {

            // 5) สร้าง ScanHistory โดยบังคับใช้ path ที่เราเพิ่งบันทึก (ไม่ใช้ path จาก client)
            $scan = ScanHistory::create([
                'user_id'           => auth()->id() ?? $request->input('user_id'),
                'skin_type'         => $request->input('skin_type', 'unknown'),
                'result_image_path' => $filename, // ✅ เก็บเฉพาะ path ที่เซฟสำเร็จ
                'scan_timestamp'    => now(),
            ]);

            // 6) map ชื่อ → id (case-insensitive)
            $nameToId = AcneType::pluck('acne_type_id','acne_type_name')
                        ->mapWithKeys(fn($id,$name)=>[mb_strtolower(trim($name))=>$id])->all();
            $validIds = AcneType::pluck('acne_type_id')->all();

            $rawDetections = (array) $request->input('result.detections', []);
            $ids = [];

            foreach ($rawDetections as $d) {
                if (!empty($d['class_name'])) {
                    $k = mb_strtolower(trim($d['class_name']));
                    if (isset($nameToId[$k])) $ids[] = $nameToId[$k];
                } elseif (isset($d['class_id']) && in_array((int)$d['class_id'], $validIds, true)) {
                    $ids[] = (int)$d['class_id'];
                }
            }
            $ids = array_values(array_unique($ids));

            if (!$ids) {
                // ถ้าไม่มี acne type ที่แมพได้ → ยกเลิกทั้งทรานแซคชัน และลบไฟล์ออก
                // (throw exception เพื่อ rollback)
                throw new \RuntimeException('No valid acne type found from detections.');
            }

            foreach ($rawDetections as $d) {
                $className = $d['class_name'] ?? null;
                $mappedId  = null;

                if ($className) {
                    $k = mb_strtolower(trim($className));
                    $mappedId = $nameToId[$k] ?? null;
                } elseif (isset($d['class_id']) && in_array((int)$d['class_id'], $validIds, true)) {
                    $mappedId = (int)$d['class_id'];
                }

                if ($mappedId && in_array($mappedId, $ids, true)) {
                    ScanResult::firstOrCreate(
                        ['scan_id' => $scan->scan_id, 'acne_type_id' => $mappedId],
                        ['class_name' => $className]
                    );
                }
            }

            return response()->json([
                'scan' => $scan->load('results.acneType'),
                'image_url' => Storage::url($filename), // เผื่อ debug ที่ฝั่งหน้าเว็บ
            ], 201);
        });
    }
}
