@extends('layouts.app')
@section('title', 'Socios')
@section('head')
    <link rel="stylesheet" href="{{ asset('styles/view.css') }}">

@endsection
@section('content')

    <div class="titleBlock">
        <h2 class="mt-5 p-4">EDICION USUARIO</h2>
    </div>

    {{-- Bloques principales --}}
    <div class="d-flex align-items-center justify-content-center">

        <div class="p-3" style="width:90%">
            {{-- Bloque para información de acciones --}}
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
            <form action="">
                {{-- BLOQUE DATOS PERSONALES --}}
                <div>
                    <h3>Datos Generales</h3>
                    <hr class="del">
                    <div class="p-3">
                        <div class="row mb-2">
                            <div class="form-group col-8">
                                <label for="nombreEntidad">Nombre entidad:</label>
                                <input type="text" class="form-control" name="nombreEntidad" id="nombreEntidad"
                                    value="{{$data[0]['nombreEntidad']}}">
                            </div>
                            <div class="form-group col-4">
                                <label for="username">Usuario:</label>
                                <input type="text" class="form-control" name="username" id="username" value="{{$data[0]['username']}}">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="form-group col-8">
                                <label for="password">Contraseña:</label>
                                <input type="password" class="form-control" name="password" id="password"
                                    placeholder="*********">
                            </div>
                            <div class="form-group col-4">
                                <label for="password">Rol:</label>
                                <select class="form-select" name="rol" id="rol">
                                    @if ($data[0]['rol'] == 'Admin')
                                        <option value="Admin" selected>Admin</option>
                                        <option value="User">User</option>
                                    @else
                                        <option value="Admin">Admin</option>
                                        <option value="User" selected>User</option>
                                    @endif

                                </select>
                            </div>
                        </div>
                    </div>
                </div>


                {{-- SEGUNDA FILA --}}
                <div class="row">

                    {{-- BLOQUE DIRECCIÓN --}}
                    <div class="col-6">
                        <h3>Dirección</h3>
                        <hr class="del">
                        <div class="p-3">
                            <div class="form-group">
                                <label for="direccion">Direccion:</label>
                                <input type="text" class="form-control" name="direccion" id="direccion" value="{{$data[0]['direccion']}}">
                            </div>
                            <div class="row mb-2">
                                <div class="form-group col-8">
                                    <label for="localidad">Localidad:</label>
                                    <input type="text" class="form-control" name="localidad" id="localidad"
                                        value="{{$data[0]['localidad']}}">
                                </div>
                                <div class="form-group col-4">
                                    <label for="cp">Codigo postal:</label>
                                    <input type="number" class="form-control" name="cp" id="cp" value="{{$data[0]['cp']}}">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- BLOQUE DE CONTACTO --}}
                    <div class="col-6">
                        <h3>Contacto</h3>
                        <hr class="del">
                        <div class="p-3">
                            <div class="row mb-2">
                                <div class="form-group col-4">
                                    <label for="telefono">Telefono:</label>
                                    <input type="number" class="form-control" name="telefono" id="telefono"
                                        value="{{$data[0]['telefono']}}">
                                </div>
                                <div class="form-group col-8">
                                    <label for="email">Email:</label>
                                    <input type="text" class="form-control" name="email" id="email"
                                        placeholder="example@example.com" value="{{$data[0]['email']}}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- BLOQUE FOTO --}}
                <h3>Foto(Max 400px x 400px)</h3>
                <hr class="del">
                <div class="form-group mb-2">
                    <input type="file" class="form-control" name="foto" id="foto" accept="image/*">
                </div>
                <button type="submit" class="btn btn-success">Actualizar</button>
            </form>
        </div>
    </div>

@endsection
