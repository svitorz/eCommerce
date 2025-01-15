<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Category;
use Attribute;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'price', 'stock','category_id'
    ];


    protected $appends = ['quantity'];

    protected function getQuantityAttribute(): int
    {
        return $this->attributes['quantity'];
    }

    protected function setQuantityAttribute($value)
    {
        $this->attributes['quantity'] = $value;
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
