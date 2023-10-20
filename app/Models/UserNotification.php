<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    protected $fillable = [
        'user_id', 'title', 'message', 'link', 'read_at', 'created_by', 'updated_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
