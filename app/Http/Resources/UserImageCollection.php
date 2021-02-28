<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserImageCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
          'data'=>[
              'type'=>'images',
              'data'=>$this->collection,
              'links'=>[
                  'self'=>'/api/users/1/images'
              ]
          ]
        ];
    }
}
