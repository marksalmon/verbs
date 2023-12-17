<?php

use Thunk\Verbs\Attributes\Autodiscovery\StateId;
use Thunk\Verbs\Event;
use Thunk\Verbs\State;

it('can retreive unaliased different states by type', function () {

    $event = EventWithUnaliasedDifferentStates::fire(
        state_one_id: 111111,
        state_two_id: 222222,
    );

    expect($event->states())->toHaveCount(2);
    expect($event->states()->aliases)->toHaveCount(0);
    expect($event->state(ArbitraryStateOne::class)->id)->toBe(111111);
    expect($event->state(ArbitraryStateTwo::class)->id)->toBe(222222);
});

it('can retreive aliased different states by type', function () {

    $event = EventWithAliasedDifferentStates::fire(
        state_one_id: 111111,
        state_two_id: 222222,
    );

    expect($event->states())->toHaveCount(2);
    expect($event->states()->aliases)->toHaveCount(2);
    expect($event->state(ArbitraryStateOne::class)->id)->toBe(111111);
    expect($event->state(ArbitraryStateTwo::class)->id)->toBe(222222);
});

it('can retreive aliased different states by alias', function () {

    $event = EventWithAliasedDifferentStates::fire(
        state_one_id: 111111,
        state_two_id: 222222,
    );

    expect($event->states())->toHaveCount(2);
    expect($event->states()->aliases)->toHaveCount(2);
    expect($event->state('one')->id)->toBe(111111);
    expect($event->state('two')->id)->toBe(222222);
});

it('can retrieve specific instances of similar state by alias', function () {

    $event = EventWithAliasedSimilarStates::fire(
        state_one_id: 111111,
        state_two_id: 222222,
    );

    expect($event->states())->toHaveCount(2);
    expect($event->states()->aliases)->toHaveCount(2);
    expect($event->state('one')->id)->toBe(111111);
    expect($event->state('two')->id)->toBe(222222);
});

class ArbitraryStateOne extends State
{
}

class ArbitraryStateTwo extends State
{
}

class EventWithUnaliasedDifferentStates extends Event
{
    #[StateId(ArbitraryStateOne::class)]
    public ?int $state_one_id = null;

    #[StateId(ArbitraryStateTwo::class)]
    public ?int $state_two_id = null;
}

class EventWithAliasedDifferentStates extends Event
{
    #[StateId(ArbitraryStateOne::class, 'one')]
    public ?int $state_one_id = null;

    #[StateId(ArbitraryStateTwo::class, 'two')]
    public ?int $state_two_id = null;
}

class EventWithAliasedSimilarStates extends Event
{
    #[StateId(ArbitraryStateOne::class, 'one')]
    public ?int $state_one_id = null;

    #[StateId(ArbitraryStateOne::class, 'two')]
    public ?int $state_two_id = null;
}
