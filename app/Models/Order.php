<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_id',
        'order_date',
        'order_time',
        'city',
        'address',
        'phone',
        'status',
        'total',
        'transaction_id',
        'gross_amount'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function orderDetail(): HasMany
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }
}
