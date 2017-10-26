<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GroupController extends Controller
{
        public function show($id) {

            return view('pages.group');
        }
}
