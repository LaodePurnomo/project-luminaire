<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatHistory extends Model
{
    protected $fillable = [
        'user_id',
        'character',
        'role',
        'content',
        'is_flagged',
        'flag_reason',
    ];

    protected function casts(): array
    {
        return [
            'is_flagged' => 'boolean',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}