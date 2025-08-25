<?php

namespace App\Http\Controllers;

use Midtrans\Config;
use Illuminate\Http\Request;
use Midtrans\Snap;

class PaymentController extends Controller
{
    public function getToken(Request $request)
    {
        $request->validate([
            'city' => 'required|string|max:100',
            'phone' => 'required|string|regex:/^[0-9]{10,15}$/',
            'address' => 'required|string|max:255'
        ], [
            'city.required'    => 'City is required.',
            'phone.required'   => 'Phone number is required.',
            'phone.regex'      => 'Phone number must contain only digits and be 10–15 characters long.',
            'address.required' => 'Address is required.',
        ]);
        Config::$serverKey = config('midtrans.serverKey');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $orderId = rand();

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $request->total,
            ],
            'item_details' => $request->items,
            'customer_details' => [
                'first_name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'billing_address' => [
                    'address' => $request->address
                ],
                'shipping_address' => [
                    'first_name' => $request->name,
                    'phone' => $request->phone,
                    'city' => $request->city,
                    'address' => $request->address,
                ]
            ]
        ];

        $snapToken = Snap::getSnapToken($params);

        return response()->json([
            'snap_token' => $snapToken,
            'order_id' => $orderId
        ]);
    }
}
