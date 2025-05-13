<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FooterInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'about',
        'working_hours',
        'address',
        'phone',
        'email',
        'facebook',
        'instagram',
        'whatsapp',
        'copyright',
    ];
}