<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class RetrievePostsTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;

    /** @test */
    public function a_user_can_retrieve_posts()
    {
        $this->actingAs($user = User::factory()->create() ,'api');

        $posts=Post::factory()->count(2)->create();
        $response=$this->get('/api/posts');
        $response->assertStatus(200);
        $this->assertCount(2,$posts);
        $response->assertJson([
            'data'=>[
                'data'=>[
                    'type'=>'posts',
                    'post_id'=>$posts[1]->id,
                    'attributes'=>[
                        'post_body'=>$posts[1]->body,
                    ]

                ],
                'data'=>[
                    'type'=>'posts',
                    'post_id'=>$posts[0]->id,
                    'attributes'=>[
                        'post_body'=>$posts[0]->body,
                    ]

                ]
                ],
            'links'=>[
                'self'=>url('/api/posts')
            ]
        ]);
    }



    /** @test */
    public function a_user_can_only_retrieve_their_posts()
    {
        $this->actingAs($user = \App\Models\User::factory()->create() ,'api');
        $posts=Post::factory(['user_id'=>$user->id])->count(2)->create();
        $response=$this->get('/api/user/'.$user->id.'/posts');
        $response->assertStatus(200);
        $response->assertJson([
            'data'=>[
                'type'=>'posts',
                'post_id'=>$posts[0]->id,
                'attributes'=>[
                    'posted_by'=>[
                        'data'=>[
                            'attributes'=>[
                                'name'=>$user->name
                            ]
                        ]
                    ],
                    'post_body'=>$posts[0]->body,
                ],
                'links'=>[
                    'self'=>url('/api/posts/'.$post->id)
                ]

            ]
        ]);
    }
}
