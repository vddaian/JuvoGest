@extends('layouts.app')
@section('title', 'Crear evento')
@section('content')

    <div class="titleBlock">
        <h2 class="mt-5 p-4">CREAR NUEVO EVENTO</h2>
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
                <form action="{{ route('event.store') }}" method="POST">
                    @csrf
                    <h3>Datos generales</h3>
                    <hr class="del">

                    {{-- BLOQUE DE DATOS GENERALES --}}
                    <div class="form-group p-3">
                        <label for="titulo">Titulo:</label>
                        <input type="text" id="titulo" class="form-control" name="titulo">
                    </div>

                    <div class="row p-3">
                        <div class="form-group col-3">
                            <label for="sala">Sala:</label>
                            <select name="sala" id="sala" class="form-select">
                                @foreach ($data as $elem)
                                    <option value="{{ $elem->idSala }}">
                                        {{ $elem->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-3">
                            <label for="entidad">Entidad organizadora:</label>
                            <input type="text" id="entidad" class="form-control" name="entidad">
                        </div>
                        <div class="form-group col-2">
                            <label for="asistentes">Numero asistentes:</label>
                            <input type="number" id="asistentes" class="form-control" name="asistentes">
                        </div>
                        <div class="form-group col-2">
                            <label for="fecha">Fecha evento:</label>
                            <input type="date" id="fecha" class="form-control" name="fecha">
                        </div>
                        <div class="form-group col-2">
                            <label for="hora">Hora evento:</label>
                            <input type="time" id="hora" class="form-control" name="hora">
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
                    <button type="submit" onclick="charge()" class="btn btn-success mt-3">Crear</button>
                </form>
            </div>
        </div>
    </div>

@endsection
