@extends('layouts.app')
@section('title', 'Socios')
@section('head')
    <link rel="stylesheet" href="{{ asset('styles/list.css') }}">
@endsection
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
            <form action="{{ route('partner.store') }}" class="w-100" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-groupd">
                    <label for="dni">DNI:</label>
                    <input type="text" class="form-control" name="dni" id="dni" value="1234568D">
                </div>
                <div class="row">
                    <div class="form-group col-6">
                        <label for="prNombre">Primer nombre:</label>
                        <input type="text" class="form-control" name="prNombre" id="prNombre" value="test">
                    </div>
                    <div class="form-group col-6">
                        <label for="sgNombre">Segundo nombre:</label>
                        <input type="sgNombre" class="form-control" name="sgNombre" id="sgNombre" value="test">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-6">
                        <label for="prApellido">Primer apellido:</label>
                        <input type="text" class="form-control" name="prApellido" id="prApellido" value="test">
                    </div>
                    <div class="form-group col-6">
                        <label for="sgApellido">Segundo apellido:</label>
                        <input type="text" class="form-control" name="sgApellido" id="sgApellido" value="test">
                    </div>
                </div>

                <div class="form-group">
                    <label for="fechaNacimiento">Fecha nacimiento:</label>
                    <input type="date" class="form-control" name="fechaNacimiento" id="fechaNacimiento">
                </div>
                <div class="form-group">
                    <label for="direccion">Direccion:</label>
                    <input type="text" class="form-control" name="direccion" id="direccion" value="test">
                </div>
                <div class="row">
                    <div class="form-group col-6">
                        <label for="localidad">Localidad:</label>
                        <input type="text" class="form-control" name="localidad" id="localidad" value="test">
                    </div>
                    <div class="form-group col-6">
                        <label for="cp">Codigo postal:</label>
                        <input type="number" class="form-control" name="cp" id="cp" value="00000">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-4">
                        <label for="tel">Telefono:</label>
                        <input type="number" class="form-control" name="tel" id="tel" value="000000000">
                    </div>
                    <div class="form-group col-4">
                        <label for="prTelResp">1º Telefono responsable:</label>
                        <input type="number" class="form-control" name="prTelResp" id="prTelResp" value="000000000">
                    </div>
                    <div class="form-group col-4">
                        <label for="sgTelResp">2º Telefono responsable:</label>
                        <input type="number" class="form-control" name="sgTelResp" id="sgTelResp" value="000000000">
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="text" class="form-control" name="email" id="email"
                        placeholder="example@example.com" value="test@test.com">
                </div>
                <div class="form-group">
                    <label for="alergias">Alergias:</label>
                    <textarea class="form-control" name="alergias" id="alergias"></textarea>
                </div>
                <div class="form-group">
                    <label for="foto">Foto(Max 400px x 400px):</label>
                    <input type="file" class="form-control" name="foto" id="foto" accept="image/*">
                </div>
                <button type="submit" class="btn btn-primary mt-3">Crear</button>
            </form>
        </div>
    </div>

@endsection
