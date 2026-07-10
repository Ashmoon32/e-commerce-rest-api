<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartItemRequest;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = $this->getOrCreateCart($request->user()->id);

        return response()->json([
            'status' => 'success',
            'data' => new CartResource($cart),
        ]);
    }

    public function add(CartItemRequest $request)
    {
        $cart = $this->getOrCreateCart($request->user()->id);

        $existingItem = CartItem::where('cart_id', $cart->id)
        ->where('product_id', $request->product_id)
        ->first();

        if ($existingItem) {
            $existingItem->quantity += $request->quantity;
            $existingItem->save();
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }

        return $this->index($request);
    }

    public function update(Request $request, CartItem $cartItem)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return $this->index($request);
    }

    public function remove(Request $request, CartItem $cartItem)
    {
        $cartItem->delete();
        
        return response()->json([
            'status' => 'success',
            'message' => 'Item removed from cart',
        ]);
    }

    // Helper method to get or create a cart for the user
    private function getOrCreateCart($userId)
    {
        return Cart::firstOrCreate(['user_id' => $userId]);
    }
}
