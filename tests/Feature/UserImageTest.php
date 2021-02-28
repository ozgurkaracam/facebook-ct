<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class UserImageTest extends TestCase
{
    /** @test */
    public function user_get_own_photos()
    {
        $this->withoutExceptionHandling();
        $this->actingAs($user=User::factory()->create(),'api');
        $image1=$user->images()->create(['type'=>'profile','image'=>'profilephoto']);
        $image2=$user->images()->create(['type'=>'cover','image'=>'coverphoto']);
        $response=$this->get('/api/users/'.$user->id.'/images');
        $response->assertStatus(200);
        $this->assertCount(2,$user->images);
        $response->assertJson([
            'data'=>[
                'type'=>'images',
                'data'=>[
                    [
                        'data'=>[
                            'image_id'=>$image1->id,
                            'type'=>'image',
                            'user_id'=>$image1->user_id,
                            'attributes'=>[
                                'type'=>$image1->type,
                                'image_path'=>$image1->image,
                                'width'=>$image1->width,
                                'height'=>$image1->height
                            ],
                            'links'=>[
                                'self'=>'/api/users/'.$image1->user_id.'/images/'.$image1->id
                            ]
                        ]
                    ],
                    [
                        'data'=>[
                            'image_id'=>$image2->id,
                            'type'=>'image',
                            'user_id'=>$image2->user_id,
                            'attributes'=>[
                                'type'=>$image2->type,
                                'image_path'=>$image2->image,
                                'width'=>$image2->width,
                                'height'=>$image2->height
                            ],
                            'links'=>[
                                'self'=>'/api/users/'.$image2->user_id.'/images/'.$image2->id
                            ]
                        ]
                    ]
                ],
                'links'=>[
                    'self'=>'/api/users/1/images'
                ]
            ]
        ]);
    }

    /** @test */
    public function user_can_retrieve_own_profile_photo()
    {
        $this->actingAs($user=User::factory()->create(),'api');
        $image1=$user->images()->create(['type'=>'profile','image'=>'profilephoto']);
        $response=$this->get('/api/users/'.$user->id.'/images/profile');
        $response->assertStatus(200);
        $response->assertJson([
            'data'=>[
                'image_id'=>$image1->id,
                'type'=>'image',
                'user_id'=>$image1->user_id,
                'attributes'=>[
                    'type'=>$image1->type,
                    'image_path'=>$image1->image,
                    'width'=>$image1->width,
                    'height'=>$image1->height
                ],
                'links'=>[
                    'self'=>'/api/users/'.$image1->user_id.'/images/'.$image1->id
                ]
            ]
        ]);
    }

    /** @test */
    public function user_can_retrieve_own_cover_photo()
    {
        $this->actingAs($user=User::factory()->create(),'api');
        $image1=$user->images()->create(['type'=>'cover','image'=>'coverphoto']);
        $response=$this->get('/api/users/'.$user->id.'/images/cover');
        $response->assertStatus(200);
        $response->assertJson([
            'data'=>[
                'image_id'=>$image1->id,
                'type'=>'image',
                'user_id'=>$image1->user_id,
                'attributes'=>[
                    'type'=>$image1->type,
                    'image_path'=>$image1->image,
                    'width'=>$image1->width,
                    'height'=>$image1->height
                ],
                'links'=>[
                    'self'=>'/api/users/'.$image1->user_id.'/images/'.$image1->id
                ]
            ]
        ]);
    }
    /** @test */
    public function user_can_post_own_profile_image()
    {
        $this->withoutExceptionHandling();

        $file=UploadedFile::fake()->image('foo.jpg',250,250);
        $this->actingAs($user = User::factory()->create(), 'api');
        $this->post('/api/users/'.$user->id.'/images',['image'=>$file,'type'=>'profile','width'=>300])
            ->assertStatus(201)
            ->assertJson([
                'data'=>[
                    'type'=>'image',
                    'user_id'=>$user->id,
                    'attributes'=>[
                        'type'=>'profile',
                        'width'=>300,
                    ],
                ]
            ]);
    }

    /** @test */
    public function user_can_post_own_cover_image()
    {
        $this->withoutExceptionHandling();

        $file=UploadedFile::fake()->image('foo.jpg',700,300);
        $this->actingAs($user = User::factory()->create(), 'api');
        $this->post('/api/users/'.$user->id.'/images',['image'=>$file,'type'=>'cover','width'=>700])
            ->assertStatus(201)
            ->assertJson([
                'data'=>[
                    'type'=>'image',
                    'user_id'=>$user->id,
                    'attributes'=>[
                        'type'=>'cover',
                        'width'=>700,
                    ],
                ]
            ]);
    }
}
