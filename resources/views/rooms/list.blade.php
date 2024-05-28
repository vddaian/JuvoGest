@extends('layouts.app')
@section('title', 'Salas')
@section('head')
    <link rel="stylesheet" href="{{ asset('styles/list.css') }}">
@endsection
@section('content')

    <div class="titleBlock">
        <h2 class="mt-5 p-4">SALAS</h2>
    </div>

    {{-- Bloques principales --}}
    <div class="d-flex align-items-center justify-content-center">

        <div class="p-3" style="width:90%">
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

            <div class="d-flex justify-content-between w-100 px-2">
                <div class="w-100 listPanels col-12">

                    {{-- Bloque de filtros --}}
                    <form action="" method="post" class="d-flex col-9">
                        @csrf
                        <div class="form-group col-2 p-1">
                            <input type="text" class="form-control" name="id" id="id" placeholder="Id">
                        </div>

                        <div class="form-group col-3 p-1">
                            <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre">
                        </div>

                        <div class="form-group col-2 p-1">
                            <select name="tipo" id="tipo" class="form-select">
                                <option value="-">-</option>
                                <option value="PEQUEÑA">PEQUEÑA</option>
                                <option value="MEDIANA">MEDIANA</option>
                                <option value="GRANDE">GRANDE</option>
                                <option value="MUY GRANDE">MUY GRANDE</option>
                            </select>
                        </div>

                        {{-- Bloque accionadores --}}
                        <div class="col-3 p-1">
                            <button type="submit" class="btn border" onclick="charge()"
                                formaction="{{ route('room.filter') }}">
                                <img src="{{ asset('media/ico/search.ico') }}" width="20px" height="20px"
                                    alt="searchICO">
                            </button>
                            <button type="reset" class="btn border">
                                <img src="{{ asset('media/ico/clean.ico') }}" width="20px" height="20px" alt="cleanICO">
                            </button>
                            <a href="{{ route('room.create') }}" class="btn border">+</a>
                        </div>

                    </form>

                    {{-- Bloque paginador --}}
                    <div class="col-3 d-flex align-items-center">
                        {{ $data->links('other.paginator') }}
                    </div>
                </div>
            </div>
            {{-- Tabla --}}
            <table class="w-100 listTable">
                <tr class="row mt-3 mx-3 listHead">
                    <th class="col-2">Id</th>
                    <th class="col-4">Nombre</th>
                    <th class="col-4">Información</th>
                    <th class="col-1">Tipo</th>
                    <th class="col-1"></th>
                </tr>
                @foreach ($data as $elem)
                    <tr class="row mx-3 listRow">
                        <td class="col-2 text-right">{{ $elem->idSala }}</td>
                        <td class="col-4">{{ $elem->nombre }}</td>
                        <td class="col-4">{{ $elem->informacion }}</td>
                        <td class="col-1">{{ $elem->tipo }}</td>
                        <td class="col-1 p-0">
                            <div class="w-100 h-100 m-0 d-flex justify-content-between">
                                <form class="w-100 h-100 m-0  d-flex justify-content-between"
                                    action="{{ route('room.view', $elem->idSala) }}" method="get">
                                    @csrf
                                    <button class="listFormButton">
                                        <img src="{{ asset('media/ico/view.ico') }}" alt="View user button">
                                    </button>
                                </form>
                                <form class="w-100 h-100 m-0  d-flex justify-content-between"
                                    action="{{ route('room.edit', $elem->idSala) }}" method="get">
                                    @csrf
                                    <button class="listFormButton">
                                        <img src="{{ asset('media/ico/edit.ico') }}" alt="Edit user button">
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

@endsection
