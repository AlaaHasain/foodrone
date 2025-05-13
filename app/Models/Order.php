<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_type',
        'customer_name',
        'customer_phone',
        'customer_email',
        'pickup_receiver',
        'customer_address',
        'notes',
        'token',
        'pickup_time',
        'payment_method',
        'table_number',
        'status'
    ];
    
    
    public function orderItems()
    {
        return $this->hasMany(\App\Models\OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}