<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class UserRetrieveOwnDataTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;
    /** @test */
    public function user_can_retrieve_own_datas()
    {
        $this->actingAs($user=\App\Models\User::factory()->create());
        $response=$this->get('/api/users/'.$user->id)->assertStatus(200);
        $response->assertJson([
            'data'=>[
                'type'=>'users',
                'user_id'=>$user->id,
                'attributes'=>[
                    'name'=>$user->name
                ],
                'links'=>[
                    'self'=>url('/users/'.$user->id)
                ]

            ]
        ]);

    }
}
