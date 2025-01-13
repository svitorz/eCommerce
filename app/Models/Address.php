<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    protected $fillable = [
        'country',
        'state',
        'city',
        'street',
        'zip_code',
        'number',
        'user_id'
    ];

    public function users(): BelongsTo
    {
        return $this->BelongsTo(User::class);
    }
}
