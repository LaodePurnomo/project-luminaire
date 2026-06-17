<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomCharacter extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'avatar',
        'personality',
        'first_message',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}