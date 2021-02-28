<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FriendResource extends JsonResource
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
                'type'=>'friend-request',
                'friend_request_id'=>$this->id,
                'attributes'=>[
                    'confirmed_at'=>$this->when(!is_null($this->confirmed_at), $this->confirmed_at),
                    'status'=>$this->status,
                    'user_id'=>$this->user_id,
                    'friend_id'=>$this->friend_id
                ]
            ],
            'links'=>[
                'self'=>'/api/users/'.$this->friend_id
            ]
        ];
    }
}
