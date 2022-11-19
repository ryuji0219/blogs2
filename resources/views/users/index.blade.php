@extends('layout2')

@section('content')

    <h1>一覧表示（普通）</h1>

    <table class="table table-striped">
    @foreach($users as $user)
        <tr>
            <td>{{$user->id}}</td>
            <td>{{$user->name}}</td>
            <td>{{$user->email}}</td>
        </tr>
    @endforeach
    </table>

    <!-- page control -->
    {!! $users->render() !!}

@stop