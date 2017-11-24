<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Post;
use App\Group;

class PostController extends Controller
{
    public function createPost(Request $req, $id) {
        $this->validate($req, [
            'content' => 'required'
        ]);
       $post = new post();
       $post->content = $req['content'];
       $post->group_id = $id;
       $post->video_url = '';
       if(isset($req['post_images']) && !empty($req['post_images'])){
           $image = $req['post_images'];
           //dd($image);
           $imageName = $image->getFileName();
           //dd($imageName);
           $imageName = str_random(8). '_' . $image->getClientOriginalName();
           $image->move('post_images',$imageName);
           $post->image_url = $imageName;
           $post->type = 1;
       } else {
           $post->image_url = '';
           $post->type = 0;
       }

       $message = "il y'a eu une erreur";
       if($req->user()->posts()->save($post)){
           $messsage = 'le post a bien été enregistré';
           if($req->json()){
               return view('layout.partials.post',compact('post'));
           }
           dd('erreur ajax');
       } 


    
   
    }

  

    public function deletePost(Request $req, $post_id) {
        $post = Post::where('id',$post_id)->first();
        if(Auth::user() != $post->user){
            return redirect()->back();
        }
        $post->delete();
        /*
        if($req->ajax()){
           return response()->json('le post a été supprimé',200);
        }
        */
        return redirect()->back();
       
    }

    public function editPost(Request $req) {
        $this->validate($req, [
            'content' => 'required'
        ]);
            $post = Post::find($req['postId']);
            
            $post->content = $req['content'];
            $post->update();
            return response()->json(['new_content'=>$post->content], 200);
        }
    

    
    
}
