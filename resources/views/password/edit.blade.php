@extends('layouts.default')
@section('content')
    <form action="{{route('FindPasswordUpdate')}}" method="post">
        @csrf
        <div class="card">
            <div class="card-header">
                重置密码
            </div>
            <div class="card-body">
                <input type="text" hidden name="token" value="{{$user['email_token']}}">
                <div class="form-group">
                    <label for="">邮箱</label>
                    <input type="text" class="form-control" name="email" disabled value="{{$user['email']}}">
                </div>
                <div class="form-group">
                    <label for="">密码</label>
                    <input type="text" class="form-control" name="password">
                    <small id="helpId" class="text-muted">请输入您的新密码</small>
                </div>
                <div class="form-group">
                    <label for="">确认密码</label>
                    <input type="text" class="form-control" name="password_confirmation">
                    <small id="helpId" class="text-muted">确认密码</small>
                </div>
            </div>
            <div class="card-footer text-muted">
                <button class="btn btn-success">提交</button>
            </div>
        </div>
    </form>
@endsection