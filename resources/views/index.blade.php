@extends('layouts.app')
@section('title', 'Inicio')
@section('head')
    <link rel="stylesheet" href="{{ asset('styles/home.css') }}">
@endsection
@section('content')
    <div class="titleBlock">
        <h2 class="mt-5 p-4">INICIO</h2>
    </div>

    {{-- BLOQUE PRINCIPAL --}}
    <div class="d-flex align-items-center justify-content-center">

        <div class="p-2 w-100">
            {{-- BLOQUE ACCIONADORES INFORMATIVOS --}}
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
            <div class="w-100 px-2">
                <div class="row p-3">
                    <div class="col-xl-4 mb-2">
                        <h4 class="listTitle m-0 p-2">
                            SOCIOS EXPULSADOS
                        </h4>
                        <div class="list p-3">
                            @foreach ($data['outPartners'] as $elem)
                                <div class="listElem p-2 elem" onclick="window.location.href = '{{route('partner.view', $elem->idSocio)}}'; charge();">
                                    <img width="40px" height="40px" style="margin-right:10px" class="rounded-circle"
                                        src="data:image/png;base64,{{ $elem->foto }}" alt="outImage{{ $elem->idSocio }}">
                                    <div>
                                        <p><strong>{{ $elem->prNombre . ' ' . $elem->sgNombre . ' ' . $elem->prApellido . ' ' . $elem->sgApellido }}</strong></p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-xl-4 mb-2">
                        <h4 class="listTitle m-0 p-2">
                            NUEVOS SOCIOS
                        </h4>
                        <div class="list p-3">
                            @foreach ($data['newPartners'] as $elem)
                                <div class="listElem p-2 elem" onclick="window.location.href = '{{route('partner.view', $elem->idSocio)}}'; charge();">
                                    <img width="40px" height="40px" style="margin-right:10px" class="rounded-circle"
                                        src="data:image/png;base64,{{ $elem->foto }}" alt="newImage{{ $elem->Id }}">
                                    <div>
                                        <p><strong>{{ $elem->prNombre . ' ' . $elem->sgNombre . ' ' . $elem->prApellido . ' ' . $elem->sgApellido }}</strong></p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-xl-4 mb-2">
                        <h4 class="listTitle m-0 p-2">
                            PROXIMOS EVENTOS
                        </h4>
                        <div class="list p-3">
                            @foreach ($data['events'] as $elem)
                                <div class="listElem p-2 elem d-flex justify-content-between" onclick="window.location.href = '{{route('event.view', $elem->idEvento)}}' charge();">
                                    <p><strong>{{ $elem->titulo }}</strong></p>
                                    <p>{{ $elem->fechaEvento . ' ' . $elem->horaEvento }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="row p-3">
                    <div class="col-xl-4">
                        <h4 class="listTitle m-0 p-2">
                            NUEVAS INCIDENCIAS
                        </h4>
                        <div class="list p-3">
                            @foreach ($data['incidents'] as $elem)
                                <div class="listElem p-2 elem" onclick="window.location.href = '{{route('incident.view', $elem->idIncidencia)}}'; charge();">
                                    <span class="h-50" ></span>
                                    <span class="d-flex justify-content-between">
                                        <p><strong>{{ $elem->socio }}</strong></p>
                                        <p>{{ $elem->fechaInc }}</p>
                                    </span>
                                    <p>{{ $elem->informacion }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
