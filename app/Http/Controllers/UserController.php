<?php

namespace App\Http\Controllers;

use App\Mail\Regmail;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        //在构造函数中定义一个中间件，auth，该中间件会在进行敏感操作，
        //如未登录的情况下修改用户信息时，跳转到登录页面，
        //如果某些默认的权限太过敏感，可以手动排除
        //如想让未登录用户可以查看用户列表，可以写'except'=>['index']将其排除在外
        $this->middleware('auth',[
            'except'=>['index','show','create','store','confirmEmailToken']
        ]);
        //第二个中间件，guest，只有游客才有资格使用注册相关的功能create、store
        $this->middleware('guest',[
            'only'=>['create','store']
        ]);
    }

    /*
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //用户列表，十条数据一页
        $users=User::paginate(10);
        return view('user.index',compact('users'));
    }

    /*
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('user.create');
    }

    /*
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //处理注册表单
        $data = $this->validate($request, [
            'name' => 'required|min:3',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:5|confirmed'
        ]);
        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);
        //发送注册邮件
        try {
            \Mail::to($user)->send(new Regmail($user));
        }catch (\Exception $e){
            session()->flash('danger','我们无法向您的邮箱发送邮件，请检查您的邮箱是否正确或稍后重试');
            \DB::table('users')->where('email', '=', $user->email)->delete();
            return redirect()->route('user.create');
        }
        /*\Auth::attempt(['email'=>$request ->email,'password'=>$request->password]);*/
        session()->flash('success','请查看邮箱完成注册验证');
        return redirect()->route('home');

    }
    //关注或者取关方法
    public function follow(User $user){
        $user->followToggle(\Auth::user()->id);
        return back();
    }

    /*
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
        $blogs= $user->blogs()->paginate(10);
        $followTitle=null;
        if (\Auth::check())
            $followTitle=$user->isFollow(\Auth::user()->id) ? '取消关注' : '关注';
        return view('user.show',compact('user','blogs','followTitle'));
    }

    /*
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $this->authorize('update',$user);
        //edit负责显示用户界面,update才是更新用户信息
        return view('user.edit',compact('user'));
    }

    /*
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //edit负责显示用户界面,update才是更新用户信息
        $this->validate($request,[
            'name'=>'required|min:3',
            'password'=>'nullable|min:5|confirmed'  //nullable的意思是，如果没有填写，后边就不再验证，而且nullable和required冲突，只能用其一
        ]);
        $user->name=$request->name;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->save();
        session()->forget('name');
        session(['name' => $user->name]);
        session()->flash('success','修改成功');
        return redirect()->route('user.show',$user);
    }

    /*
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
        $this->authorize('delete',$user);
        $user->delete();
        session()->forget('name');
        session()->flash('success','删除成功');
        return redirect()->route('user.index');
    }

    public function confirmEmailToken($token){
        /*dd($token);*/
        /*$user = User::find(1);
        \Mail::to($user)->send(new Regmail($user));*/
        $user=User::where('email_token',$token)->first();
        if ($user){
            $user->email_active = true;
            $user->save();
            session()->flash('验证成功');
            \Auth::login($user);
            $yonghu =\DB::table('users')->select('name')->where('email_token','=',$token)->get();
            session()->forget('name');
            session(['name' => $yonghu[0]->name]);
            return redirect('/');
        }
        session()->flash('danger','邮箱验证失败');
        return redirect('/');
    }
}
