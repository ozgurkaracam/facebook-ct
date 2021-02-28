<?php

namespace Tests\Feature;

use http\Client\Curl\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class UserRetrieveOwnData extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;
    /** @test */
    public function user_can_retrieve_own_datas()
    {
        $this->actingAs($user=\App\Models\User::factory()->create());
        $this->get('/api/users/'.$user->id)->assertStatus(200);

    }
}
