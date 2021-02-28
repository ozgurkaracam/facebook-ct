<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\FriendRequestNotFoundException;
use App\Exceptions\UserNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Resources\AcceptFriendResource;
use App\Http\Resources\FriendResource;
use App\Http\Resources\UserResource;
use App\Models\Friend;
use App\Models\User;
use Cassandra\Exception\AlreadyExistsException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new UserResource(User::find($id));
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

    public function authuser()
    {
        return new UserResource(auth()->user());
    }

    public function addfriend(Request $request)
    {
        try{
            $user=User::findOrFail($request->friend_id);
            $request->user()->friends()->syncWithoutDetaching($user);
            return new UserResource($user);
        }catch (ModelNotFoundException $e){
            throw new UserNotFoundException();
            }
    }

    public function acceptfriend(Request $request)
    {
        try{
            $friendRequest=Friend::where(['user_id'=>$request->friend_id, 'friend_id'=>$request->user()->id])->firstOrFail();
            $friendRequest->update([
                'status'=>1,
                'confirmed_at'=>now()
            ]);
            return new FriendResource($friendRequest);
        }catch (ModelNotFoundException $e){
            throw new FriendRequestNotFoundException();
        }
    }

    public function deletefriend(Request $request)
    {
        try{
            $friendRequest=Friend::friendship($request->friend_id);
            $friendRequest->delete();
            return new FriendResource($friendRequest);
        }catch (ModelNotFoundException $e){
            throw new FriendRequestNotFoundException();
        }
    }


}
