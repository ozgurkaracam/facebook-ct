<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class PostToTimelineTest extends TestCase
{
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

    /** @test */
    public function user_can_send_image_post()
    {
        $this->withoutExceptionHandling();
        $this->actingAs($user = \App\Models\User::factory()->create() ,'api');
        $file=UploadedFile::fake()->image('foo.jpg',500,500);
        $response=$this->post('/api/posts',[

            'image'=>$file,
            'body'=>'testing body',
        ]);
        $response->assertStatus(201)->assertJson([
            'data'=>[
                'type'=>'posts',
                'attributes'=>[
                    'posted_by'=>[
                        'data'=>[
                            'attributes'=>[
                                'name'=>$user->name
                            ]
                        ]
                    ],
                    'post_body'=>'testing body',
                    'post_image'=>url('images/'.$file->hashName())
                ]

            ]
        ]);
    }


}
