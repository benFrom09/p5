<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\GroupRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Group;
use App\User;
use App\Post;
use App\Group_user;

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

    public function addUserToGroup(Request $req) {

        $group = Group::where('id',$req->group_id)->first();

       $group->users()->attach($req->user_id);
            
       return redirect()->route('group',['id'=>$req->group_id]);

        //return redirect()->back();

    }

    public function index(Request $req) {
        
        $groups = Group::all();
        
        return view('groups.index',compact('groups')); 
        
    }


    public function show(Request $req,$id) {

        // recupere tous les membre d'un groupe
        

       $group = Group::find($id);      
       $users = User::all();
       $top_20_posts = Post::orderBy('created_at','desc')->get();
       if($group){

          $allowed_users = $group->users;
          
          if($req->has('content')) {
              if($req->ajax()){
                  return response()->json(['message'=>'la requete est établie']);
              }
            $post_content = e($req->get('content'));
            $user_post_content = new Post();
            $user_post_content->content = $post_content;
            $user_post_content->user_id = $user->id;
            $user_post_content->group_id = $id ;
            $user_post_content->image_url = '';
            $user_post_content->video_url = '';
            $user_post_content->type = 0;
            $user_post_content->save();                       
            return redirect()->route('group',['id'=>$id]);   
        }  
            return view('groups.group',compact('top_20_posts','group','allowed_users'));
       } else {
           //return execption 
           dd('ce groupe n\'existe pas');
       }       
        
    }

    
}
