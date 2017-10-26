<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Group;

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
    public function index()
    {   
        //utilisateur en cours
        
       
        // recupere tous les groupe d'un utilisateur
        $user = \Auth::user();
        
       // dd($user->groups()->get()->count());
         
        
        
        
        
       return view('users.home',compact('user'));
    }
}
