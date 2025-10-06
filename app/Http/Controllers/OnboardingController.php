<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SkinType;          // <= ต้องอยู่นอก class
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OnboardingController extends Controller
{
    public function show()
    {
        // ดึง id + ชื่อ แล้ว alias เป็น name
        $skinTypes = SkinType::select('skin_type_id', 'skin_type_name as name')->get();
        return view('auth.onboarding', compact('skinTypes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'gender'            => ['required', 'in:male,female,other'],
            'age'               => ['required', 'integer', 'min:1', 'max:120'],
            // validate ให้ชี้คีย์ให้ถูก (skin_type_id)
            'skin_type_id'      => ['required', 'integer', 'exists:skin_types,skin_type_id'],
            // radio ส่งค่า "1"/"0" -> boolean ได้
            'is_sensitive_skin' => ['required', 'boolean'],
            'allergies'         => ['nullable', 'string', 'max:1000'],
        ]);

        $user = Auth::user();
        $user->fill($data)->save();

        // เสร็จแล้วไปหน้า home ตามที่ตั้งไว้
        return redirect()->route('home.idx');
    }
}
