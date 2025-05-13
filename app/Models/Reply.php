<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;

    protected $fillable = [
        'contact_message_id',
        'content',
        'sender_type', // إضافة هذا الحقل
    ];

    public function contactMessage()
    {
        return $this->belongsTo(ContactMessage::class);
    }
}