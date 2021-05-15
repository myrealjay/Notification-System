<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class Subscriber extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'topic_id',
        'url'
    ];

    /**
     * returns the topic that this is subscribed to
     *
     * @return BelongsTo
     */
    public function topic() : BelongsTo{
        return $this->belongsTo(Topic::class);
    }
}
