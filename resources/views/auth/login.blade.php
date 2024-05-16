@extends('layouts.app')
@section('title', 'Login')
@section('content')
    <form action="{{route('login.verify')}}" method="POST">
        @csrf
        <div class="form-group">
            <label for="username">Usuario:</label>
            <input type="text" class="form-control" name="username" id="username" placeholder="example@example.com">
        </div>
        <div class="form-group">
            <label for="password">Contraseña:</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="*********">
        </div>
        <button type="submit" class="btn btn-primary">Iniciar Sesion</button>
    </form>
@endsection
