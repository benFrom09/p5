<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function home() {
        $user = \Auth::user();
        return view('pages.home',compact('user'));

    }

    public function about() {

        return view('pages.about');

    }

    public function contact() {
        return view('pages.contact');
    }
}
