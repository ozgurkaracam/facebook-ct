<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens,HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function friends()
    {
        return $this->belongsToMany(User::class,"friends","user_id","friend_id");
    }

    public function friendstatus($id)
    {
        $friend=User::find($id);


    }

    public function friendsposts()
    {
        return $this->hasManyThrough(Post::class,Friend::class,'friend_id','user_id');
    }

    public function likes()
    {
        return $this->belongsToMany(Post::class,"likes","user_id","post_id");
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function profileimage()
    {
        return $this->hasOne(UserImage::class)->where('type','profile')->withDefault(['image'=>'deneme']);
    }

    public function coverimage()
    {
        return $this->hasOne(UserImage::class)->where('type','cover')->withDefault(['image'=>'deneme']);
    }

    public function images()
    {
        return $this->hasMany(UserImage::class);
    }
}
