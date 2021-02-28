<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserImageResource extends JsonResource
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
                'image_id'=>$this->id,
                'type'=>'image',
                'user_id'=>$this->user_id,
                'attributes'=>[
                    'type'=>$this->type,
                    'image_path'=>$this->image,
                    'width'=>$this->width,
                    'height'=>$this->height
                ],
                'links'=>[
                    'self'=>'/api/users/'.$this->user_id.'/images/'.$this->id
                ]
            ]
        ];
    }
}
