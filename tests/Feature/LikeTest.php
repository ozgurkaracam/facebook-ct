<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LikeTest extends TestCase
{
    /** @test */
    public function user_can_like_a_post()
    {
        $this->actingAs($user=User::factory()->create(), 'api');
        $post=Post::factory()->create();
        $repsonse=$this->post('/api/likes',['post_id'=>$post->id]);
        $repsonse->assertStatus(200);
        $repsonse->assertJson([
            'data'=>[
                'type'=>'posts',
                'post_id'=>$post->id,
                'attributes'=>[
                    'post_body'=>$post->body,
                    'post_created_date'=>$post->date,
                    'image'=>$post->image,
                    'likes_count'=>1,
                    'like_status'=>true
                ],
                'links'=>[
                    'self'=>url('/api/posts/'.$post->id)
                ]

            ]
        ]);
    }
}
