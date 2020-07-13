<?php

namespace Tests\Unit\RumRunning\Repositories;

use App\Game\Contracts\TimerRepositoryContract;
use App\Game\Exceptions\InvalidTimerException;
use App\RumRunning\Crimes\Crime;
use App\RumRunning\Repositories\EloquentTimerRepository;
use App\Timer;
use App\User;
use Illuminate\Support\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EloquentTimerRepositoryTest extends TestCase {

    use DatabaseMigrations, RefreshDatabase;

    private function configuredTimers()
    {
        return [
            Crime::class
        ];
    }

    private function timerModel()
    {
        return new Timer();
    }

    public function test__construct()
    {
        $timerRepo = new EloquentTimerRepository($this->timerModel(), $this->configuredTimers());

        $this->assertInstanceOf(EloquentTimerRepository::class, $timerRepo);
        $this->assertInstanceOf(TimerRepositoryContract::class, $timerRepo);
    }

    public function testForPlayer()
    {
        $timerRepo = new EloquentTimerRepository($this->timerModel(), $this->configuredTimers());

        $this->assertInstanceOf(EloquentTimerRepository::class, $timerRepo->forPlayer(
           factory(User::class)->make()
        ));
    }

    public function testSetUntil()
    {
        $this->seed();

        $player = User::first();

        $now = Carbon::now();
        $expectedTimerTime = $now->addSeconds(30);

        $timerRepo = new EloquentTimerRepository($this->timerModel(), $this->configuredTimers());
        $timerRepo->forPlayer($player)->setUntil(Crime::class, $expectedTimerTime);

        $timer = $player->timers()->type(Crime::class)->first();

        $this->assertSame($expectedTimerTime->toW3cString(), $timer->ends_at->toW3cString());
    }

    public function testSetUntilDoesNotDuplicate()
    {
        $this->seed();

        $player = User::first();

        $expectedTimerTime = Carbon::now()->addSeconds(30);
        $expectedExtendedTimerTime = Carbon::now()->addSeconds(60);

        $timerRepo = new EloquentTimerRepository($this->timerModel(), $this->configuredTimers());

        // Attempt to create 2 records. This should instead update the first
        $timerRepo->forPlayer($player)->setUntil(Crime::class, $expectedTimerTime);
        $timerRepo->forPlayer($player)->setUntil(Crime::class, $expectedExtendedTimerTime);

        $timers = $player->timers()->type(Crime::class)->get();
        $timer = $timers->first();

        $this->assertCount(1, $timers);
        $this->assertSame($expectedExtendedTimerTime->startOfSecond()->toW3cString(), $timer->getEndsAt()->toW3cString());
        $this->assertNotSame($expectedTimerTime->startOfSecond()->toW3cString(), $timer->getEndsAt()->toW3cString());
    }

    public function testSetBadUntil()
    {
        $this->expectException(InvalidTimerException::class);

        $this->seed();

        $player = User::first();

        $now = Carbon::now();
        $expectedTimerTime = $now->addSeconds(30);

        $timerRepo = new EloquentTimerRepository($this->timerModel(), $this->configuredTimers());
        $timerRepo->forPlayer($player)->setUntil('INVALID_TIMER', $expectedTimerTime);
    }
}
