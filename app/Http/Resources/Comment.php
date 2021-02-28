<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class Comment extends JsonResource
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
                'comment_id'=>$this->id,
                'type'=>'comments',
                'attributes'=>[
                    'data'=>[
                        'comment_body'=>$this->body,
                        'post_id'=>$this->post_id,
                        'created_at'=>$this->created_at->diffForHumans(),
                        'posted_by'=>new UserResource(User::find($this->user->id))
                    ]
                ],
                'links'=>[
                    'self'=>'/api/posts/'.$this->id.'/comments'
                ]
            ]
        ];
    }
}
