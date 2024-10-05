<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\belongsToMany;
use App\Models\ChatMembers;
use App\Models\User;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'owner_id'];

    public function members(): belongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function owner() : HasOne {
        return $this->hasOne(User::class, 'id', 'owner_id');
    }
}
