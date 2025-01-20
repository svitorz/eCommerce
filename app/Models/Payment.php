<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'full_name',
        'ccv',
        'card_number',
        'card_expiration',
        'order_id',
    ];

    public function orders(): BelongsTo
    {
        return $this->BelongsTo(Order::class);
    }
}
