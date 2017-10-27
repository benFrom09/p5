<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GroupController extends Controller
{

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








    public function show($id) {

        return view('groups.chatroom');
    }
}
