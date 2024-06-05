@extends('layouts.app')
@section('title', 'Actualizar evento')
@section('head')
    <script src="{{asset('js/validations.js')}}"></script>
@endsection
@section('content')

    <div class="titleBlock">
        <h2 class="mt-5 p-4">ACTUALIZAR EVENTO</h2>
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
                <form action="{{ route('event.update') }}" method="POST" onsubmit="return validateEventForm(this);">
                    @method('put')
                    @csrf
                    <input type="hidden" name="idEvento" id="idEvento"  value="{{ $data['event'][0]['idEvento'] }}">
                    <h3>Datos generales</h3>
                    <hr class="del">

                    {{-- BLOQUE DE DATOS GENERALES --}}
                    <div class="form-group p-3">
                        <label for="titulo">Titulo:</label>
                        <input type="text" id="titulo" class="form-control" name="titulo"
                            value="{{ $data['event'][0]['titulo'] }}">
                    </div>

                    <div class="row p-3">
                        <div class="form-group col-lg-3">
                            <label for="sala">Sala:</label>
                            <select name="sala" id="sala" class="form-select">
                                @foreach ($data['rooms'] as $elem)
                                    @if ($data['event'][0]['idSala'] == $elem->idSala)
                                        <option selected value="{{ $elem->idSala }}">
                                            {{ $elem->nombre }}
                                        </option>
                                    @else
                                        <option value="{{ $elem->idSala }}">
                                            {{ $elem->nombre }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="entidad">Entidad organizadora:</label>
                            <input type="text" id="entidad" class="form-control" name="entidad"
                                value="{{ $data['event'][0]['entidadOrg'] }}">
                        </div>
                        <div class="form-group col-lg-2">
                            <label for="asistentes">Numero asistentes:</label>
                            <input type="number" id="asistentes" class="form-control" name="asistentes"
                                value="{{ $data['event'][0]['numeroAsistentes'] }}">
                        </div>
                        <div class="form-group col-lg-2">
                            <label for="fecha">Fecha evento:</label>
                            <input type="date" id="fecha" class="form-control" name="fecha"
                                value="{{ $data['event'][0]['fechaEvento'] }}">
                        </div>
                        <div class="form-group col-lg-2">
                            <label for="hora">Hora evento:</label>
                            <input type="time" id="hora" class="form-control" name="hora"
                                value="{{ $data['event'][0]['horaEvento'] }}">
                        </div>
                    </div>

                    <h3>Información</h3>
                    <hr class="del">

                    {{-- BLOQUE DE INFORMACIÓN --}}
                    <div class="p-3">
                        <div class="form-group">
                            <textarea class="form-control" style="height: 350px;" name="info" id="info">{{ $data['event'][0]['informacion'] }}</textarea>
                        </div>
                    </div>
                    <button type="submit" onclick="charge()" class="btn btn-success mt-3">Actualizar</button>
                </form>
            </div>
        </div>
    </div>

@endsection
