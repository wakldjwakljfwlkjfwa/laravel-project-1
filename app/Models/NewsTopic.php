<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class NewsTopic extends Pivot
{
    use HasFactory;

    protected $table = 'news_topics';

    protected $fillable = [
        'news_id',
        'topic_id',
    ];

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    public function news(): BelongsTo
    {
        return $this->belongsTo(News::class);
    }
}
