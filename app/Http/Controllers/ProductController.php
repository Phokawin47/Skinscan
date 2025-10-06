<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Ingredient;
use App\Models\SkinType;
use App\Models\ProductCategory;
use App\Models\Brand; // **เพิ่มบรรทัดนี้**
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Search / list page
     */
    public function index(Request $request)
    {
        $q        = trim((string) $request->input('q', ''));
        $ingRaw   = trim((string) $request->input('ingredient', ''));   // name="ingredient"
        $acneType = trim((string) $request->input('acneType', ''));

        // split by comma/space, lowercase, remove empties
        $ingTerms = collect(preg_split('/[,\s]+/u', $ingRaw))
            ->filter(fn ($t) => $t !== null && $t !== '')
            ->map(fn ($t) => mb_strtolower($t))
            ->values();

        // dropdown options (เป็นของหน้า search/list page)
        $skinOptionsForSearch = Product::query()
            ->select('suitability_info')
            ->whereNotNull('suitability_info')
            ->where('suitability_info', '<>', '')
            ->distinct()
            ->orderBy('suitability_info')
            ->pluck('suitability_info');

        $products = Product::with(['ingredients' => function ($q) {
                $q->select('ingredients.ingredient_id', 'ingredient_name');
            }])
            ->when($q !== '', function ($qq) use ($q) {
                $qq->where(function ($w) use ($q) {
                    $w->where('product_name', 'like', "%{$q}%")
                      ->orWhere('usage_details', 'like', "%{$q}%");
                });
            })
            // AND logic across ingredient terms
            ->when($ingTerms->isNotEmpty(), function ($qq) use ($ingTerms) {
                foreach ($ingTerms as $t) {
                    $qq->whereHas('ingredients', function ($sub) use ($t) {
                        $sub->whereRaw('LOWER(ingredient_name) LIKE ?', ["%{$t}%"]);
                    });
                }
            })
            ->when($acneType !== '', fn ($qq) => $qq->where('suitability_info', $acneType))
            ->orderBy('product_id')
            ->paginate(12)
            ->appends($request->query());

        return view('search', [
            'products'    => $products,
            'skinOptions' => $skinOptionsForSearch, // ใช้สำหรับหน้า search/list
            'q'           => $q,
            'ingredient'  => $ingRaw,
            'acneType'    => $acneType,
        ]);
    }

    public function edit()
    {
        $products = Product::all();
        return view('product_management_edit', compact('products'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        $ingredients = Ingredient::orderBy('ingredient_name')->get();
        $skinTypes = SkinType::orderBy('skin_type_name')->get();
        $productCategories = ProductCategory::orderBy('category_name')->get();
        $suitabilityOptions = Product::query()
            ->select('suitability_info')
            ->whereNotNull('suitability_info')
            ->where('suitability_info', '<>', '')
            ->distinct()
            ->orderBy('suitability_info')
            ->pluck('suitability_info');

        // **เพิ่ม: ดึงรายการแบรนด์ทั้งหมดและส่งไปยัง view**
        $brands = Brand::orderBy('brand_name')->get();


        return view('product_management_create', compact(
            'ingredients',
            'skinTypes',
            'productCategories',
            'suitabilityOptions',
            'brands' // **ส่ง brands ไปยัง view**
        ));
    }

/**
     * Store new product
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name'          => 'required|string|max:255',
            'selected_ingredients' => 'nullable|array',
            'selected_ingredients.*' => 'nullable|string',
            'new_ingredient_name' => 'nullable|string|max:255',
            'selected_product_category_id' => 'required|integer|exists:product_categories,category_id',
            'suitability_info' => 'required|string',
            'selected_skin_type_id' => 'nullable|integer|exists:skin_types,skin_type_id',
            'selected_brand_id' => [
                'nullable',
                'string',
                function ($attribute, $value, $fail) {
                    if ($value !== 'other_brand' && $value !== null && $value !== '') {
                        if (!is_numeric($value) || !Brand::where('brand_id', $value)->exists()) {
                            $fail("The selected brand is invalid.");
                        }
                    }
                },
            ],
            'new_brand_name'    => 'nullable|string|max:255',
            'description'   => 'required|string',
            'image'         => 'required|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        // --- ประมวลผลสารที่เกี่ยวข้อง (Ingredients) ---
        $ingredientNamesForUsageDetails = [];
        $ingredientIdsToAttach = [];

        if (!empty($request->input('selected_ingredients'))) {
            foreach ($request->input('selected_ingredients') as $selectedIdOrOther) {
                if ($selectedIdOrOther === 'other_ingredient') {
                    continue;
                }
                if (is_numeric($selectedIdOrOther)) {
                    $ingredientIdsToAttach[] = (int) $selectedIdOrOther;
                }
            }
        }

        if (!empty($validatedData['new_ingredient_name'])) {
            $newIngredientName = trim($validatedData['new_ingredient_name']);
            if (!empty($newIngredientName)) {
                $ingredient = Ingredient::firstOrCreate(['ingredient_name' => $newIngredientName]);
                $ingredientIdsToAttach[] = $ingredient->ingredient_id;
            }
        }

        if (!empty($ingredientIdsToAttach)) {
            $ingredientNamesForUsageDetails = Ingredient::whereIn('ingredient_id', array_unique($ingredientIdsToAttach))
                                                        ->pluck('ingredient_name')
                                                        ->toArray();
        }

        // --- ประมวลผลประเภทผิว (Skin Types - Single Select) ---
        $selectedSkinTypeId = $validatedData['selected_skin_type_id'] ?? null;
        $skinTypeNameForUsageDetails = null;

        if ($selectedSkinTypeId) {
            $skinTypeNameForUsageDetails = SkinType::find($selectedSkinTypeId)->skin_type_name ?? null;
        }

        // --- ประมวลผลประเภทสกินแคร์ (Product Category - Single Select) ---
        $selectedProductCategoryId = $validatedData['selected_product_category_id'];
        $productCategoryNameForUsageDetails = ProductCategory::find($selectedProductCategoryId)->category_name ?? null;

        // --- ดึงค่าความเหมาะสมสำหรับผิวหน้า ---
        $selectedSuitabilityInfo = $validatedData['suitability_info'];

        // --- ประมวลผลแบรนด์ (Brand) ---
        $selectedBrandId = null;
        $brandNameForUsageDetails = null;
        $selectedBrandInput = $request->input('selected_brand_id');

        if ($selectedBrandInput === 'other_brand' && !empty($validatedData['new_brand_name'])) {
            $newBrandName = trim($validatedData['new_brand_name']);
            if (!empty($newBrandName)) {
                $brand = Brand::firstOrCreate(['brand_name' => $newBrandName]);
                $selectedBrandId = $brand->brand_id;
                $brandNameForUsageDetails = $brand->brand_name;
            }
        } elseif ($selectedBrandInput !== null && $selectedBrandInput !== '' && $selectedBrandInput !== 'other_brand') {
            $selectedBrandId = (int)$selectedBrandInput;
            $brand = Brand::find($selectedBrandId);
            $brandNameForUsageDetails = $brand->brand_name ?? null;
        }


        // **สร้าง usage_details_text ใหม่ทั้งหมด**
        $usageDetailsText = "";
        if ($brandNameForUsageDetails) {
            $usageDetailsText .= "แบรนด์: " . $brandNameForUsageDetails . "\n";
        } else {
             $usageDetailsText .= "แบรนด์: -\n";
        }
        if (!empty($ingredientNamesForUsageDetails)) {
            $usageDetailsText .= "สารที่เกี่ยวข้อง: " . implode(', ', $ingredientNamesForUsageDetails) . "\n";
        }
        if ($productCategoryNameForUsageDetails) {
            $usageDetailsText .= "ประเภทสกินแคร์: " . $productCategoryNameForUsageDetails . "\n";
        } else {
             $usageDetailsText .= "ประเภทสกินแคร์: -\n";
        }
        $usageDetailsText .= "ความเหมาะสมสำหรับผิวหน้า: {$selectedSuitabilityInfo}\n";
        if ($skinTypeNameForUsageDetails) {
            $usageDetailsText .= "ประเภทผิว: " . $skinTypeNameForUsageDetails . "\n\n";
        } else {
             $usageDetailsText .= "ประเภทผิว: -\n\n";
        }
        $usageDetailsText .= "รายละเอียด / วิธีการใช้:\n{$validatedData['description']}";


        $dataToCreate = [
            'product_name'  => $validatedData['name'],
            'image_path'    => $imagePath,
            'usage_details' => $usageDetailsText,
            'category_id'   => $selectedProductCategoryId,
            'suitability_info' => $selectedSuitabilityInfo,
            'brand_id'      => $selectedBrandId,
            'added_by_user_id' => Auth::id(), // **เพิ่มบรรทัดนี้: ดึง ID ของผู้ใช้ที่ล็อกอินอยู่**
        ];

        $product = Product::create($dataToCreate);

        // **ผูกสารที่เกี่ยวข้องกับสินค้า (Many-to-Many)**
        if (!empty($ingredientIdsToAttach)) {
            $product->ingredients()->attach(array_unique($ingredientIdsToAttach));
        }

        // **ผูกประเภทผิวกับสินค้า (Many-to-Many แต่เลือกค่าเดียว)**
        if ($selectedSkinTypeId) {
            $product->skinTypes()->sync([$selectedSkinTypeId]);
        } else {
            $product->skinTypes()->detach();
        }

        return redirect()->route('product_management_edit.idx')->with('success', 'บันทึกข้อมูลสินค้าเรียบร้อย!');
    }

    /**
     * Update product (usage_details & suitability_info)
     */
    public function update(Request $request, Product $product)
    {
        // **ปรับปรุง validation ให้ตรงกับ input ที่ส่งมาจาก Modal**
        $request->validate([
            'usage_details'   => 'required|string',
            'suitability_info'=> 'required|string',
        ]);

        $product->update([
            'usage_details'    => $request->usage_details,
            'suitability_info' => $request->suitability_info,
        ]);

        // **ปรับปรุง response เพื่อส่งข้อมูลที่อัปเดตกลับไปให้ Frontend**
        return response()->json([
            'success' => true, // เพิ่ม success flag
            'product_id'       => $product->product_id,
            'usage_details'    => $product->usage_details,
            'suitability_info' => $product->suitability_info,
            'message' => 'ข้อมูลสินค้าได้รับการอัปเดตเรียบร้อยแล้ว' // เพิ่มข้อความ
        ]);
    }

    /**
     * Soft delete product
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