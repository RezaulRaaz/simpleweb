<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FirstController extends Controller
{
    public function index(Request $request){

        $image=$request->file('image');
        $imagename=$image->getClientOriginalName();
        $imagename =time().'_'.$imagename;
        $image->move(public_path('/images'),$imagename);

        $post=new Post();
        $post->title=$request->title;
        $post->embed=$request->embed;
        $post->type=$request->type;
        $post->section=$request->section;
        $post->desc=$request->desc;
        $post->image=$imagename;
        if (isset($request->publish)){
            $post->isPublish=true;
        }else{
            $post->isPublish=false;
        }
        $post->user_id=Auth::user()->id;
        $post->save();
        return response()->json(['image'=>$imagename]);
    }
}
