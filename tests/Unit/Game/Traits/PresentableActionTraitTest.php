<?php

namespace Tests\Unit\Game\Traits;

use App\Game\Traits\PresentableAction;
use Tests\TestCase;

class PresentableActionTraitTest extends TestCase {

    public function testSetCode()
    {
        $presentable = $this->getMockForTrait(PresentableAction::class);

        $this->assertNull($presentable->setCode('test'));
    }

    public function testGetCode()
    {
        $presentable = $this->getMockForTrait(PresentableAction::class);
        $presentable->setCode('test');

        $this->assertSame('test', $presentable->getCode());
    }

    public function testSetDescription()
    {
        $presentable = $this->getMockForTrait(PresentableAction::class);

        $this->assertNull($presentable->setDescription('this is a description'));
    }

    public function testGetDescription()
    {
        $presentable = $this->getMockForTrait(PresentableAction::class);
        $presentable->setDescription('this is a description');

        $this->assertSame('this is a description', $presentable->getDescription());
    }

    public function testSetUserChance()
    {
        $presentable = $this->getMockForTrait(PresentableAction::class);

        $this->assertNull($presentable->setUserChance(25));
    }

    public function testGetUserChance()
    {
        $presentable = $this->getMockForTrait(PresentableAction::class);
        $presentable->setUserChance(10);

        $this->assertSame('10%', $presentable->getUserChance());
    }

    public function testGetUserChanceFromFloat()
    {
        $presentable = $this->getMockForTrait(PresentableAction::class);
        $presentable->setUserChance(0.9);

        $this->assertSame('0%', $presentable->getUserChance());
    }
}
