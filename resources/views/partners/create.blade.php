@extends('layouts.app')
@section('title', 'Socios')
@section('head')
    <link rel="stylesheet" href="{{ asset('styles/list.css') }}">
    <script src="{{ asset('js/validations.js') }}"></script>
@endsection
@section('content')

    <div class="titleBlock">
        <h2 class="mt-5 p-4">CREAR NUEVO SOCIO</h2>
    </div>

    <div class="d-flex align-items-center justify-content-center">
        <div class="p-3" style="width:90%">
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

            <form action="{{ route('partner.store') }}" method="POST" enctype="multipart/form-data"
                onsubmit="return validatePartnerForm(this);">
                @csrf
                {{-- PRIMERA FILA --}}
                <div class="row mb-4">
                    {{-- BLOQUE DATOS PERSONALES --}}
                    <div class="col-12">
                        <h3>Datos personales</h3>
                        <hr class="del">
                        <div class="p-3">
                            {{-- BLOQUE OTROS CAMPOS --}}
                            <div class="row mb-2">
                                <div class="form-group col-6">
                                    <label for="dni">DNI:</label>
                                    <input type="text" class="form-control" name="dni" id="dni">
                                </div>
                                <div class="form-group col-6">
                                    <label for="fechaNacimiento">Fecha nacimiento:</label>
                                    <input type="date" class="form-control" name="fechaNacimiento" id="fechaNacimiento">
                                </div>
                            </div>

                            {{-- BLOQUE NOMBRES --}}
                            <div class="row mb-2">
                                <div class="form-group col-6">
                                    <label for="prNombre">Primer nombre:</label>
                                    <input type="text" class="form-control" name="prNombre" id="prNombre"
                                        >
                                </div>
                                <div class="form-group col-6">
                                    <label for="sgNombre">Segundo nombre:</label>
                                    <input type="text" class="form-control" name="sgNombre" id="sgNombre"
                                        >
                                </div>
                            </div>

                            {{-- BLOQUE APELLIDOS --}}
                            <div class="row mb-2">
                                <div class="form-group col-6">
                                    <label for="prApellido">Primer apellido:</label>
                                    <input type="text" class="form-control" name="prApellido" id="prApellido"
                                        >
                                </div>
                                <div class="form-group col-6">
                                    <label for="sgApellido">Segundo apellido:</label>
                                    <input type="text" class="form-control" name="sgApellido" id="sgApellido"
                                        >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SEGUNDA FILA --}}
                <div class="row">

                    {{-- BLOQUE DIRECCIÓN --}}
                    <div class="col-lg-6">
                        <h3>Dirección</h3>
                        <hr class="del">
                        <div class="p-3">
                            <div class="form-group">
                                <label for="direccion">Direccion:</label>
                                <input type="text" class="form-control" name="direccion" id="direccion" >
                            </div>
                            <div class="row mb-2">
                                <div class="form-group col-6">
                                    <label for="localidad">Localidad:</label>
                                    <input type="text" class="form-control" name="localidad" id="localidad"
                                        >
                                </div>
                                <div class="form-group col-6">
                                    <label for="cp">Codigo postal:</label>
                                    <input type="number" class="form-control" name="cp" id="cp">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- BLOQUE DE CONTACTO --}}
                    <div class="col-lg-6">
                        <h3>Contacto</h3>
                        <hr class="del">
                        <div class="p-3">
                            <div class="row mb-2">
                                <div class="form-group col-4">
                                    <label for="tel">Telefono:</label>
                                    <input type="number" class="form-control" name="tel" id="tel"
                                        >
                                </div>
                                <div class="form-group col-4">
                                    <label for="prTelResp">1º Telefono responsable:</label>
                                    <input type="number" class="form-control" name="prTelResp" id="prTelResp"
                                        >
                                </div>
                                <div class="form-group col-4">
                                    <label for="sgTelResp">2º Telefono responsable:</label>
                                    <input type="number" class="form-control" name="sgTelResp" id="sgTelResp"
                                        >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="text" class="form-control" name="email" id="email"
                                    placeholder="example@example.com">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- BLOQUE DE ALERGIAS --}}
                <div>
                    <h3>Alergias</h3>
                    <hr class="del">
                    <div class="form-group">
                        <textarea class="form-control" style="height:200px;" name="alergias" id="alergias"></textarea>
                    </div>
                </div>

                {{-- BLOQUE DE FOTO --}}
                <div class="mt-2">
                    <h3>Foto(Max 400px x 400px)</h3>
                    <hr class="del">
                    <div class="form-group">
                        <input type="file" class="form-control" name="foto" id="foto" accept="image/*">
                    </div>
                </div>

                <button type="submit" class="btn btn-success mt-3">Crear</button>

            </form>
        </div>
    </div>

@endsection
