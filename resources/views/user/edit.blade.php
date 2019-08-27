@extends('layouts.default')
@section('content')
    <form action="{{route('user.update',$user)}}" method="post">
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-header">
                修改资料
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>昵称</label>
                    <input type="text"
                           class="form-control" name="name" id="" aria-describedby="helpId" placeholder="" value="{{$user['name']}}">
                </div>
                <div class="form-group">
                    <label>密码</label>
                    <input type="password"
                           class="form-control" name="password" id="" aria-describedby="helpId" placeholder="">
                </div>
                <div class="form-group">
                    <label>确认密码</label>
                    <input type="password"
                           class="form-control" name="password_confirmation" id="" aria-describedby="helpId" placeholder="">
                </div>
            </div>
            <div class="card-footer text-muted">
                <button type="submit" class="btn btn-success">确定修改</button>
            </div>
        </div>
    </form>
@endsection