<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $items = $this->items()->with('product')->get();

        $total = $items->sum(fn($item) => $item->quantity * $item->product->price);

        return [
            'cart_id' => $this->id,
            'items' => $items->map(fn($item) => [
                'id' => $item->id,
                'product_id' => $item->product_id,
                'name' => $item->product->name,
                'price' => (string) $item->product->price,
                'quantity' => $item->quantity,
                'subtotal' => (string) ($item->quantity * $item->product->price),
            ]),
            'total' => (string) $total,
        ];
    }
}
