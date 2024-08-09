<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductAttributeValue;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function store_cart(Request $request)
    {
        // Validate the request data
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:1',
            // Add validation for other fields if needed
        ]);

        // Create a new cart item
        $cartItem = Cart::updateOrCreate([
            'product_id' => $request->input('product_id'),
            'user_id' => auth()->id(),
        ],[
            'product_id' => $request->input('product_id'),
            'user_id' => auth()->id(),
            'quantity' => $request->input('quantity'),
        ]);

        // Return a JSON response indicating success or failure
        if ($cartItem) {
            return response()->json(['message' => 'Cart item created successfully', 'data' => $cartItem], 201);
        } else {
            return response()->json(['message' => 'Failed to create cart item'], 500);
        }
    }


    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'nullable|exists:products,id',
            'quantity' => 'required|numeric|min:1'
        ]);

        $product = Product::query()->find($request->product_id);
        if ($product) {

            if ($product->stock <= 0 || $request->input('quantity') > $product->stock) {
                return sendResponse(404, 'Product Not Available Now');
            }

            $has_attribute = false;
            if ($product->attributes->count()>0 ) {
                $has_attribute = true;
            }

            $price = $product->price_after_discount==0? $product->price  : $product->price_after_discount;

            // Extra Prices in Attributes
            $attributes = null;
            if ($request->has('attribute')) {
                $attributes = array_values($request->input('attribute'));
                $attributeItems = ProductAttributeValue::query()->whereIn('id', $attributes)->get();
                foreach ($attributeItems as $attribute) {
                        $price += $attribute->price;
                }
            }
            if ($has_attribute && !$request->has('attribute')) {
                $attributes = array();
                foreach ($product->attributes()->get() as $attribute) {
                    $attributes[] = "" . $attribute?->values()->orderBy("price")?->first()?->id;
                }

                $attributes = array_values($attributes);
                $attributeItems = ProductAttributeValue::query()->whereIn('id', $attributes)->get();
                foreach ($attributeItems as $attribute) {
                        $price += $attribute->price;
                }
            }

            $user = auth()->user();
            $cart = Cart::query()->where([
                'product_id' => $product->id,
                'user_id' => $user->id,
                'attribute_values' => $attributes ? json_encode($attributes) : null
            ])->first();

            $tax = 0;
                // return $cart;
            if ($cart) {
                $cart->update([
                    // 'tax' => $tax,
                    'quantity' => $cart->quantity + $request->quantity,
                    'price' => $price,
                ]);
            } else {
                $cart = Cart::query()->create([
                    'product_id' => $product->id,
                    'user_id' => $user->id,
                    'price' => $price,
                    'attribute_values' => $attributes ? json_encode($attributes) : null
                ]);
            }


            return sendResponse(201, __('Operation Added Successfully'));

        } else {
            return sendResponse(404, __('You Must Enter Product Or Offer'), null);
        }
    }
    public function update_cart_quantity(Request $request)
    {
        // Validate the request data
        $request->validate([
            'cart_id' => 'required|exists:carts,id',
            'operation' => 'required|in:add,subtract',
        ]);

        // Find the cart item
        $cartItem = Cart::find($request->input('cart_id'));

        // Check if the cart item exists
        if ($cartItem) {
            // Update the quantity based on the operation
            if ($request->input('operation') == 'add') {
                $cartItem->quantity += 1;
            } else if ($request->input('operation') == 'subtract') {
                $cartItem->quantity -= 1;
            }

            // Ensure quantity does not go below 1
            if ($cartItem->quantity < 1) {
                $cartItem->quantity = 1;
            }

            $cartItem->save();

            return response()->json(['message' => 'Cart item updated successfully', 'data' => $cartItem], 200);
        } else {
            return response()->json(['message' => 'Cart item not found'], 404);
        }
    }


    public function cart()
    {
        // Get the user ID from the request or from the authenticated user
        $userId = auth()->user()->id;
        // Retrieve the carts associated with the user
        $carts = Cart::where('user_id', $userId)->get();
        // Return the cart items as a JSON response
        return response()->json(['data' => CartResource::collection($carts), "total_price"=>calculateTotalCart()], 200);
    }

    public function delete_cart($id)
    {
        $carts = Cart::find($id);
        $carts->delete();
        return response()->json(['msg' =>"cart delete success"]);
    }

    public function delete_all_carts()
    {
        // Get the user ID from the request or from the authenticated user
        $userId = auth()->user()->id;
        // Retrieve the carts associated with the user
        Cart::where('user_id', $userId)->delete();
        // Return the cart items as a JSON response
        return response()->json(['msg' =>"carts delete success"]);
    }

    public function updatePrice(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'attributes' => 'nullable|array',
            'attributes.*' => 'exists:product_attribute_values,id'
        ]);

        // Find the product by ID
        $product = Product::find($request->product_id);

        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found'], 404);
        }

        // Determine the base price of the product
        $price = $product->price_after_discount == 0 ? $product->price : $product->price_after_discount;

        // Add attribute prices to the base price
        $attributes = $request->input('attributes', []);
        if (!empty($attributes)) {
            $attributeItems = ProductAttributeValue::whereIn('id', $attributes)->get();
            foreach ($attributeItems as $attributeItem) {
                $price += $attributeItem->price;
            }
        } else if ($product->attributes()->count() > 0) {
            // If product has attributes but none are selected, use default attributes
            $defaultAttributes = $product->attributes->map(function ($attribute) {
                return $attribute->values()->orderBy('price')->first();
            })->filter()->pluck('id')->toArray();

            $attributeItems = ProductAttributeValue::whereIn('id', $defaultAttributes)->get();
            foreach ($attributeItems as $attributeItem) {
                $price += $attributeItem->price;
            }
        }

        return response()->json(['success' => true, 'price' => $price], 200);
    }


}
