<?php

namespace Tests\Feature;

use App\Game\ChanceCalculators\HundredChanceCalculator;
use App\Game\ChanceCalculators\ZeroChanceCalculator;
use App\Game\Traits\InteractsWithGame;
use App\RumRunning\Crimes\CrimeFactory;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CrimesTest extends TestCase {

    use DatabaseMigrations, RefreshDatabase, InteractsWithGame;

    private $game;

    protected function setUp(): void
    {
        parent::setUp();

        $this->game = $this->game();

        $this->game->setCrimes(CrimeFactory::createFromArray([
            [
                'code' => 'pickpocket',
                'description' => 'Pick-pocket someone',
                'difficulty' => 0,
                'outcomes' => [
                    'rewards' => [
                        new \App\RumRunning\Rewards\Money(50),
                        new \App\RumRunning\Rewards\Skill(2),
                    ],
                    'punishments' => [
                        new \App\RumRunning\Rewards\Skill(1)
                    ]
                ],
            ]
        ]));
    }

    public function testPlayerCanSuccessfullyCommitACrime()
    {
        $this->seed();

        $player = User::first();

        $crimes = $this->game->crimes();
        $crimeCode = 'pickpocket';

        $crime = $crimes->select($crimeCode);

        $player->setDefaultActionChanceCalculator(new HundredChanceCalculator());
        $outcome = $player->attemptCrime($crime);

        $this->assertTrue($outcome->wasSuccessful());

    }

    public function testPlayerCanFailToCommitACrime()
    {
        $this->seed();

        $player = User::first();

        $crimes = $this->game->crimes();
        $crimeCode = 'pickpocket';

        $crime = $crimes->select($crimeCode);

        $player->setDefaultActionChanceCalculator(new ZeroChanceCalculator());
        $outcome = $player->attemptCrime($crime);

        $this->assertNotTrue($outcome->wasSuccessful());

    }

    public function testPlayerCanCollectRewardsFromCrime()
    {
        $this->seed();

        $player = User::first();

        $crimes = $this->game->crimes();
        $crimeCode = 'pickpocket';

        $crime = $crimes->select($crimeCode);

        $player->setDefaultActionChanceCalculator(new HundredChanceCalculator());
        $outcome = $player->attemptCrime($crime);

        $this->assertSame(50, $player->monies);
        $this->assertSame(0.03, $player->getSkillSetPoints($crime));
    }

    public function testPlayerCanCollectPunishmentsFromCrime()
    {
        $this->seed();

        $player = User::first();

        $crimes = $this->game->crimes();
        $crimeCode = 'pickpocket';

        $crime = $crimes->select($crimeCode);

        $player->setDefaultActionChanceCalculator(new ZeroChanceCalculator());
        $outcome = $player->attemptCrime($crime);

        $this->assertSame(0, $player->monies);
        $this->assertSame(0.02, $player->getSkillSetPoints($crime));
    }
}
