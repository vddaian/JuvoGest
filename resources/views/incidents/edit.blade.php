@extends('layouts.app')
@section('title', 'Actualizar incidencia')
@section('head')
@endsection
@section('content')

    <div class="titleBlock">
        <h2 class="mt-5 p-4">ACTUALIZAR INCIDENCIA</h2>
    </div>

    <div class="d-flex align-items-center justify-content-center">
        <div class="p-3" style="width: 90%">
            {{-- BLOQUE DE RESPUESTAS --}}
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

            {{-- BLOQUE DE DATOS PRINCIPALES --}}
            <div class="w-100">
                <form action="{{ route('incident.update', $data['incident'][0]['idIncidencia']) }}" method="POST">
                    @csrf
                    <h3>Datos generales</h3>
                    <hr class="del">

                    {{-- BLOQUE DE DATOS GENERALES --}}
                    <div class="row p-3">
                        <div class="form-group col-4">
                            <label for="socio">Socio:</label>
                            <select name="socio" id="socio" class="form-select">
                                @foreach ($data['partners'] as $elem)
                                    @if ($data['incident'][0]['idSocio'] == $elem->idSocio)
                                        <option value="{{ $elem->idSocio }}">
                                            {{ $elem->prNombre . ' ' . $elem->sgNombre . ' ' . $elem->prApellido . ' ' . $elem->sgApellido }}
                                        </option>
                                    @else
                                        <option value="{{ $elem->idSocio }}">
                                            {{ $elem->prNombre . ' ' . $elem->sgNombre . ' ' . $elem->prApellido . ' ' . $elem->sgApellido }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-2">
                            <label for="tipo">Tipo:</label>
                            <select name="tipo" id="tipo" class="form-select">
                                @switch($data['incident'][0]['tipo'])
                                    @case('LEVE')
                                        <option value="LEVE" selected>LEVE</option>
                                        <option value="GRAVE">GRAVE</option>
                                        <option value="MUY GRAVE">MUY GRAVE</option>
                                    @break

                                    @case('GRAVE')
                                        <option value="LEVE">LEVE</option>
                                        <option value="GRAVE" selected>GRAVE</option>
                                        <option value="MUY GRAVE">MUY GRAVE</option>
                                    @break

                                    @case('MUY GRAVE')
                                        <option value="LEVE">LEVE</option>
                                        <option value="GRAVE">GRAVE</option>
                                        <option value="MUY GRAVE" selected>MUY GRAVE</option>
                                    @break

                                    @default
                                @endswitch

                            </select>
                        </div>
                        <div class="form-group col-3">
                            <label for="fechaFinExp">Fecha final expulsión:</label>
                            <input type="date" id="fechaFinExp" class="form-control" name="fechaFinExp" value="{{$data['incident'][0]['fechaFinExp']}}">
                        </div>
                    </div>

                    <h3>Información</h3>
                    <hr class="del">

                    {{-- BLOQUE DE INFORMACIÓN --}}
                    <div class="p-3">
                        <div class="form-group">
                            <textarea class="form-control" style="height: 350px;" name="info" id="info">{{ $data['incident'][0]['informacion'] }}</textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success mt-3">Actualizar</button>
                </form>
            </div>
        </div>
    </div>

@endsection
