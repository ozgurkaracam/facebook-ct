<?php

namespace Tests\Feature;

use App\Http\Resources\Comment;
use App\Models\Post;
use http\Client\Curl\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentTest extends TestCase
{
   /** @test */
    public function user_can_comment_a_post()
    {
        $this->actingAs($user= \App\Models\User::factory()->create(), 'api');
        $post=Post::factory()->create();
        $response=$this->post('/api/posts/'.$post->id.'/comments',['comment_body'=>'deneme']);
        $comment=\App\Models\Comment::all()->first();
        $response->assertStatus(201);
        $response->assertJson([
            'data'=>[
                'comment_id'=>$comment->id,
                'type'=>'comments',
                'attributes'=>[
                    'data'=>[
                        'comment_body'=>$comment->body,
                        'post_id'=>$comment->post_id,
                        'created_at'=>$comment->created_at->diffForHumans(),
                        'posted_by'=>[
                            'data'=>[
                                'user_id'=>$user->id
                            ]
                        ]
                    ]
                ],
                'links'=>[
                    'self'=>'/api/posts/'.$comment->id.'/comments'
                ]
            ]
        ]);
    }
    /** @test */
    public function user_can_retrieve_post_comments()
    {
        $this->actingAs($user=\App\Models\User::factory()->create(),'api');
        $post=$user->posts()->create([
            'body'=>'deneme'
        ]);
        $comment=$post->comments()->create([
            'body'=>'deneme yorum',
            'user_id'=>$user->id
        ]);
        $comment2=$post->comments()->create([
            'body'=>'deneme yorum 2',
            'user_id'=>$user->id
        ]);
        $response=$this->get('/api/posts/'.$post->id.'/comments');
        $response->assertStatus(200);
//        $this->assertCount(2,$post->comments()->get()->count());
        $response->assertJson([
            'data'=>[
                'type'=>'comments',
                'comments_count'=>2,
                'data'=>[
                    [
                        'data'=>[
                            'comment_id'=>$comment->id,
                            'attributes'=>[
                                'data'=>[
                                    'comment_body'=>$comment->body,
                                    'post_id'=>$comment->post_id,
                                    'created_at'=>$comment->created_at->diffForHumans(),
                                    'posted_by'=>[
                                        'data'=>[
                                            'user_id'=>$user->id
                                        ]
                                    ]
                                ]
                            ]
                        ],
                        'data'=>[
                            'comment_id'=>$comment2->id,
                            'attributes'=>[
                                'data'=>[
                                    'comment_body'=>$comment2->body,
                                    'post_id'=>$comment2->post_id,
                                    'created_at'=>$comment2->created_at->diffForHumans(),
                                    'posted_by'=>[
                                        'data'=>[
                                            'user_id'=>$user->id
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]);
    }
}
