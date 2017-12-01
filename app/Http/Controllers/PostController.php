<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Post;
use App\Group;

class PostController extends Controller
{
    public function createPost(Request $req, $id) {
            if($req->post_images) {
               $fileName = str_random(8). '_' .  $req->post_images->getClientOriginalName();
                $req->post_images->move('post_images',$fileName);

                $post = new Post();
                if($req->content) {
                    $post->content = $req->content;
                    
                } else {
                    $post->content = '';
                }
                
                $post->group_id = $id;
                $post->image_url = $fileName;
                $post->video_url = '';
                $post->type = 1;
                $req->user()->posts()->save($post); 
                $top_20_posts = Post::orderBy('created_at','desc')->get();              
                return view('layout.partials.top_20_post',compact('top_20_posts'));
            } else {
                $this->validate($req, [
                    'content' => 'required'
                ]);
                $post = new post();
                $post->content = $req->content;
                $post->group_id = $id;
                $post->image_url = '';
                $post->video_url = '';
                $post->type = 0;
                $req->user()->posts()->save($post); 
                $top_20_posts = Post::orderBy('created_at','desc')->get();              
                return view('layout.partials.top_20_post',compact('top_20_posts'));
                //return $req;
            }
        
        
    }

  

    public function deletePost(Request $req, $post_id) {
        $post = Post::where('id',$post_id)->first();
        if(Auth::user() != $post->user){
            return redirect()->back();
        }
            $post->delete();
            $message = "article a bien été supprimé";
            return $message;
        
        
       
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
