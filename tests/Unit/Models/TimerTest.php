<?php

namespace Tests\Unit\Models;

use App\Timer;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TimerTest extends TestCase {

    use DatabaseMigrations, RefreshDatabase;

    private function player()
    {
        return factory(User::class)->create();
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

    }

    public function testScopeType()
    {

    }
}
