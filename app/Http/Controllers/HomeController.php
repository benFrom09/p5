<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Group;
use App\Post;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {   
        //utilisateur en cours
        
       
        // recupere tous les groupe d'un utilisateur
        $user = \Auth::user();
        
       // dd($user->groups()->get()->count());
         
        //display posts

        if($req->has('content')) {
            $post_content = e($req->get('content'));

                $rules = [
                    
                ];

            $validate = Validator::make($req->all(),$rules);

            if($req->hasFile('post_images')) {

                $rules ['post_images'] = 'image';
                $validate = Validator::make($req->all(),$rules);
                if(!$validate->fails()){

                    $image = $req->file('post_images');
                    
                    $imageName = $image->getFileName();
                    
                    $imageName = str_random(8). '_' . $image->getClientOriginalName();
                   // dd($imageName);
                    
                    $image->move('post_images',$imageName);

                    $user_post_content = new Post();
                    $user_post_content->content = $post_content;
                    $user_post_content->image_url = $imageName;
                    $user_post_content->type = 1;
                    $user_post_content->video_url = '';
                    $user_post_content->user_id = $user->id;
                    $user_post_content->group_id = 0 ;
                    $user_post_content->save();

                    return redirect(route('home'))->with('sucess','le statut a été posté');

                } else {
                   return back()->with('errors', 'Echec de la validation des données');
                }
                
                
           }       

            $user_post_content = new Post();
            $user_post_content->content = $post_content;
            $user_post_content->user_id = $user->id;
            $user_post_content->image_url = '';
            $user_post_content->type = 0;
            $user_post_content->video_url = '';
            $user_post_content->group_id = 0 ;
            $user_post_content->save();
            return redirect(route('home'))->with('sucess','le statut a été posté');
        }

    
        
         $top_20_posts = Post::all();
        
        
        
       return view('users.home',compact('user','top_20_posts'));
    }
}
