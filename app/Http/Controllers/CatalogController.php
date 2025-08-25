<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Product;

class CatalogController extends Controller
{
    public function index(?string $slug = null, Request $request)
    {
        $currentCategory = $slug
            ? Category::select(['id','name','slug'])->where('slug', $slug)->firstOrFail()
            : Category::select(['id','name','slug'])->orderBy('name')->first();

        abort_if(!$currentCategory, 404, 'Категории не найдены');

        $perPage = (int) $request->query('per_page', 12);
        $perPage = max(3, min($perPage, 60));

        $products = Product::select(['id','category_id','name','slug','price','image'])
            ->where('category_id', $currentCategory->id)
            ->orderByDesc('id')
            ->paginate($perPage)
            ->appends($request->only('per_page'));

        return view('index', [
            'currentCategory' => $currentCategory,
            'products'        => $products,
        ]);
    }

}
