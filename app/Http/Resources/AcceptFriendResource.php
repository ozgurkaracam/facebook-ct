<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class AcceptFriendResource extends JsonResource
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
                'type'=>'accept-friend',
                'attributes'=>[
                    'friend'=>new UserResource(User::find($this->user_id)),
                    'confirmed_at'=>date($this->confirmed_at),
                    'status'=>$this->status
                ]
            ]
        ];
    }
}
