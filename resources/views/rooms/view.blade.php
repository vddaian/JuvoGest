@extends('layouts.app')
@section('title', 'Socios')
@section('head')
    <link rel="stylesheet" href="{{ asset('styles/view.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/list.css') }}">
    <script src="{{ asset('js/list.js') }}"></script>
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

                    {{-- BLOQUE DE AÑADIR --}}
                    <div class="col-md-2 mb-2" id="addForm">
                        <h4>Añadir</h4>
                        <hr class="del">
                        <form method="post" action="{{ route('resource.add') }}">
                            @method('put')
                            @csrf
                            <input type="hidden" name="idSala" id="idSala" value="{{ $data['room'][0]['idSala'] }}">
                            <div class="form-group mb-2">
                                <label for="recurso">Recurso:</label>
                                <select name="recurso" id="recurso" class="form-select">
                                    @foreach ($data['resources'] as $elem)
                                        <option value="{{ $elem->idRecurso }}">{{ $elem->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class=" p-1">
                                <button type="submit" class="btn btn-success">Añadir</button>
                            </div>
                        </form>
                    </div>

                    {{-- BLOQUE DE LISTA DE RECURSOS --}}
                    <div class="col-md-10">
                        <div class="d-flex justify-content-between w-100 px-2">
                            <div class="w-100 listPanels col-12">
                                {{-- Bloque de filtros --}}
                                <form action="" method="post" class="row col-lg-10" style="float: left;">
                                    @csrf
                                    <div class="form-group col-lg-2 p-1">
                                        <input type="text" class="form-control" name="id" id="id"
                                            placeholder="Id">
                                    </div>

                                    <div class="form-group col-lg-3 p-1">
                                        <input type="text" class="form-control" name="nombre" id="nombre"
                                            placeholder="Nombre">
                                    </div>

                                    <div class="form-group col-lg-2 p-1">
                                        <select name="tipo" id="tipo" class="form-select">
                                            <option value="-">-</option>
                                            <option value="JUEGOS">JUEGOS</option>
                                            <option value="DEPORTE">DEPORTE</option>
                                            <option value="OFICINA">OFICINA</option>
                                            <option value="OTROS">OTROS</option>
                                        </select>
                                    </div>
                                    {{-- Bloque accionadores --}}
                                    <div class="col-lg-3 p-1">
                                        <button type="submit" class="btn border" onclick="charge()"
                                            formaction="{{ route('resource.room.filter', $data['room'][0]['idSala']) }}">
                                            <img src="{{ asset('media/ico/search.ico') }}" width="20px" height="20px"
                                                alt="searchICO">
                                        </button>
                                        <button type="reset" class="btn border">
                                            <img src="{{ asset('media/ico/clean.ico') }}" width="20px" height="20px"
                                                alt="cleanICO">
                                        </button>
                                    </div>
                                </form>

                                {{-- Bloque paginador --}}
                                <div class="col-lg-2 d-flex align-items-center" style="float: right;">
                                    {{ $data['rmResources']->links('other.paginator') }}
                                </div>
                            </div>
                        </div>

                        @if (!isset($data['rmResources'][0]))
                            <div class="m-2 p-3 info">
                                <p>No hay recursos en esta sala, añade uno!</p>
                            </div>
                        @else
                            <table class="w-100 listTable noMobile">
                                <tr class="row mt-3 mx-3 listHead">
                                    <th class="col-1">Id</th>
                                    @if ($data['storage'])
                                        <th class="col-10">Nombre</th>
                                    @else
                                        <th class="col-9">Nombre</th>
                                    @endif
                                    <th class="col-1">Tipo</th>
                                    @if (!$data['storage'])
                                        <th class="col-1"></th>
                                    @endif

                                </tr>
                                @foreach ($data['rmResources'] as $elem)
                                    <tr class="row mx-3 listRow">
                                        <td class="col-1 text-right">{{ $elem->idRecurso }}</td>
                                        @if ($data['storage'])
                                            <td class="col-10">{{ $elem->nombre }}</td>
                                        @else
                                            <td class="col-9">{{ $elem->nombre }}</td>
                                        @endif
                                        <td class="col-1">{{ $elem->tipo }}</td>
                                        @if (!$data['storage'])
                                            <td class="col-1 p-0">
                                                <div class="w-100 h-100 m-0 d-flex justify-content-between">
                                                    <form class="w-100 h-100 m-0  d-flex justify-content-between"
                                                        action="{{ route('resource.storage') }}" method="post">
                                                        @method('put')
                                                        @csrf
                                                        <input type="hidden" id="idRecurso" name="idRecurso"
                                                            value="{{ $elem->idRecurso }}">
                                                        <button class="listFormButton">
                                                            <img src="{{ asset('media/ico/arrow.ico') }}"
                                                                alt="Send to storage button">
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </table>
                            <div class="w-100 listBlock mobile">
                                @foreach ($data['rmResources'] as $elem)
                                    <div class="listElem">
                                        <div class="row p-3">
                                            <div class="col-lg-6 d-flex flex-column">
                                                <span class="col-12"><strong>Id:</strong> {{ $elem->idRecurso}}</span>
                                                <span class="col-12"><strong>Nombre:</strong>
                                                    {{ $elem->nombre }}</span>
                                                <span class="col-12"><strong>Tipo:</strong> {{ $elem->tipo }}</span>

                                            </div>

                                        </div>

                                        @if (!$data['storage'])
                                            <td class="p-0">
                                                <div class="w-100 h-100 m-0 d-flex justify-content-between">
                                                    <form class="w-100 h-100 m-0  d-flex justify-content-between"
                                                        action="{{ route('resource.storage') }}" method="post">
                                                        @method('put')
                                                        @csrf
                                                        <input type="hidden" id="idRecurso" name="idRecurso"
                                                            value="{{ $elem->idRecurso }}">
                                                        <button class="listFormButton">
                                                            <img src="{{ asset('media/ico/arrow.ico') }}"
                                                                alt="Send to storage button">
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
