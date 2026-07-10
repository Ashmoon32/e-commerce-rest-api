<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Http\Requests\OrderRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // Place Order (Checkout)
    public function store(OrderRequest $request)
    {
        $user = $request->user();
        $cart = Cart::where('user_id', $user->id)->first();

        if (!$cart || $cart->items->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cart is empty'
            ], 422);
        }

        // Transaction: All or Nothing
        $order = DB::transaction(function () use ($user, $cart, $request) {
            // Calculate total
            $total = $cart->items->sum(function ($item) {
                return $item->quantity * $item->product->price;
            });

            // Create Order
            $order = Order::create([
                'user_id' => $user->id,
                'total_amount' => $total,
                'status' => 'pending',
                'shipping_address' => $request->shipping_address,
                'payment_method' => $request->payment_method,
            ]);

            // Create Order Items & Reduce Stock
            foreach ($cart->items as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price_at_time' => $cartItem->product->price,
                ]);

                // Reduce stock
                $product = $cartItem->product;
                $product->stock_quantity -= $cartItem->quantity;
                $product->save();
            }

            // Clear Cart
            $cart->items()->delete();

            return $order;
        });

        return response()->json([
            'status' => 'success',
            'data' => [
                'order_id' => $order->id,
                'total_amount' => (string) $order->total_amount,
                'status' => $order->status,
                'shipping_address' => $order->shipping_address,
                'payment_method' => $order->payment_method,
                'created_at' => $order->created_at?->format('Y-m-d H:i:s'),
            ]
        ], 201);
    }

    // My Orders List
    public function index(Request $request)
    {
        $orders = Order::where('user_id', $request->user()->id)
            ->latest()
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $orders->map(function ($order) {
                return [
                    'id' => $order->id,
                    'total_amount' => (string) $order->total_amount,
                    'status' => $order->status,
                    'created_at' => $order->created_at?->format('Y-m-d H:i:s'),
                ];
            })
        ]);
    }

    // Order Detail
    public function show(Request $request, Order $order)
    {
        // Authorization: Only owner can view
        if ($order->user_id !== $request->user()->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 403);
        }

        $order->load('items.product');

        return response()->json([
            'status' => 'success',
            'data' => [
                'id' => $order->id,
                'total_amount' => (string) $order->total_amount,
                'status' => $order->status,
                'shipping_address' => $order->shipping_address,
                'payment_method' => $order->payment_method,
                'items' => $order->items->map(function ($item) {
                    return [
                        'product_name' => $item->product->name,
                        'quantity' => $item->quantity,
                        'price_at_time' => (string) $item->price_at_time,
                        'subtotal' => (string) ($item->quantity * $item->price_at_time),
                    ];
                }),
                'created_at' => $order->created_at?->format('Y-m-d H:i:s'),
            ]
        ]);
    }
}