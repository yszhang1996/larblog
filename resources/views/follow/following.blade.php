@extends('layouts.default')
@section('content')
    <div class="card">
        <div class="card-header text-center">
            <h2>{{$user->name}}的关注</h2>
        </div>
        <div class="card-body">
            @foreach($users as $user)
                <table class="table">
                    <tbody>
                    <tr>
                        <td><a href="{{route('user.show',$user)}}">{{$user->name}}</a></td>
                    </tr>
                    </tbody>
                </table>
            @endforeach
        </div>
        <div class="card-footer text-muted">
            {{$users->links()}}
        </div>
    </div>
@endsection
