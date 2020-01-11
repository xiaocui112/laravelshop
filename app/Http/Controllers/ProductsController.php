<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * 获取所有商品
     *
     * @param Request $request
     * @return Illminate\View\View
     */
    public function index(Request $request)
    {
        $products = Product::query()->where('on_sale', true)->paginate(16);
        return view('products.index', compact('products'));
    }
}
