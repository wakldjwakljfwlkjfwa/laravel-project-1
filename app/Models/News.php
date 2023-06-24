<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'announcement',
        'content',
        'published_at',
        'author_id',
    ];

    public function topics(): BelongsToMany
    {
        return $this->belongsToMany(Topic::class, 'news_topics');
    }
}
