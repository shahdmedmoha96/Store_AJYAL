<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index()
    {
        return view('front.products.index');
    }
    public function show(Product $product)
    {
        $product->active()->get();
        return view('front.products.show', compact('product'));
    }
}
