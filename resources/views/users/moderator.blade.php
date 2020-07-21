@extends('layouts.app')

@section('content')
    @foreach($users as $user)
        <p> <a href="/user{{$user->id}}/boards">{{$user->name}}</a></p>
    @endforeach
@endsection
