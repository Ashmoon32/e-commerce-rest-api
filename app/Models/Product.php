<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'stock_quantity',
        'category_id',
        'image_urls',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'image_urls' => 'array',
    ];

    public function category() : BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function cartItems() : HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems() : HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    protected static function boot() 
    {
        parent::boot();

        static::creating(function($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }
}
