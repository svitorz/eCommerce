<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;

    protected $fillable = ['subtotal', 'status', 'order_date'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'orders_products')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
