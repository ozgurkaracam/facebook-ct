<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostToTimelineTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function a_user_can_post_a_text_post()
    {
        $this->actingAs($user = \App\Models\User::factory()->create() ,'api');

        $response=$this->post('/api/posts',[
           'body'=>'testing body'
        ]);
        $this->assertCount(1,Post::all());
        $post=\App\Models\Post::first();
        $this->assertEquals('testing body',$post->body);
        $this->assertEquals($post->user_id,$user->id);
        $response->assertStatus(201)->assertJson([
            'data'=>[
                'type'=>'posts',
                'post_id'=>$post->id,
                'attributes'=>[
                    'posted_by'=>[
                      'data'=>[
                          'attributes'=>[
                              'name'=>$user->name
                          ]
                      ]
                    ],
                    'post_body'=>$post->body,
                ],
                'links'=>[
                    'self'=>url('/api/posts/'.$post->id)
                ]

            ]
        ]);
    }


}
