<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Friend extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $table="friends";

    public static function friendship($userId)
    {
        return (new static())
            ->where(function($query) use ($userId){
                $query->where(['user_id'=>auth()->user()->id,'friend_id'=>$userId]);
            })->orWhere(function($query) use ($userId){
                $query->where(['user_id'=>$userId,'friend_id'=>auth()->user()->id]);
            })
            ->firstOrFail();
    }

    public static function friendships()
    {
        return (new static())
            ->where(['status'=>1])
            ->where(function($query){
                $query->where(['user_id'=>auth()->user()->id])
                    ->orWhere(['friend_id'=>auth()->user()->id]);
            })->get();
    }
}
