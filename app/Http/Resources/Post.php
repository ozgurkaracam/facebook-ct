<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Post extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
        'data'=>[
            'type'=>'posts',
            'post_id'=>$this->id,
            'attributes'=>[
                'posted_by'=>new UserResource($this->user),
                'post_body'=>$this->body,
                'post_created_date'=>$this->date,
                'post_image'=>$this->image ? url('images/'.$this->image) : null,
                'likes_count'=>$this->likes_count,
                'like_status'=>$this->likestatus()
            ],
            'comments'=>new CommentCollection($this->comments()->paginate(4)),
            'links'=>[
                'self'=>url('/api/posts/'.$this->id)
            ]

        ]
    ];
    }

    public $with=['meta'];
}
