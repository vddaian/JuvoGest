@extends('layouts.app')
@section('title', 'Incidencia')
@section('head')
    <link rel="stylesheet" href="{{asset('styles/view.css')}}">
@endsection
@section('content')

    <div class="titleBlock">
        <h2 class="mt-5 p-4">INCIDENCIA {{$data[0]->idIncidencia}}</h2>
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
                <div class="row p-3">
                    <div class="col-4">
                        <p class="viewLabel">Socio:</p>
                        <p class="viewField">{{$data[0]->socio}}</p>
                    </div>
                    <div class="col-2">
                        <p class="viewLabel">Tipo:</p>
                        <p class="viewField">{{$data[0]->tipo}}</p>
                    </div>
                    <div class="col-3">
                        <p class="viewLabel">Fecha fin expulsion:</p>
                        <p class="viewField">{{$data[0]->fechaFinExp}}</p>
                    </div>
                    <div class="col-3">
                        <p class="viewLabel">Fecha expulsion:</p>
                        <p class="viewField" >{{$data[0]->fechaInc}}</p>
                    </div>
                </div>

                <h3>Información</h3>
                <hr class="del">

                {{-- BLOQUE DE INFORMACIÓN --}}
                <div class="p-3">
                    <p class="viewField" style="height: 200px;">
                        {{$data[0]->informacion}}
                    </p>
                </div>
            </div>
        </div>
    </div>

@endsection
