<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Category;
use Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'price', 'stock','category_id'
    ];


    protected $appends = ['quantity','isFavorite', 'rating_avg','rating_count'];

    protected function getRatingCountAttribute(): int
    {
        return $this->attributes['rating_count'] ?? 0;
    }

    protected function setRatingCountAttribute()
    {
        $this->attributes['rating_count'] = $this->ratingCount();
    }

    protected function getRatingAvgAttribute(): int
    {
        return $this->attributes['rating_avg'] ?? 0;
    }

    protected function setRatingAvgAttribute()
    {
        $this->attributes['rating_avg'] = $this->averageRating();
    }

    protected function getIsFavoriteAttribute(): bool
    {
        return auth()->user()
            ? $this->favoritedByUsers()->where('user_id', auth()->id())->exists()
            : false;
    }

    protected function setIsFavoriteattribute($value)
    {
        $this->attributes['isFavorite'] = $value;
    }


    protected function getQuantityAttribute(): int
    {
        return $this->attributes['quantity'] ?? 1;
    }

    protected function setquantityattribute($value)
    {
        $this->attributes['quantity'] = $value;
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'orders_products')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }

    public function favoritedByUsers()
    {
        return $this->belongsToMany(User::class, 'favorite_products');
    }


    public function ratings(): HasMany
    {
        return $this->hasMany(ProductRating::class);
    }

    public function averageRating()
    {
        return $this->ratings()->avg('rating');
    }

    public function ratingCount(){
        return $this->ratings()->count();
    }
}
