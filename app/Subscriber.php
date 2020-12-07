<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property $status
 * @property $email
 * @property $quotes
 * @method active($query)
*/
class Subscriber extends Model
{
    const ACTIVE_STATUS = 'ACTIVE';
    const INACTIVE_STATUS = 'INACTIVE';
    const UNPAID_STATUS = 'UNPAID';

    protected $guarded = [];

    public function scopeActive($query)
    {
        return $query->where('status', self::ACTIVE_STATUS);
    }

    public function quotes()
    {
        return $this->belongsToMany(Quote::class, 'subscriber_quote', 'subscriber_id', 'quote_id')->withTimestamps()->withPivot('subscriber_id');
    }
}
