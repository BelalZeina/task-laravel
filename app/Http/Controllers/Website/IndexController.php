<?php

namespace App\Http\Controllers\Website;
use App\Http\Controllers\Controller;
use App\Models\CategoryProduct;
use App\Models\Product;
use App\Models\ProductAttributeValue;
use Illuminate\Http\Request;


class IndexController extends Controller
{


    public function index(Request $request)
    {
        return view('website.products.index');
    }
    public function filter_category(Request $request,$id)
    {
        $categoryId = $id;
        return view('website.products.index', compact('categoryId'));
    }

    public function show(Product $product)
    {
        return view('website.products.show', compact('product'));
    }


    public function getPrice($id, Request $request)
    {
        $product = Product::query()->find($id);
        if (!$product) {
            return response_web(false, __('Product Not Fount'));
        }

        $price =$product->price_after_discount!=0? $product->price_after_discount:$product->price;
        if ($request->has('attribute')) {
            $attribute_ids = array_values($request->input('attribute'));
            $attributes = ProductAttributeValue::query()->whereIn('id', $attribute_ids)->get();
            foreach ($attributes as $attribute) {
                $price += $attribute->price;
            }
        }

        return response_web(true, __('Operation Completed Successfully'), ['price' => $price]);
    }


    public function getCartCount()
    {
        $user = auth()->user();
        $cartCount = $user ? $user->carts->count() : 0;
        return response()->json(['count' => $cartCount]);
    }

}
