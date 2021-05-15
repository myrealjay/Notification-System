<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'topic_id',
        'content'
    ];

    public function getContentAttribute($value){
        return json_decode($value);
    }

    /**
     * returns the topic this message was published to
     *
     * @return BelongsTo
     */
    public function topic() : BelongsTo{
        return $this->belongsTo(Topic::class);
    }
}
