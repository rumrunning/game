<?php

namespace Tests\Feature\Controllers\Game;

use App\Http\Controllers\Game\CrimeController;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class CrimeControllerTest extends TestCase {

    use DatabaseMigrations, WithoutMiddleware;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();

        $this->user = User::first();
    }


    public function testIndex()
    {
        $response = $this->actingAs($this->user)
            ->get('/crimes')
        ;

        $response->assertStatus(200);
    }

    public function testCommit()
    {
        $response = $this->actingAs($this->user)
            ->post('/crimes/commit', [
                'crime' => 'pickpocket'
            ])
        ;

        $response->assertSessionHasAll(['success', 'message']);
        $response->assertStatus(302);
    }

    public function testInvalidCommit()
    {
        $response = $this->actingAs($this->user)
            ->post('/crimes/commit')
        ;

        $response->assertStatus(302);
    }
}
