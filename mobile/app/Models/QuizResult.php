<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizResult extends Model
{
    protected $fillable = [
        'user_id', 
        'user_name', 
        'score', 
        'logs', 
        'answers', 
        'ip_address', 
        'device_info'
    ];

    protected $casts = [
        'logs' => 'array',
        'answers' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
