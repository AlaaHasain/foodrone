<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;

    protected $fillable = [
        'table_number',
        'qr_token',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($table) {
            $table->qr_token = bin2hex(random_bytes(10));
        });
    }
    
}
