@extends('layouts.app')
@section('title', 'Incidencias')
@section('head')
    <link rel="stylesheet" href="{{ asset('styles/list.css') }}">
@endsection
@section('content')

    <div class="titleBlock">
        <h2 class="mt-5 p-4">INCIDENCIAS</h2>
    </div>

    {{-- BLOQUE PRINCIPAL --}}
    <div class="d-flex align-items-center justify-content-center">

        <div class="p-3" style="width:90%">
            {{-- BLOQUE ACCIONADORES INFORMATIVOS --}}
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

            <div class="d-flex justify-content-between w-100 px-2">
                <div class="w-100 listPanels col-12">

                    {{-- BLOQUE FILTROS --}}
                    <form action="" method="post" class="d-flex col-9">
                        @csrf
                        <div class="form-group col-2 p-1">
                            <input type="text" class="form-control" name="id" id="id" placeholder="Id">
                        </div>

                        <div class="form-group col-3 p-1">
                            <select name="socio" id="socio" class="form-select">
                                <option value="-">-</option>
                                @foreach ($data['partners'] as $elem)
                                    <option value="{{ $elem->idSocio }}">
                                        {{ $elem->prNombre . ' ' . $elem->sgNombre . ' ' . $elem->prApellido . ' ' . $elem->sgApellido }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-2 p-1">
                            <select name="tipo" id="tipo" class="form-select">
                                <option value="-">-</option>
                                <option value="LEVE">LEVE</option>
                                <option value="GRAVE">GRAVE</option>
                                <option value="MUY GRAVE">MUY GRAVE</option>
                            </select>
                        </div>

                        <div class="form-group col-2 p-1">
                            <input type="date" class="form-control" name="fecha" id="fecha" placeholder="Fecha">
                        </div>

                        {{-- BLOQUE ACCIONADORES --}}
                        <div class="col-3 p-1">
                            <button type="submit" class="btn border" onclick="charge()"
                                formaction="{{ route('incident.filter') }}">
                                <img src="{{ asset('media/ico/search.ico') }}" width="20px" height="20px"
                                    alt="searchICO">
                            </button>
                            <button type="reset" class="btn border">
                                <img src="{{ asset('media/ico/clean.ico') }}" width="20px" height="20px" alt="cleanICO">
                            </button>
                            <a href="{{ route('incident.create') }}" class="btn border">+</a>
                        </div>

                    </form>

                    {{-- BLOQUE PAGINADOR --}}
                    <div class="col-2 d-flex align-items-center">
                        {{ $data['incidents']->links('other.paginator') }}
                    </div>
                </div>
            </div>
            {{-- TABLA DE DATOS --}}
            @if (!isset($data['incidents'][0]))
                <div class="m-2 p-3 info">
                    <p>No hay recursos en el centro, añade uno!</p>
                </div>
            @else
                <table class="w-100 listTable">
                    <tr class="row mt-3 mx-3 listHead">
                        <th class="col-1">Id</th>
                        <th class="col-2">Nombre</th>
                        <th class="col-1">Tipo</th>
                        <th class="col-3">Info</th>
                        <th class="col-2">F.Incidencia</th>
                        <th class="col-2">Exp.Fin</th>
                        <th class="col-1"></th>
                    </tr>
                    @foreach ($data['incidents'] as $elem)
                        <tr class="row mx-3 listRow">
                            <td class="col-1">{{ $elem->idIncidencia }}</td>
                            <td class="col-2">{{ $elem->socio }}</td>
                            <td class="col-1">{{ $elem->tipo }}</td>
                            <td class="col-3">{{ $elem->informacion }}</td>
                            <td class="col-2">{{ $elem->fechaInc }}</td>
                            <td class="col-2">{{ $elem->fechaFinExp }}</td>
                            <td class="col-1 p-0">
                                <div class="w-100 h-100 m-0 d-flex justify-content-between">
                                    <form class="w-100 h-100 m-0  d-flex justify-content-between"
                                        action="{{ route('incident.view', $elem->idIncidencia) }}" method="get">
                                        @csrf
                                        <button class="listFormButton">
                                            <img src="{{ asset('media/ico/view.ico') }}" alt="View user button">
                                        </button>
                                    </form>
                                    <form class="w-100 h-100 m-0  d-flex justify-content-between"
                                        action="{{ route('incident.edit', $elem->idIncidencia) }}" method="get">
                                        @csrf
                                        <button class="listFormButton">
                                            <img src="{{ asset('media/ico/edit.ico') }}" alt="Edit user button">
                                        </button>
                                    </form>
                                    <form class="w-100 h-100 m-0  d-flex justify-content-between"
                                        action="{{ route('incident.disable', $elem->idIncidencia) }}" method="post">
                                        @csrf
                                        <button class="listFormButton">
                                            <img src="{{ asset('media/ico/delete.ico') }}" alt="Delete user button">
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

@endsection
