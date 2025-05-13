<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurant_name',
        'tagline',
        'logo',
        'currency',
        'timezone',
        'admin_email',
    ];
}
