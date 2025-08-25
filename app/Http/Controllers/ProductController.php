<?php

namespace App\Http\Controllers;

use App\Product;

class ProductController extends Controller
{
    public function show(string $slug)
    {
        $product = Product::with('category:id,name,slug')
        ->where('slug', $slug)
            ->firstOrFail();

        return view('product.show', [
            'product'          => $product,
        ]);
    }
}

