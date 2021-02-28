<?php

namespace App\Http\Resources;

use App\Models\Friend;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
                'type'=>'users',
                'user_id'=>$this->id,
                'attributes'=>[
                    'name'=>$this->name,
                    'friendship'=>$this->when(auth()->user()->id!=$this->id
                        &&(
                            auth()->user()->friends()->get()->contains($this->id) ||
                            $this->friends()->get()->contains(auth()->user())
                        ),function(){
                        return new FriendResource(Friend::friendship($this->id));
                    })
                ],
                'profileimage'=>new UserImageResource($this->profileimage),
                'coverimage'=>new UserImageResource($this->coverimage),
                'links'=>[
                    'self'=>url('/users/'.$this->id)
                ]

            ]
        ];
    }
}
