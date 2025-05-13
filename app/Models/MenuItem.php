<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'category',
        'is_offer',
        'old_price',
        'offer_price',
        'category_id',
    ];
    
    protected $casts = [
        'is_offer' => 'boolean',
        'price' => 'float',
        'old_price' => 'float',
        'offer_price' => 'float'
    ];
    
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}