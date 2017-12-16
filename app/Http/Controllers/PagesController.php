<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;
use App\User;
class PagesController extends Controller
{
    public function home() {
        //$user = \Auth::user();
        $user = \Auth::user();
        $groups = Group::all();
        if($user){
        //dd($user->groups);
        foreach($groups as $group) {
            dd($group->users()->all);
        }
         
         

        }
        return view('pages.home',compact('user'));
        
        
        
        

    }

    public function about() {

        return view('pages.about');

    }

    public function contact() {
        return view('pages.contact');
    }
}
