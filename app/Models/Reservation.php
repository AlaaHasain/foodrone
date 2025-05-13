<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'contact_number',
        'email',
        'people',
        'date',
        'time',
        'status',
    ];
    
}
