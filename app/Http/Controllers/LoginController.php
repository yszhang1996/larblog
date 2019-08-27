<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    //

    public function login(){
        return view('login');
    }

    public function store(Request $request){
        $data=$this->validate($request,[
            'email'=>'email|required',
            'password'=>'required|min:5'
        ]);
        if(\Auth::attempt($data)){
            $yonghu =\DB::table('users')->select('name')->where('email','=',$data['email'])->get();
            session()->forget('name');
            session(['name' => $yonghu[0]->name]);
            session()->flash('success','登录成功');
            return redirect('/');
        }
        session()->flash('danger','账号或者密码错误');
        return back();

    }

    public function logout(){
        \Auth::logout();
        session()->forget('name');
        session()->flash('success','退出成功');
        return redirect('/');
    }
}
