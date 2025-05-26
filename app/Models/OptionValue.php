<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OptionValue extends Model
{
protected $fillable = ['option_id', 'value', 'additional_price', 'description'];

    public function option()
    {
        return $this->belongsTo(Option::class);
    }

    public function menuItems()
    {
        return $this->belongsToMany(MenuItem::class, 'menu_item_option_value')
                    ->withTimestamps();
    }

}
