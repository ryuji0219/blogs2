@extends('layout2')

@section('content')

    <h1>一覧表示（普通）</h1>

    <table class="table table-striped">
    @foreach($blogs as $blog)
        <tr>
            <td>{{$blog->id}}</td>
            <td>{{$blog->title}}</td>
            <td>{{$blog->content}}</td>
        </tr>
    @endforeach
    </table>

    <!-- page control -->
    {!! $blogs->render() !!}

@stop