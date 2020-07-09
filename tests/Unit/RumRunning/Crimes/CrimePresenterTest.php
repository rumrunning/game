<?php

namespace Tests\Unit\RumRunning\Crimes;

use App\RumRunning\Crimes\Crime;
use App\RumRunning\Crimes\CrimePresenter;
use Tests\TestCase;

class CrimePresenterTest extends TestCase {

    private function crime()
    {
        return new Crime('pickpocket', 'Pickpocket someone', 0.1, []);
    }

    public function test__construct()
    {
        $presenter = new CrimePresenter($this->crime());

        $this->assertInstanceOf(CrimePresenter::class, $presenter);
    }

    public function testToArray()
    {
        $presenter = new CrimePresenter($this->crime());

        $presenterArray = $presenter->toArray();

        $this->assertIsArray($presenterArray);

        $this->assertArrayHasKey('code', $presenterArray);
        $this->assertArrayHasKey('description', $presenterArray);
        $this->assertArrayHasKey('user_chance', $presenterArray);

        $this->assertNull($presenterArray['code']);
        $this->assertNull($presenterArray['description']);
        $this->assertSame('0%', $presenterArray['user_chance']);

    }
}
