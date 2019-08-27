@extends('layouts.default')
@section('content')
    @auth()
    <form action="{{route('blog.store')}}" method="post">
        @csrf
        <div class="card">
            <div class="card-header">
                发布博客
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for=""></label>
                    <textarea class="form-control" name="content">{{old('content')}}</textarea>
                </div>
            </div>
            <div class="card-footer text-muted">
                <button type="submit" class="btn btn-success">发表</button>
            </div>
        </div>
    </form>
    @endauth
    {{--博客列表--}}
    <div class="card mt-2">
        <div class="card-header">
            博客列表
        </div>
        <div class="card-body">
            <table class="table">
                <tbody>
                @foreach($blogs as $blog)
                <tr>
                    <td>{{$blog['content']}}</td>
                    <td><a href="{{route('user.show',$blog->user)}}">{{$blog->user->name}}</a></td>
                    @can('delete',$blog)
                    <td><form action="{{route('blog.destroy',$blog['id'])}}" method="post">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm">删除</button>
                        </form>
                    </td>
                    @endcan
                </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer text-muted">
            {{$blogs->links()}}
        </div>
    </div>
@endsection