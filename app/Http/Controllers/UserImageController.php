<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserImageCollection;
use App\Http\Resources\UserImageResource;
use App\Models\User;
use App\Models\UserImage;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class UserImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($userid)
    {
        $userImages=User::find($userid)->images;
        return new UserImageCollection($userImages);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ins=['profile','cover'];
        $request->validate([
           'image'=>'image',
           'type'=>'required|in:'.implode(',', $ins)
        ]);
        $imageName=$request->file('image')->hashName();
        $image=Image::make($request->file('image'));
        $request->type=='profile' ? $image->resize(700,700) : $image->resize(1200,500);

        $image->save(public_path('images/').$imageName);
        $image=UserImage::updateOrCreate(['type'=>$request->type],[
           'type'=>$request->type,
           'image'=>$imageName,
            'width'=> $request->width ?? null,
            'height'=> $request->height ?? null,
            'user_id'=>auth()->user()->id
        ]);

        return new UserImageResource($image);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
            if(request()->route('image')=='profile'){
                return new UserImageResource(auth()->user()->profileimage);
            }else if(request()->route('image')=='cover'){
                return new UserImageResource(auth()->user()->coverimage);
            }
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
}
