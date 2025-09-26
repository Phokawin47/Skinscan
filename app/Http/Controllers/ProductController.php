<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
<<<<<<< HEAD
    /**
     * แสดงรายการสินค้าทั้งหมด
     */
    public function index()
    {
        $products = Product::all();
        return view('index', compact('products'));
    }

    /**
     * แสดงหน้าสำหรับสร้างสินค้าใหม่
     */
    public function create()
    {
        return view('create'); // ตรวจสอบให้แน่ใจว่าคุณมีไฟล์ create.blade.php
    }

    /**
     * จัดเก็บสินค้าที่สร้างใหม่ลงฐานข้อมูล (นี่คือเมธอดที่ถูกต้อง)
     */
    public function store(Request $request)
    {
        // 1. ตรวจสอบความถูกต้องของข้อมูลจากฟอร์มแต่ละช่องเหมือนเดิม
        $validatedData = $request->validate([
            'name'        => 'required|string|max:255',
            'ingredients' => 'required|string',
            'type'        => 'required|string',
            'skin_type'   => 'required|string',
            'category'    => 'required|string',
            'description' => 'required|string',
            'image'       => 'required|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);

        // 2. จัดการไฟล์รูปภาพ (เหมือนเดิม)
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        // ==========================================================
        // ===== จุดสำคัญ: สร้างข้อความรวมสำหรับ usage_details =====
        // ==========================================================
        $usageDetailsText = "สารที่เกี่ยวข้อง: " . $validatedData['ingredients'] . "\n" .
                            "ประเภทสกินแคร์: " . $validatedData['type'] . "\n" .
                            "ความเหมาะสมสำหรับผิวหน้า: " . $validatedData['skin_type'] . "\n" .
                            "ประเภทผิว: " . $validatedData['category'] . "\n\n" .
                            "รายละเอียด / วิธีการใช้:\n" . $validatedData['description'];

        // 3. เตรียมข้อมูลสุดท้ายที่จะบันทึกลงฐานข้อมูล
        // เราจะสร้าง array ใหม่ที่มีแค่คอลัมน์ที่ตรงกับในตารางเท่านั้น
        $dataToCreate = [
            'product_name'  => $validatedData['name'],
            'image_path'    => $imagePath,
            'usage_details' => $usageDetailsText,
            // หากมีคอลัมน์อื่นๆ ที่ต้องบันทึก เช่น brand_id ให้เพิ่มตรงนี้
        ];

        // 4. บันทึกข้อมูลลงฐานข้อมูล
        Product::create($dataToCreate);

        // 5. Redirect กลับไปที่หน้ารายการสินค้า (เหมือนเดิม)
        return redirect()->route('products.index')->with('success', 'บันทึกข้อมูลสินค้าเรียบร้อย!');
    }

    /**
     * อัปเดตข้อมูลสินค้าในฐานข้อมูล
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'usage_details' => 'required|string',
            'suitability_info' => 'required|string',
        ]);

        $product->update([
            'usage_details' => $request->usage_details,
            'suitability_info' => $request->suitability_info,
        ]);

        return response()->json([
            'product_id' => $product->product_id,
            'usage_details' => $product->usage_details,
            'suitability_info' => $product->suitability_info,
        ]);
    }

    /**
     * ลบสินค้า (แบบ Soft Delete)
     */
    public function destroy(Product $product)
    {
        try {
            $product->delete();
            return response()->json(['success' => true, 'message' => 'ลบข้อมูลสำเร็จ']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'เกิดข้อผิดพลาดในการลบข้อมูล'], 500);
        }
    }
}
=======
    public function index(Request $request)
    {
        $q        = trim((string) $request->input('q', ''));
        $ingRaw   = trim((string) $request->input('ingredient', ''));   // form field: name="ingredient"
        $acneType = trim((string) $request->input('acneType', ''));

        // split by comma or whitespace, lowercase, remove empties
        $ingTerms = collect(preg_split('/[,\s]+/u', $ingRaw))
            ->filter(fn ($t) => $t !== null && $t !== '')
            ->map(fn ($t) => mb_strtolower($t))
            ->values();

        // dropdown options for suitability
        $skinOptions = Product::query()
            ->select('suitability_info')
            ->whereNotNull('suitability_info')
            ->where('suitability_info', '<>', '')
            ->distinct()
            ->orderBy('suitability_info')
            ->pluck('suitability_info');

        $products = Product::with(['ingredients' => function ($q) {
                $q->select('ingredients.ingredient_id', 'ingredient_name');
            }])
            // free text
            ->when($q !== '', function ($qq) use ($q) {
                $qq->where(function ($w) use ($q) {
                    $w->where('product_name', 'like', "%{$q}%")
                      ->orWhere('usage_details', 'like', "%{$q}%");
                });
            })
            // ingredients (AND across all terms). For OR, see note below.
            ->when($ingTerms->isNotEmpty(), function ($qq) use ($ingTerms) {
                foreach ($ingTerms as $t) {
                    $qq->whereHas('ingredients', function ($sub) use ($t) {
                        // If your DB collation is already case-insensitive, you can use plain where 'like'
                        $sub->whereRaw('LOWER(ingredient_name) LIKE ?', ["%{$t}%"]);
                    });
                }
            })
            // suitability / acneType
            ->when($acneType !== '', fn ($qq) => $qq->where('suitability_info', $acneType))
            ->orderBy('product_id')
            ->paginate(12)
            ->appends($request->query()); // keep filters in pagination links

        return view('search', [
            'products'    => $products,
            'skinOptions' => $skinOptions,
            // return current filters so the form can show the selected values
            'q'           => $q,
            'ingredient'  => $ingRaw,
            'acneType'    => $acneType,
        ]);
    }
}
>>>>>>> 3e41b5404671912e97359b3c013be1db08e8c721
