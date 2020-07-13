<?php

namespace Tests\Unit\Models;

use App\SkillSet;
use App\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SkillSetTest extends TestCase {

    use DatabaseMigrations, RefreshDatabase;

    private function player()
    {
        return User::first();
    }

    public function testPlayer()
    {
        $this->seed();

        $player = $this->player();
        $skillSet = factory(SkillSet::class)->make();

        $skillSet->player()->associate($player)->save();

        $this->assertInstanceOf(BelongsTo::class, $skillSet->player());
        $this->assertInstanceOf(User::class, $skillSet->player);
    }

    public function testScopeGetSkillSet()
    {
        $this->seed();

        $player = $this->player();
        $skillSet = factory(SkillSet::class)->make();

        $skillSet->player()->associate($player)->save();

        $this->assertInstanceOf(BelongsTo::class, $skillSet->player());
        $this->assertInstanceOf(User::class, $skillSet->player);
    }

    public function testGetPointsAttribute()
    {
        $this->seed();

        $player = $this->player();
        $skillSet = factory(SkillSet::class)->make([
            'points' => 0.2
        ]);

        $skillSet->player()->associate($player)->save();

        $this->assertSame(0.2, $skillSet->points);
    }

    public function testSetPointsAttribute()
    {
        $this->seed();

        $player = $this->player();
        $skillSet = factory(SkillSet::class)->make([
            'points' => 0.02
        ]);

        $this->assertSame(20.0, data_get($skillSet->getAttributes(), 'points', null));
    }

    public function testIncreasePoints()
    {
        $this->seed();

        $player = $this->player();
        $skillSet = factory(SkillSet::class)->make([
            'points' => 1
        ]);

        $skillSet->player()->associate($player)->save();
        $skillSet->increasePoints(50);

        $this->assertSame(51, $skillSet->points);
    }
}
