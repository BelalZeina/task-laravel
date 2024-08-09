<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\VideoResource;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Category;
use App\Models\CategoryProduct;
use App\Models\Contact;

use App\Models\Exam;
use App\Models\Level;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\PaymentLog;
use App\Models\Product;
use App\Models\Question;
use App\Models\Score;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\Subscription;
use App\Models\Support;
use App\Models\Term;
use App\Models\User;
use App\Models\UserExam;
use App\Models\Video;
use Carbon\Carbon;
use Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{








    public function categories()
    {
        $category = CategoryProduct::latest()->paginate(10);
        return CategoryResource::collection($category);
    }


    public function products()
    {
        $products = Product::latest()->paginate(10);
        return ProductResource::collection($products);
    }


    public function product($id)
    {
        $product = Product::findOrFail($id);
        return new ProductResource($product);
    }

    public function add_address(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address_line1' => 'required|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $address = Address::create([
            'user_id' => auth()->user()->id,
            'address_line1' => $request->address_line1,
            'address_line2' => $request->address_line2,
            'city' => $request->city,
            'state' => $request->state,
            'postal_code' => $request->postal_code,
            'country' => $request->country,
        ]);

        return response()->json([
            'message' => 'Address created successfully.',
            'address' => $address,
        ], 201);
    }


    public function get_addresses()
    {
        $addresses = auth()->user()->addresses;

        return response()->json([
            'message' => 'Addresses retrieved successfully.',
            'addresses' => $addresses,
        ], 200);
    }

    public function store_order(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address_id' => 'required|exists:addresses,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $address = $request->user()->addresses()->find($request->address_id);

        if (!$address) {
            return response()->json(['error' => 'Invalid address.'], 422);
        }

        $userId = auth()->user()->id;
        $carts = Cart::where('user_id', $userId)->get();
        $user = auth()->user();
        if ($carts->count() == 0) {
            return sendResponse(400, 'Cart is empty');
        }
        $order = Order::create([
            'user_id' => $userId,
            'address_id' => $request->address_id,
            'total_amount' => calculateTotalCart(),
            'status' => 'pending',
        ]);

        foreach ($carts as $item) {
            $product = $item->product;
            $product->update([
                "stock" => $product->stock - $item['quantity']
            ]);
            OrderItems::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'attribute_values' => $item['attribute_values'],
                'owner_id' => $product->owner_id,
                'owner_type' => $product->owner_type,
                'price' => $item['price'],
            ]);
            $paymentLog = PaymentLog::create([
                'bill_no' => mt_rand(100000000, 9999999999),
                'owner_id' => $user->id,
                'owner_type' => get_class($user),
                'amount' => calculateTotalCart(),
                'type' => "order",
                'payment_tool' => "visa",
                'status' => false,
            ]);
        }
        foreach ($carts as $item) {
            $item->delete();
        }

        return sendResponse(200, 'order store successfully');
    }

    public function updateStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:Pending,Processing,Delivered',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $order = Order::findOrFail($id);
        $order->status = $request->input('status');
        $order->save();

        return sendResponse(200, 'status order updated successfully');
    }

    public function check(Request $request)
    {
        $request->validate([
            'order_id' => 'required|integer',
            'new_status' => 'required|string',
        ]);

        $payload = [
            'order_id' => $request->input('order_id'),
            'new_status' => $request->input('new_status'),
        ];
        Log::info('Webhook payload: '. json_encode($payload));
        Log::info('Webhook check success');
        return response()->json(['message' => 'Webhook check success'], 200);
    }
}
