@extends('layouts.app')
@section('title', 'Evento')
@section('head')
    <link rel="stylesheet" href="{{asset('styles/view.css')}}">
@endsection
@section('content')
    <div class="titleBlock">
        <h2 class="mt-5 p-4">EVENTO {{ $data[0]->idEvento }}</h2>
    </div>

    <div class="d-flex align-items-center justify-content-center">
        <div class="p-3" style="width: 90%">
            {{-- BLOQUE DE RESPUESTAS --}}
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

            {{-- BLOQUE DE DATOS PRINCIPALES --}}
            <div class="w-100">
                <h3>Datos generales</h3>
                <hr class="del">

                {{-- BLOQUE DE DATOS GENERALES --}}
                <div class="p-3">
                    <p class="viewLabel">Titulo:</p>
                    <p class="viewField">{{ $data[0]->titulo }}</p>
                </div>

                <div class="row p-3">
                    <div class="col-lg-3">
                        <p class="viewLabel">Sala:</p>
                        <p class="viewField">{{ $data[0]->sala }}</p>
                    </div>
                    <div class="col-lg-3">
                        <p class="viewLabel">Entidad organizadora:</p>
                        <p class="viewField">{{ $data[0]->entidadOrg }}</p>
                    </div>
                    <div class="col-lg-2">
                        <p class="viewLabel">Numero asistentes:</p>
                        <p class="viewField">{{ $data[0]->numeroAsistentes }}</p>
                    </div>
                    <div class="col-lg-2">
                        <p class="viewLabel">Fecha evento:</p>
                        <p class="viewField">{{ $data[0]->fechaEvento }}</p>
                    </div>
                    <div class="col-lg-2">
                        <p class="viewLabel">Hora evento:</p>
                        <p class="viewField">{{ $data[0]->horaEvento }}</p>
                    </div>
                </div>

                <h3>Información</h3>
                <hr class="del">

                {{-- BLOQUE DE INFORMACIÓN --}}
                <div class="p-3">
                    <p class="viewField" style="height: 200px;">{{ $data[0]->informacion }}</p>
                </div>
            </div>
        </div>
    </div>

@endsection
