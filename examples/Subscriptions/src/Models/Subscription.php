<?php

namespace Thunk\Verbs\Examples\Subscriptions\Models;

use Glhd\Bits\Database\HasSnowflakes;
use Illuminate\Database\Eloquent\Model;
use Thunk\Verbs\Examples\Subscriptions\Events\SubscriptionCancelled;
use Thunk\Verbs\FromState;

class Subscription extends Model
{
    use FromState;
    use HasSnowflakes;

    protected $casts = [
        'is_active' => 'bool',
        'cancelled_at' => 'datetime',
    ];

    public function cancel()
    {
        SubscriptionCancelled::fire(subscription_id: $this->id);
    }
}
