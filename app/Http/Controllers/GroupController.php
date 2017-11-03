<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Group;
use App\User;
use App\Post;

class GroupController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request) {
        
               
                
        return view('groups.creategroup');
    }
        
    public function store(GroupRequest $req) {
        $name = $req->get('name');
        $group = Group::where('name', $name)->first();

        if(!$group){
            $group = Group::create([
            "name" => $name,
            "user_name" =>$req->get('user_name'),
            "category_id" =>$req->get('category_id')
            ]);
        
             $group->users()->sync(\Auth::user()->id);
        }
        
            return view('users.home');
               
    }








    public function show(Request $req,$id) {

        // recupere tous les membre d'un groupe

       $group = Group::find($id);
       $users = User::all();
       $top_20_posts = Post::all()->take(20);
       if($group){

          $allowed_users = $group->users;
          foreach($allowed_users as $user) {
              $user->name;
          }
          if($req->has('content')) {
            $post_content = e($req->get('content'));
            $user_post_content = new Post();
            $user_post_content->content = $post_content;
            $user_post_content->user_id = $user->id;
            $user_post_content->group_id = 0 ;
            $user_post_content->save();
            return redirect()->route('group',['id'=>$id]);
        }  

            return view('groups.group',compact('top_20_posts'));

       } else {
           //return execption 
           dd('ce groupe n\'existe pas');
       }
    
       
       
        
        
        
    }
}
