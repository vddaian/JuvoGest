@extends('layouts.app')
@section('title', 'Socios')
@section('head')
    <link rel="stylesheet" href="{{ asset('styles/list.css') }}">
@endsection
@section('content')

    {{-- Bloques principales --}}
    <div class="mt-5 d-flex align-items-center justify-content-center">

        <div class="mt-3 p-5" style="width:90%">
            {{-- Bloque para información de acciones --}}
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

            <div class="d-flex justify-content-between w-100">
                {{-- Bloque de filtros --}}
                <div class="w-75 listPanels">
                    <form action="" method="post" class="row">
                        @csrf
                        <div class="form-group col-3">
                            <input type="text" class="form-control" name="dni" id="dni" placeholder="DNI">
                        </div>
                        <div class="form-group col-3">
                            <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre">
                        </div>
                        <div class="form-group col-3">
                            <input type="text" class="form-control" name="apellido" id="apellido"
                                placeholder="Apellido">
                        </div>
                        <div class="col-2">
                            <button type="submit" class="btn border">
                                <img src="{{asset('media/ico/search.ico')}}" width="20px" height="20px" alt="searchICO">
                            </button>
                            <button type="reset" class="btn border">
                                <img src="{{asset('media/ico/clean.ico')}}" width="20px" height="20px" alt="cleanICO">
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Bloque de accionadores --}}
                <div class="listPanels">
                    <button onclick="window.location='{{ url('partner/create') }}'"
                        class="btn border rounded-circle">+</button>
                </div>
            </div>
            {{-- Tabla --}}
            <table class="w-100 listTable">
                <tr class="row mt-3 mx-3 listHead">
                    <th class="col-1"></th>
                    <th class="col-2">DNI</th>
                    <th class="col-3">Nombre</th>
                    <th class="col-1">Localidad</th>
                    <th class="col-1">Teléfono</th>
                    <th class="col-2">Email</th>
                    <th class="col-1">F.Nacimiento</th>
                    <th class="col-1"></th>
                </tr>
                @foreach ($data as $elem)
                    <tr class="row mx-3 listRow">
                        <td class="col-1"><img src="data:image/png;base64,{{$elem->foto}}" alt=""></td>
                        <td class="col-2">{{$elem->dni}}</td>
                        <td class="col-3">{{$elem->prNombre.' '.$elem->sgNombre.' '.$elem->prApellido.' '.$elem->sgApellido}}</td>
                        <td class="col-1">{{$elem->localidad}}</td>
                        <td class="col-1">{{$elem->telefono}}</td>
                        <td class="col-2">{{$elem->email}}</td>
                        <td class="col-1">{{$elem->fechaNacimiento}}</td>
                        <td class="col-1">
                            <button></button>
                        </td>
                    </tr>
                @endforeach

            </table>
        </div>
    </div>

@endsection
