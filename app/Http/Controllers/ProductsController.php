<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidRequestException;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * 获取所有商品
     *
     * @param Request $request
     * @return Illuminate\View\View
     */
    public function index(Request $request)
    {
        $builder = Product::query()->where('on_sale', true);
        if ($search = $request->input('search', '')) {
            $like = '%' . $search . '%';
            $builder->where(function ($query) use ($like) {
                $query->where('title', 'like', $like)->orWhere('description', 'like', $like)
                    ->orWhereHas('skus', function ($query) use ($like) {
                        $query->where('title', 'like', $like)->orWhere('description', 'like', $like);
                    });
            });
        }
        if ($order = $request->input('order', '')) {
            if (preg_match('/^(.+)_(asc|desc)$/', $order, $m)) {
                if (in_array($m[1], ['price', 'sold_count', 'rating'])) {
                    $builder->orderby($m[1], $m[2]);
                }
            }
        }
        $products = $builder->paginate(16);
        return view('products.index', [
            'products' => $products,
            'filters' => [
                'search' => $search,
                'order' => $order,
            ]
        ]);
    }
    /**
     * 详情
     *
     * @param Product $product
     * @param Request $request
     * @return Illuminate\View\View
     */
    public function show(Product $product, Request $request)
    {
        if (!$product->on_sale) {
            throw new InvalidRequestException('商品没有上架');
        }
        return view('products.show', ['product' => $product]);
    }
}
