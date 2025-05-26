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
    'is_featured', // ✅ أضف هذا السطر
    'is_popular',
    'old_price',
    'offer_price',
    'category_id',
];

    
 protected $casts = [
    'is_offer' => 'boolean',
    'is_featured' => 'boolean',   // ✅ أضف هذا
    'is_popular' => 'boolean',    // ✅ أضف هذا
    'price' => 'float',
    'old_price' => 'float',
    'offer_price' => 'float',
];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function options()
    {
        return $this->belongsToMany(Option::class, 'menu_item_option')->with('values');
                    // ->withTimestamps();
    }

    public function optionValues()
    {
        return $this->belongsToMany(OptionValue::class, 'menu_item_option_value')
                    ->withTimestamps();
    }

}