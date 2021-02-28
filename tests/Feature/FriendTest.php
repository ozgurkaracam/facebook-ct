<?php

namespace Tests\Feature;

use App\Http\Resources\FriendResource;
use App\Models\Friend;
use App\Models\User;
use Tests\TestCase;

class FriendTest extends TestCase
{
    /** @test */
    public function a_user_can_add_a_friend()
    {
        $this->actingAs($user=User::factory()->create(),'api');
        $friend=User::factory()->create();
        $response=$this->post('/api/users/addfriend',['friend_id'=>$friend->id]);
        $response->assertStatus(200);
        $response->assertJson([
            'data'=>[
                'type'=>'users',
                'user_id'=>$friend->id,
                'attributes'=>[
                    'name'=>$friend->name
                ],
                'links'=>[
                    'self'=>url('/users/'.$friend->id)
                ]

            ]
        ]);
    }

    /** @test */
    public function user_can_request_friend_only_valid_users()
    {

        $this->actingAs($user=User::factory()->create(),'api');
        $response=$this->post('/api/users/addfriend',['friend_id'=>2000]);
        $response->assertStatus(404);
        $response->assertJson([
            'error'=>[
                'code'=>404,
                'title'=>'Users not found'
            ]
        ]);
    }

    /** @test */
    public function a_user_can_accept_friend_requests()
    {

        $this->actingAs($user=User::factory()->create(),'api');
        $anotheruser=User::factory()->create();
        $anotheruser->friends()->attach($user);
        $response=$this->post('/api/users/acceptfriend',['friend_id'=>$anotheruser->id]);
        $response->assertStatus(200);
        $response->assertJson([
            'data'=>[
                'type'=>'accept-friend',
                'attributes'=>[
                    'friend'=>[
                        'data'=>[
                            'user_id'=>$anotheruser->id
                        ]
                    ],
                    'confirmed_at'=>date(now()),
                    'status'=>1
                ]
            ]
        ]);
    }

    /** @test */
    public function only_valid_friend_request_can_be_accepted()
    {
        $this->actingAs($user=User::factory()->create(),'api');
        $anotheruser=User::factory()->create();
        $response=$this->post('/api/users/acceptfriend',['friend_id'=>$anotheruser->id]);
        $response->assertStatus(404);
        $response->assertJson([
            'error'=>[
                'code'=>404,
                'title'=>'Friend Request Not Found'
            ]
        ]);
    }

    /** @test */
    public function user_can_retrieve_specific_user_friendship()
    {
        $this->actingAs($user=User::factory()->create(),'api');
        $anotheruser=User::factory()->create();
        $friendRequest=Friend::create([
            'user_id'=>$user->id,
            'friend_id'=>$anotheruser->id,
            'status'=>1,
            'confirmed_at'=>date(now())
        ]);

        $response=$this->get('/api/users/'.$anotheruser->id);
        $response->assertStatus(200);
        $response->assertJson([
            'data'=>[
                'attributes'=>[
                    'name'=>$anotheruser->name,
                    'friendship'=>[
                        'data'=>[
                            'attributes'=>[
                                'status'=>1,
                                'confirmed_at'=>date(now())
                            ]
                        ]
                    ]
                ]

            ]
        ]);
    }

    /** @test */
    public function user_can_pending_friend_requests_only_once()
    {
        $this->actingAs($user=User::factory()->create(),'api');
        $anotheruser=User::factory()->create();
        $this->post('/api/users/addfriend', ['friend_id'=>$anotheruser->id] )->assertStatus(200);
        $response=$this->post('/api/users/addfriend', ['friend_id'=>$anotheruser->id] );
        $this->assertCount(1,$user->friends);
    }
}
