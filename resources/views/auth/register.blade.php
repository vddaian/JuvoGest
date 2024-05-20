@extends('layouts.app')
@section('title', 'Register')
@section('content')
    <div class="mt-5 d-flex align-items-center justify-content-center">
        <div class="mt-3  p-5" style="width:80%">
            @if (Session::has('info'))
                @isset(Session::get('info')['message'])
                    @isset(Session::get('info')['error'])
                        <div class="w-100 mb-1 p-2 error">
                            <p>{{ Session::get('info')['message'] }}</p>
                        </div>
                    @else
                        <div class="w-100 mb-1 p-2 success">
                            <p>{{ Session::get('info')['message'] }}</p>
                        </div>
                    @endisset
                @endisset
            @endif
            <form action="{{ route('register.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="nombreEntidad">Nombre entidad:</label>
                    <input type="text" class="form-control" name="nombreEntidad" id="nombreEntidad" value="test">
                </div>
                <div class="form-group">
                    <label for="username">Usuario:</label>
                    <input type="text" class="form-control" name="username" id="username" value="test">
                </div>
                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="*********"
                        value="test">
                </div>
                <div class="form-group">
                    <label for="direccion">Direccion:</label>
                    <input type="text" class="form-control" name="direccion" id="direccion" value="test">
                </div>
                <div class="form-group">
                    <label for="localidad">Localidad:</label>
                    <input type="text" class="form-control" name="localidad" id="localidad" value="test">
                </div>
                <div class="form-group">
                    <label for="cp">Codigo postal:</label>
                    <input type="number" class="form-control" name="cp" id="cp" value="00000">
                </div>
                <div class="form-group">
                    <label for="telefono">Telefono:</label>
                    <input type="number" class="form-control" name="telefono" id="telefono" value="000000000">
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="text" class="form-control" name="email" id="email"
                        placeholder="example@example.com" value="test@test.com">
                </div>
                <div class="form-group">
                    <label for="foto">Foto(Max 400px x 400px):</label>
                    <input type="file" class="form-control" name="foto" id="foto" accept="image/*">
                </div>
                <button type="submit" class="btn btn-success">Registrar</button>
            </form>
        </div>
    </div>
@endsection
