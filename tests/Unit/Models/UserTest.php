<?php

namespace Tests\Unit\Models;

use App\Game\Outcome;
use App\Game\Traits\InteractsWithGame;
use App\RumRunning\Crimes\Crime;
use App\RumRunning\Rewards\Skill;
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
        $crime = $this->game()->crimes()->first();

        $this->assertInstanceOf(Outcome::class, $user->attemptCrime($crime));
    }

    public function testCollectClaimsForCrime()
    {
        $this->seed();

        $user = User::first();
        $crime = $this->game()->crimes()->first();

        $skillPointIncrease = 0;
        $initalSkillPoints = $user->getSkillSetPoints(get_class($crime));

        $outcome = $user->attemptCrime($crime);
        $claims = $outcome->claims();

        $user->collectClaimsFor($crime, $claims);

        foreach ($claims as $claim) {
            if ($claim->getCollectable() instanceof Skill) {
                $skillPointIncrease += $claim->getValue();
            }
        }

        $this->assertSame($user->getSkillSetPoints(get_class($crime)), $initalSkillPoints + $skillPointIncrease);
    }

    public function testGetSkill()
    {
        $this->seed();

        $user = User::first();

        $this->assertEquals(0.01, $user->getSkillSetPoints(Crime::class));
    }
}
