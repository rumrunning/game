<?php

namespace Tests\Unit\RumRunning\Rewards;

use Mockery;
use Tests\TestCase;
use App\RumRunning\Rewards\Skill;

class SkillTest extends TestCase {

    public function test__constructor()
    {
        $skill = new Skill(100);

        $this->assertInstanceOf(Skill::class, $skill);
        $this->assertSame(0.1, $skill->prepareForCollection());
    }

    public function test__constructorOptionalArgs()
    {
        $skill = new Skill(10, 11);

        $this->assertInstanceOf(Skill::class, $skill);
        $this->assertContains($skill->prepareForCollection(), [0.01, 0.011]);
    }

    public function testCollect()
    {
        $this->partialMock(Skill::class, function (Mockery\MockInterface $mock) {
            $mock->shouldAllowMockingProtectedMethods()
                ->shouldReceive('randomReward')
                ->andReturn(10)
            ;
        });

        $collected = $this->app->get(Skill::class)->prepareForCollection();

        $this->assertSame(0.01, $collected);
    }
}
