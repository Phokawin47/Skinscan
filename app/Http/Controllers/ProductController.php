<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
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
