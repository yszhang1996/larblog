<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class FollowController extends Controller
{
    //粉丝
    public function follower(User $user){
        $users=$user->follower()->paginate(10);
        /*dd($users);*/
        return view('follow.follower',compact('users','user'));
    }
    //关注
    public function following(User $user){
        $users=$user->following()->paginate(10);
        return view('follow.following',compact('users','user'));
    }
}
