<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $perPage = (int) $request->query('per_page', 12);
        $perPage = max(3, min($perPage, 60));

        $products = Product::query()
            ->select(['id','slug','name','price','image'])
            ->inRandomOrder()
            ->paginate($perPage)
            ->appends($request->only('per_page'));

        return view('index', compact('products'));
    }
}
