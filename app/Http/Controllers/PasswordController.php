<?php

namespace App\Http\Controllers;

use App\Notifications\FindPasswordNotify;
use Illuminate\Http\Request;

class PasswordController extends Controller
{
    //重置密码页面
    public function email(){
        return view('password.email');
    }

    //发送密码方法
    public function send(Request $request){
        $user = \App\User::where('email',$request->email)->first();
        if(!$user){
            session()->flash('danger','该邮箱尚未注册我们的网站，请检查邮箱是否正确');
            return redirect()->route('FindPasswordEmail');
        }
        \Notification::send($user, new FindPasswordNotify($user->email_token));
        session()->flash('success','已将重置密码的邮件发送到您的邮箱，请注意查收');
        return redirect()->route('login');
    }

    //修改密码页面
    public function edit($token){
        $user = $this->getUserByToken($token);
        return view('password.edit',compact('user'));
    }

    //更新密码
    public function update(Request $request){
        $this->validate($request,[
            'password' => 'required|min:5|confirmed'
        ]);
        $user = $this->getUserByToken($request->token);
        $user->password = bcrypt($request->password);
        $user->save();
        session()->flash('success','修改密码成功');
        return redirect()->route('login');
    }

    protected function getUserByToken($token){
        return \App\User::where('email_token',$token)->first();
    }
}
