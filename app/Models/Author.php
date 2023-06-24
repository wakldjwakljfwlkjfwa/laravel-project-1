<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Author extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'avatar',
    ];

    public function user(): BelongsTo|null
    {
        return $this->belongsTo(User::class);
    }

    public function email(): string|null
    {
        return $this->user->email ?? null;
    }
}
