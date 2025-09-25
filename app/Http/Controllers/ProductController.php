<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
            public function index(\Illuminate\Http\Request $request)
    {
        $q        = trim((string)$request->input('q', ''));
        $ingRaw   = trim((string)$request->input('ingredient', ''));
        $acneType = trim((string)$request->input('acneType', ''));

        // explode ingredients by comma/space, drop empties, normalize to lower
        $ingTerms = collect(preg_split('/[,\s]+/u', $ingRaw))
            ->filter(fn($t) => $t !== null && $t !== '')
            ->map(fn($t) => mb_strtolower($t))
            ->values();

        // populate dropdown
        $skinOptions = \App\Models\Product::query()
            ->select('suitability_info')
            ->whereNotNull('suitability_info')
            ->where('suitability_info', '<>', '')
            ->distinct()
            ->orderBy('suitability_info')
            ->pluck('suitability_info');

        $products = \App\Models\Product::with(['ingredients' => function ($q) {
                $q->select('ingredients.ingredient_id', 'ingredient_name');
            }])
            // free text search across name + usage_details
            ->when($q !== '', function ($qq) use ($q) {
                $qq->where(function ($w) use ($q) {
                    $w->where('product_name', 'like', "%{$q}%")
                    ->orWhere('usage_details', 'like', "%{$q}%");
                });
            })
            // INGREDIENTS filter (AND logic across all terms)
            ->when($ingTerms->isNotEmpty(), function ($qq) use ($ingTerms) {
                foreach ($ingTerms as $t) {
                    $qq->whereHas('ingredients', function ($sub) use ($t) {
                        // LOWER() for safe case-insensitive match
                        $sub->whereRaw('LOWER(ingredient_name) LIKE ?', ["%{$t}%"]);
                    });
                }
            })
            // suitability / acneType
            ->when($acneType !== '', function ($qq) use ($acneType) {
                $qq->where('suitability_info', $acneType);
            })
            ->orderBy('product_id')
            ->paginate(12);

        return view('search', compact('products', 'skinOptions'));
        }

    
}
