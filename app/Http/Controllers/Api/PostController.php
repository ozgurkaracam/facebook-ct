<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Models\Friend;
use App\Models\Post;
use http\Env\Response;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $friends=Friend::friendships();
        if($friends->count()<1)
            $posts=auth()->user()->posts()->withCount('likes');
        else{
            $posts=Post::where(['user_id'=>$friends->pluck('user_id')])->orWhere(['user_id'=>$friends->pluck('friend_id')])->withCount('likes');
        }
        return new PostCollection($posts->paginate(9));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
           'body'=>'required'
        ]);
        $post=$request->user()->posts()->create(['body'=>$request->body]);
        return new PostResource($post);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response([],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function userposts($id)
    {
        return new PostCollection(Post::where('user_id',$id)->paginate(5));
    }
    public function myposts()
    {
        return new PostCollection(Post::where('user_id',auth()->user()->id)->get());
    }
}
