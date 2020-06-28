<?php

namespace Tests\Unit\Models;

use App\Game\Traits\InteractsWithGame;
use App\RumRunning\Crimes\Crime;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase {

    use DatabaseMigrations, RefreshDatabase, InteractsWithGame;

    public function testAttemptCrime()
    {
        $this->seed();

        $user = User::first();
        $crime = $this->game()->getCrimes()->first();

        dd($user->attemptCrime($crime));
    }

    public function testGetSkill()
    {
        $this->seed();

        $user = User::first();

        $this->assertEquals(0.9, $user->getSkill(Crime::class));
    }
}
