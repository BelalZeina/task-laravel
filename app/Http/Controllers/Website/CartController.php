<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\PaymentLog;
use App\Models\Product;
use App\Models\ProductAttributeValue;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {

        return view('website.carts.index');
    }


    public function storeOrder(Request $request)
    {
        $request->validate([
            'address_line1' => 'required|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:255',
        ]);
        // Store the address in the database
        $address = Address::create([
            'user_id' => auth()->id(),
            'address_line1' => $request->address_line1,
            'address_line2' => $request->address_line2,
            'city' => $request->city,
            'state' => $request->state,
            'postal_code' => $request->postal_code,
            'country' => $request->country,
        ]);

        // Step 10: Create an order in the database
        $order = Order::create([
            'user_id' => auth()->id(),
            'address_id' => $address->id,
            'total_amount' => calculateTotalCart(),
            'status' => 'pending',
        ]);
        $user=auth()->user();
        // Step 11: Create order items in the database
        foreach ($user->carts as $item) {
            $product = $item->product;
            $product->update([
                "stock" => $product->stock - $item['quantity']
            ]);
            OrderItems::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'attribute_values' => $item['attribute_values'],
                'price' => $item['price'],
            ]);
        }
        $paymentLog = PaymentLog::create([
            'bill_no' => mt_rand(100000000, 9999999999),
            'owner_id' =>$user->id,
            'owner_type' =>  get_class($user),
            'amount' => calculateTotalCart(),
            'type' => "order",
            'payment_tool' => "visa",
            'status' => false,
        ]);
        foreach ($user->carts as $item) {
            $item->delete();
        }

        session()->flash('success_message', 'Order placed successfully.');

        return redirect()->back(); // Redirect to a success page
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

}
