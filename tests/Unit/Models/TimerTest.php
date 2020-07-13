<?php

namespace Tests\Unit\Models;

use App\RumRunning\Crimes\Crime;
use App\Timer;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TimerTest extends TestCase {

    use DatabaseMigrations, RefreshDatabase;

    private function player()
    {
        return User::first();
    }

    public function testPlayer()
    {
        $this->seed();

        $player = $this->player();
        $timer = factory(Timer::class)->make();

        $timer->player()->associate($player)->save();

        $this->assertInstanceOf(BelongsTo::class, $timer->player());
        $this->assertInstanceOf(User::class, $timer->player);
    }

    public function testScopeForPlayer()
    {
        $this->seed();
        $player = $this->player();
        $timer = factory(Timer::class)->make();

        $timer->player()->associate($player)->save();

        $queryBuilder = $timer->forPlayer($player);

        $this->assertInstanceOf(Builder::class, $queryBuilder);
    }

    public function testScopeType()
    {
        $this->seed();
        $player = $this->player();
        $timer = factory(Timer::class)->make();

        $timer->player()->associate($player)->save();

        $queryBuilder = $timer->type(Crime::class);

        $this->assertInstanceOf(Builder::class, $queryBuilder);
    }

    public function testEndsAtCastsAsCarbon()
    {
        $this->seed();
        $player = $this->player();
        $timer = factory(Timer::class)->make();

        $timer->player()->associate($player)->save();

        $this->assertInstanceOf(Carbon::class, $timer->ends_at);
    }
}
