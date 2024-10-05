<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\User;

class ChatUser extends Model
{
    use HasFactory;

    protected $table = 'chat_user';
    protected $fillable = ['user_id', 'role_id','chat_id'];

    public function user() : HasOne {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
