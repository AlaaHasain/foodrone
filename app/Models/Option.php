<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\OptionValue;


class Option extends Model
{
    protected $fillable = ['name', 'type'];

    public function menuItems()
    {
        return $this->belongsToMany(MenuItem::class, 'menu_item_option')
                    ->withTimestamps();
    }

    public function values()
    {
        return $this->hasMany(OptionValue::class);
    }

}
