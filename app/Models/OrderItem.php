<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'menu_item_id',
        'quantity',
        'price',
        'options'
    ];
    
    public function order()
    {
        return $this->belongsTo(\App\Models\Order::class);
    }
    
    public function menuItem()
    {
        return $this->belongsTo(\App\Models\MenuItem::class);
    }
}