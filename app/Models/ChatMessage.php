<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Chat;

class ChatMessage extends Model
{
    use HasFactory;
    protected $fillable = ['chat_id', 'user_id', 'message'];

    public function chat(){
        return $this->belongsTo(Chat::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
