@extends('layouts.app')
@section('title', 'Socios')
@section('head')
    <link rel="stylesheet" href="{{ asset('styles/view.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/list.css') }}">
@endsection
@section('content')

    <div class="titleBlock">
        <h2 class="mt-5 p-4">SALA {{ $data['room'][0]['idSala'] }}</h2>
    </div>

    {{-- BLOQUE PRINCIPAL --}}
    <div class="d-flex align-items-center justify-content-center">

        <div class="p-3" style="width:90%">
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

            {{-- BLOQUE DE DATOS --}}
            <div class="w-100">
                <h3>Datos generales</h3>
                <hr class="del">

                {{-- BLOQUE DE DATOS GENERALES --}}
                <div class="row p-3">
                    <div class="col-3">
                        <p class="viewLabel">Id:</p>
                        <p class="viewField">{{ $data['room'][0]['idSala'] }}</p>
                    </div>
                    <div class="col-9">
                        <p class="viewLabel">Nombre:</p>
                        <p class="viewField">{{ $data['room'][0]['nombre'] }}</p>
                    </div>
                </div>
                <h3>Información</h3>
                <hr class="del">

                {{-- BLOQUE DE INFORMACIÓN --}}
                <div class="p-3">
                    <p class="viewField" style="height: 200px;">{{ $data['room'][0]['informacion'] }}</p>
                </div>
            </div>

            {{-- BLOQUE DE RECURSOS --}}
            <div class="w-100">
                <h3>Recursos</h3>
                <hr class="del">
                <div class="row p-3">

                    {{-- BLOQUE DE CREACIÓN --}}
                    <div class="col-3">
                        <h4>Crear</h4>
                        <hr class="del">
                        <form method="post" action="{{ route('resource.store', $data['room'][0]['idSala']) }}">
                            @csrf
                            <div class="form-group mb-2">
                                <label for="">Nombre:</label>
                                <input type="text" class="form-control" name="nombre" id="nombre">
                            </div>
                            <div class="form-group mb-2">
                                <label for="tipo">Tipo:</label>
                                <select name="tipo" id="tipo" class="form-select">
                                    <option value="JUEGOS">JUEGOS</option>
                                    <option value="OFICINA">OFICINA</option>
                                    <option value="OTROS">OTROS</option>
                                </select>
                            </div>
                            <div class=" p-1">
                                <button type="submit" class="btn btn-success">Añadir</button>
                            </div>
                        </form>
                    </div>


                    {{-- BLOQUE DE LISTA DE RECURSOS --}}
                    <div class="col-9">
                        @if (!isset($data['resources'][0]))
                            <div class="w-100 mb-1 p-2 info">
                                <p>No hay recursos en esta sala, añade uno!</p>
                            </div>
                        @else
                            <div class="d-flex justify-content-between w-100 px-2">
                                <div class="w-100 pb-0 listPanels row">

                                    {{-- Bloque de filtros --}}
                                    <form action="" method="post" class="d-flex col-9">
                                        @csrf
                                        <div class="form-group col-2 p-1">
                                            <input type="text" class="form-control" name="id" id="id"
                                                placeholder="Id">
                                        </div>

                                        <div class="form-group col-3 p-1">
                                            <input type="text" class="form-control" name="nombre" id="nombre"
                                                placeholder="Nombre">
                                        </div>

                                        {{-- Bloque accionadores --}}
                                        <div class="col-3 p-1">
                                            <button type="submit" class="btn border" onclick="charge()"
                                                formaction="{{ route('resource.filter', $data['room'][0]['idSala']) }}">
                                                <img src="{{ asset('media/ico/search.ico') }}" width="20px"
                                                    height="20px" alt="searchICO">
                                            </button>
                                            <button type="reset" class="btn border">
                                                <img src="{{ asset('media/ico/clean.ico') }}" width="20px" height="20px"
                                                    alt="cleanICO">
                                            </button>
                                            <a href="{{ route('room.create') }}" class="btn border">+</a>
                                        </div>

                                    </form>

                                    {{-- Bloque paginador --}}
                                    <div class="col-2 p-1 d-flex align-items-center">
                                        {{ $data['resources']->links('other.paginator') }}
                                    </div>
                                </div>
                            </div>
                            <table class="w-100 listTable">
                                <tr class="row mt-3 mx-3 listHead">
                                    <th class="col-1">Id</th>
                                    <th class="col-9">Nombre</th>
                                    <th class="col-1">Tipo</th>
                                    <th class="col-1"></th>
                                </tr>
                                @foreach ($data['resources'] as $elem)
                                    <tr class="row mx-3 listRow">
                                        <td class="col-1 text-right">{{ $elem->idRecurso }}</td>
                                        <td class="col-9">{{ $elem->nombre }}</td>
                                        <td class="col-1">{{ $elem->tipo }}</td>
                                        <td class="col-1 p-0">
                                            <div class="w-100 h-100 m-0 d-flex justify-content-between">
                                                <form class="w-100 h-100 m-0  d-flex justify-content-between"
                                                    action="{{ route('room.edit', $elem->idRecurso) }}" method="get">
                                                    @csrf
                                                    <button class="listFormButton">
                                                        <img src="{{ asset('media/ico/edit.ico') }}"
                                                            alt="Edit user button">
                                                    </button>
                                                </form>
                                                <form class="w-100 h-100 m-0  d-flex justify-content-between"
                                                    action="{{ route('resource.disable',[$data['room'][0]['idSala'], $elem->idRecurso]) }}" method="post">
                                                    @csrf
                                                    <button class="listFormButton">
                                                        <img src="{{ asset('media/ico/delete.ico') }}"
                                                            alt="Delete user button">
                                                    </button>
                                                </form>

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
