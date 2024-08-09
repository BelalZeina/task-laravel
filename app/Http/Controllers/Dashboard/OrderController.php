<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Category;
use App\Models\CategoryProduct;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index()
    {
        $orders = Order::latest()->get();
        return view('dashboard.orders.index', compact('orders'));
    }
    public function show($id)
    {

        $order = Order::with(['user', 'items.product', 'owner'])->findOrFail($id);
        return view('dashboard.orders.order-details', compact('order'));
    }
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = $request->input('status');
        $order->save();

        return redirect()->back()->with('success', 'Order status updated successfully.');
    }
    public function updateItemStatus(Request $request, $id)
    {
        $order = OrderItems::findOrFail($id);
        $order->status = $request->input('status');
        $order->save();

        return redirect()->back()->with('success', 'Order status updated successfully.');
    }
    public function order_paid(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->paid = $request->input('status')??false;
        $order->save();

        return redirect()->back()->with('success', 'Order Paid updated successfully.');
    }


}
