@extends('layouts.app')
@section('title', 'Socios')
@section('head')
    <link rel="stylesheet" href="{{ asset('styles/list.css') }}">
    <script src="{{asset('js/validations.js')}}"></script>
@endsection
@section('content')

    <div class="titleBlock">
        <h2 class="mt-5 p-4">ACTUALIZAR SOCIO</h2>
    </div>

    <div class="d-flex align-items-center justify-content-center">
        <div class="p-3" style="width:70%">
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

            <form action="{{ route('partner.update', $data[0]['idSocio']) }}" method="POST" enctype="multipart/form-data" onsubmit="return validatePartnerForm(this);">
                @method('put')
                @csrf
                <input type="hidden" name="id" id="id" value="{{$data[0]['idSocio']}}">
                <div class="form-groupd">
                    <label for="dni">DNI:</label>
                    <input type="text" class="form-control" name="dni" id="dni" value="{{$data[0]['dni']}}" readonly>
                </div>
                <div class="row">
                    <div class="form-group col-6">
                        <label for="prNombre">Primer nombre:</label>
                        <input type="text" class="form-control" name="prNombre" id="prNombre" value="{{$data[0]['prNombre']}}">
                    </div>
                    <div class="form-group col-6">
                        <label for="sgNombre">Segundo nombre:</label>
                        <input type="sgNombre" class="form-control" name="sgNombre" id="sgNombre" value="{{$data[0]['sgNombre']}}">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-6">
                        <label for="prApellido">Primer apellido:</label>
                        <input type="text" class="form-control" name="prApellido" id="prApellido" value="{{$data[0]['prApellido']}}">
                    </div>
                    <div class="form-group col-6">
                        <label for="sgApellido">Segundo apellido:</label>
                        <input type="text" class="form-control" name="sgApellido" id="sgApellido" value="{{$data[0]['sgApellido']}}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="fechaNacimiento">Fecha nacimiento:</label>
                    <input type="date" class="form-control" name="fechaNacimiento" id="fechaNacimiento" value="{{$data[0]['fechaNacimiento']}}">
                </div>
                <div class="form-group">
                    <label for="direccion">Direccion:</label>
                    <input type="text" class="form-control" name="direccion" id="direccion" value="{{$data[0]['direccion']}}">
                </div>
                <div class="row">
                    <div class="form-group col-6">
                        <label for="localidad">Localidad:</label>
                        <input type="text" class="form-control" name="localidad" id="localidad" value="{{$data[0]['localidad']}}">
                    </div>
                    <div class="form-group col-6">
                        <label for="cp">Codigo postal:</label>
                        <input type="number" class="form-control" name="cp" id="cp" value="{{$data[0]['cp']}}">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-4">
                        <label for="tel">Telefono:</label>
                        <input type="number" class="form-control" name="tel" id="tel" value="{{$data[0]['telefono']}}">
                    </div>
                    <div class="form-group col-4">
                        <label for="prTelResp">1º Telefono responsable:</label>
                        <input type="number" class="form-control" name="prTelResp" id="prTelResp" value="{{$data[0]['prTelefonoResp']}}">
                    </div>
                    <div class="form-group col-4">
                        <label for="sgTelResp">2º Telefono responsable:</label>
                        <input type="number" class="form-control" name="sgTelResp" id="sgTelResp" value="{{$data[0]['sgTelefonoResp']}}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="text" class="form-control" name="email" id="email"
                        placeholder="example@example.com" value="{{$data[0]['email']}}">
                </div>
                <div class="form-group">
                    <label for="alergias">Alergias:</label>
                    <textarea class="form-control" name="alergias" id="alergias">{{$data[0]['alergias']}}</textarea>
                </div>
                <div class="form-group">
                    <label for="foto">Foto(Max 400px x 400px):</label>
                    <input type="file" class="form-control" name="foto" id="foto" accept="image/*">
                </div>
                <button type="submit" onclick="charge()" class="btn btn-success mt-3">Actualizar</button>
            </form>
        </div>
    </div>

@endsection
