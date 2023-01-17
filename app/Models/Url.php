<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    use HasFactory;

    protected $fillable = [
        'destination',
        'keyword',
        'expiration',
        'title',
        'user_id',
    ];

    protected $casts = [
        'expiration' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
