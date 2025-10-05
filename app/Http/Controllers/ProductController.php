<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

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

        // dropdown options
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
            'skinOptions' => $skinOptions,
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
        return view('product_management_create'); // ensure resources/views/create.blade.php exists
    }

    /**
     * Store new product
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name'        => 'required|string|max:255',
            'ingredients' => 'required|string',
            'type'        => 'required|string',
            'skin_type'   => 'required|string',
            'category'    => 'required|string',
            'description' => 'required|string',
            'image'       => 'required|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $usageDetailsText =
            "สารที่เกี่ยวข้อง: {$validatedData['ingredients']}\n" .
            "ประเภทสกินแคร์: {$validatedData['type']}\n" .
            "ความเหมาะสมสำหรับผิวหน้า: {$validatedData['skin_type']}\n" .
            "ประเภทผิว: {$validatedData['category']}\n\n" .
            "รายละเอียด / วิธีการใช้:\n{$validatedData['description']}";

        $dataToCreate = [
            'product_name'  => $validatedData['name'],
            'image_path'    => $imagePath,
            'usage_details' => $usageDetailsText,
        ];

        Product::create($dataToCreate);

        return redirect()->route('products.index')->with('success', 'บันทึกข้อมูลสินค้าเรียบร้อย!');
    }

    /**
     * Update product (usage_details & suitability_info)
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'usage_details'   => 'required|string',
            'suitability_info'=> 'required|string',
        ]);

        $product->update([
            'usage_details'    => $request->usage_details,
            'suitability_info' => $request->suitability_info,
        ]);

        return response()->json([
            'product_id'       => $product->product_id,
            'usage_details'    => $product->usage_details,
            'suitability_info' => $product->suitability_info,
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
