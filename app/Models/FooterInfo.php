<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FooterInfo extends Model
{
    use HasFactory;

protected $fillable = [
    'about', 'about_ar',
    'working_hours', 'working_hours_ar',
    'copyright', 'copyright_ar',
    'address', 'phone', 'email',
    'facebook', 'instagram', 'whatsapp'
];

}