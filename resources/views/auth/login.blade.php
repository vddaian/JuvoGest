@extends('layouts.app')
@section('title', 'Login')
@section('head')
    <link rel="stylesheet" href="{{ asset('styles/login.css') }}">
    <script src="{{asset('js/global.js')}}"></script>
@endsection
@section('content')
    <div class="loginBlock w-100 h-100 d-flex align-items-center justify-content-center">
        <form action="{{ route('login.verify') }}" method="POST" class="loginForm bg-white p-4 rounded ">
            @csrf
            <div class="form-group mb-3">
                <label for="username">Usuario:</label>
                <input type="text" class="form-control" name="username" id="username" placeholder="example@example.com">
            </div>
            <div class="form-group mb-3">
                <label for="password">Contraseña:</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="*********">
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <button type="submit" class="btn btn-success" onclick="charge()">Iniciar Sesion</button>
                <a href="{{route('app.info')}}" onclick="charge()">Info</a>
            </div>
            
        </form>
    </div>
    <video src="{{ asset('media/videos/login-video.mp4') }}" class="loginVideo" autoplay="true" muted="true">
    </video>


@endsection
