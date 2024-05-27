@extends('layouts.app')
@section('title', 'Crear incidencia')
@section('content')

    <div class="titleBlock">
        <h2 class="mt-5 p-4">CREAR NUEVA INCIDENCIA</h2>
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
                <form action="{{ route('incident.store') }}" method="POST">
                    @csrf
                    <h3>Datos generales</h3>
                    <hr class="del">

                    {{-- BLOQUE DE DATOS GENERALES --}}
                    <div class="row p-3">
                        <div class="form-group col-5">
                            <label for="socio">Socio:</label>
                            <select name="socio" id="socio" class="form-select">
                                @foreach ($data as $elem)
                                    <option value="{{ $elem->idSocio }}">
                                        {{ $elem->prNombre . ' ' . $elem->sgNombre . ' ' . $elem->prApellido . ' ' . $elem->sgApellido }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-2">
                            <label for="tipo">Tipo:</label>
                            <select name="tipo" id="tipo" class="form-select">
                                <option value="LEVE">LEVE</option>
                                <option value="GRAVE">GRAVE</option>
                                <option value="MUY GRAVE">MUY GRAVE</option>
                            </select>
                        </div>
                        <div class="form-group col-3">
                            <label for="fechaFinExp">Fecha final expulsión:</label>
                            <input type="date" id="fechaFinExp" class="form-control" name="fechaFinExp">
                        </div>
                    </div>

                    <h3>Información</h3>
                    <hr class="del">

                    {{-- BLOQUE DE INFORMACIÓN --}}
                    <div class="p-3">
                        <div class="form-group">
                            <textarea class="form-control" style="height: 350px;" name="info" id="info"></textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success mt-3">Crear</button>
                </form>
            </div>
        </div>
    </div>

@endsection
