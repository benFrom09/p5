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

        if($req->has('content')) {
          
            $rules = [];
            $validate = Validator::make($req->all(),$rules);
            if($req->hasFile('post_images')){
                //dd($req['post_images']);
                //dd('bonjour le monde');
                $rules ['post_images'] = 'image';
                $validate = Validator::make($req->all(),$rules);
                dd($validate);
                if(!$validate->fails()){
                    $image = $req->file('post_images');
                
                    $imageName = $image->getFileName();
                
                    $imageName = str_random(8). '_' . $image->getClientOriginalName();
                        //dd($imageName);
                
                    $image->move('post_images',$imageName);
                    $post = new post();
                     $post->content = $req['content'];
                    $post->group_id = $id;
                    $post->image_url = $imageName;
                    $post->video_url = '';
                    $post->type = 1;
                    $message = "il y'a eu une erreur";
                    if($req->user()->posts()->save($post)) {
                    
                        $message = 'le votre statut a bien été posté';
                        if($req->json()) {
                        
                        //return response()->json('statut ok', 200);
                            return view('layout.partials.post',compact('post'));
                        } else {
                            return redirect()->route('group',['id'=>$id])->with(['message'=>$message]);
                        }
                    }
                }
            }    
                            
            $post = new post();
            $post->content = $req['content'];
            $post->group_id = $id;
            $post->image_url = '';
            $post->video_url = '';
            $post->type = 0;
            if($req->user()->posts()->save($post)) {
            $message = 'le votre statut a bien été posté';
            if($req->json()) {
                    return view('layout.partials.post',compact('post'));
                } else {
                    return redirect()->route('group',['id'=>$id])->with(['message'=>$message]);
                }
           
            }
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
