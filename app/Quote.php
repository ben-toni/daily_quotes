<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property $description
 * @property $subscribers
 */
class Quote extends Model
{
    protected $guarded = [];

    public function subscribers()
    {
        return $this->belongsToMany(Subscriber::class, 'subscriber_quote', 'quote_id', 'subscriber_id');
    }
}
