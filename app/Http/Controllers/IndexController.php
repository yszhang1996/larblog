<?php

namespace App\Http\Controllers;

use App\Mail\Regmail;
use \App\User;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    //
    public function home(){
        $blogs=\App\Blog::orderBy('id','DESC')->with('user')->paginate(10);
        return view('home',compact('blogs'));
    }
}
