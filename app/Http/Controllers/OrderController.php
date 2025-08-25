<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function OrderShow($id = null)
    {
        if ($id) {
            $order = Order::with(['orderDetail.food'])->where('user_id', auth()->id())->findOrFail($id);
            return response(['data' => $order, 'status' => '200', 'messages' => 'Order Berhasil Ditampilkan']);
        } else {
            $orders = Order::where('user_id', auth()->id())->get();
            return response(['data' => $orders, 'status' => '200', 'messages' => 'Order Berhasil Ditampilkan']);
        }
    }

    public function OrderStore(Request $request)
    {
        $order = Order::create([
            'user_id' => auth()->id(),
            'order_date' => now()->toDateString(),
            'order_time' => now()->format('H:i:s'),
            'city' => $request->city,
            'address' => $request->address,
            'phone' => $request->phone,
            'status' => 'confirmed',
            'total' => $request->total,
            'transaction_id' => $request->transaction_id,
            'order_id' => $request->order_id,
            'gross_amount' => $request->gross_amount
        ]);

        foreach ($request->items as $item) {
            $order->orderDetail()->create([
                'food_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'total_price' => $item['price'] * $item['quantity']
            ]);
        }

        return response()->json([
            'message' => 'Order Created',
            'data' => [$order, $order->orderDetail]
        ]);
    }
}
