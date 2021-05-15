<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = [
        'title'
    ];

    /**
     * returns the messages associated with this topic
     *
     * @return HasMany
     */
    public function messages() : HasMany{
        return $this->hasMany(Message::class);
    }

    /**
     * returns all subscribers associated with this topic
     *
     * @return HasMany
     */
    public function subscribers() : HasMany{
        return $this->hasMany(Subscriber::class);
    }
}
