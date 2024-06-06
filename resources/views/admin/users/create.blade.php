@extends('layouts.app')
@section('title', 'Register')
@section('head')
<script src="{{asset('js/validations.js')}}"></script>
@endsection
@section('content')
    <div class="titleBlock">
        <h2 class="mt-5 p-4">CREAR USUARIO</h2>
    </div>

    <div class="d-flex align-items-center justify-content-center">
        <div class=" p-3" style="width:90%">
            @if (Session::has('info'))
                @isset(Session::get('info')['message'])
                    @isset(Session::get('info')['error'])
                        <div class="w-100 mb-3 p-2 error">
                            <p>{{ Session::get('info')['message'] }}</p>
                        </div>
                    @else
                        <div class="w-100 mb-3 p-2 success">
                            <p>{{ Session::get('info')['message'] }}</p>
                        </div>
                    @endisset
                @endisset
            @endif
            <form action="{{ route('user.store') }}" method="post" enctype="multipart/form-data" onsubmit="return validateUserForm(this);">
                @csrf
                {{-- BLOQUE DATOS PERSONALES --}}
                <div>
                    <h3>Datos Generales</h3>
                    <hr class="del">
                    <div class="p-3">
                        <div class="row mb-2">
                            <div class="form-group col-8">
                                <label for="nombreEntidad">Nombre entidad:</label>
                                <input type="text" class="form-control" name="nombreEntidad" id="nombreEntidad">
                            </div>
                            <div class="form-group col-4">
                                <label for="username">Usuario:</label>
                                <input type="text" class="form-control" name="username" id="username">
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
                                    <option value="Admin">Admin</option>
                                    <option value="User" selected>User</option>

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
                                <input type="text" class="form-control" name="direccion" id="direccion">
                            </div>
                            <div class="row mb-2">
                                <div class="form-group col-lg-8">
                                    <label for="localidad">Localidad:</label>
                                    <input type="text" class="form-control" name="localidad" id="localidad">
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="cp">Codigo postal:</label>
                                    <input type="number" class="form-control" name="cp" id="cp">
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
                                <div class="form-group col-lg-4">
                                    <label for="telefono">Telefono:</label>
                                    <input type="number" class="form-control" name="telefono" id="telefono">
                                </div>
                                <div class="form-group col-lg-8">
                                    <label for="email">Email:</label>
                                    <input type="text" class="form-control" name="email" id="email"
                                        placeholder="example@example.com">
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
                <button type="submit" class="btn btn-success" onclick="charge()">Crear</button>
            </form>
        </div>
    </div>
@endsection
