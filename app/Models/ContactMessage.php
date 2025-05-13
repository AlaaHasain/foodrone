<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContactMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'phone', 'message', 'is_read' // ➔ ضفنا is_read هون كمان
    ];
    
    public function replies()
{
    return $this->hasMany(Reply::class);
}
    
}
