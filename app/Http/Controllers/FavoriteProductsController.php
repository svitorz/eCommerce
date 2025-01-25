<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;

class FavoriteProductsController extends Controller
{
    public function store(User $user, Product $product): void
    {
        if(!$this->isFavorite($user,$product))
        {
            $user->favoriteProducts()->attach($product);
        }
    }

    public function destroy(User $user, Product $product): void
    {
        if($this->isFavorite($user,$product)){
            $user->favoriteProducts()->detach($product);
        }
    }

    public function isFavorite(User $user, Product $product): bool
    {
        return $user->favoriteProducts->contains($product);
    }
}
