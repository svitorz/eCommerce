<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    //
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
