@extends('layouts.app')
@section('title', 'Socios')
@section('head')
    <link rel="stylesheet" href="{{ asset('styles/view.css') }}">
    <style>
        @media (max-width: 1400px){
            .partnerImg{
                display: none;
            }
        }
    </style>
@endsection
@section('content')

    <div class="titleBlock">
        <h2 class="mt-5 p-4">USUARIO</h2>
    </div>

    {{-- Bloques principales --}}
    <div class="d-flex align-items-center justify-content-center">

        <div class="p-3" style="width:90%">
            {{-- Bloque para información de acciones --}}
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

            {{-- PRIMERA FILA --}}
            <div class="row mb-4">

                {{-- BLOQUE IMAGEN --}}
                <div class="col-3">
                    <img src="data:image/png;base64,{{ $data[0]['foto'] }}" alt="partnerImage" width="300px" height="300px"
                        class="rounded-circle partnerImg">
                </div>

                {{-- BLOQUE DATOS PERSONALES --}}
                <div class="col-xxl-9">
                    <h3>Datos Generales</h3>
                    <hr class="del">
                    <div class="p-3">
                        <div class="row mb-2">
                            <div class="col-8">
                                <p class="viewLabel">N.Entidad:</p>
                                <p class="viewField">{{ $data[0]['nombreEntidad'] }}</p>
                            </div>
                            <div class="col-4">
                                <p class="viewLabel">N.Usuario:</p>
                                <p class="viewField">{{ $data[0]['username'] }}</p>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-8">
                            </div>
                            <div class="col-4">
                                <p class="viewLabel">Rol:</p>
                                <p class="viewField">{{ $data[0]['rol'] }}</p>
                            </div>
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
                        <div class="mb-2">
                            <p class="viewLabel">Dirección:</p>
                            <p class="viewField">{{ $data[0]['direccion'] }}</p>
                        </div>
                        <div class="row mb-2">
                            <div class="col-lg-8">
                                <p class="viewLabel">Localidad:</p>
                                <p class="viewField">{{ $data[0]['localidad'] }}</p>
                            </div>
                            <div class="col-lg-4">
                                <p class="viewLabel">Codigo Postal:</p>
                                <p class="viewField">{{ $data[0]['cp'] }}</p>
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
                            <div class="col-lg-4">
                                <p class="viewLabel">Telefono:</p>
                                <p class="viewField">{{ $data[0]['telefono'] }}</p>
                            </div>
                            <div class="col-lg-8">
                                <p class="viewLabel">Email:</p>
                                <p class="viewField">{{ $data[0]['email'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
