@extends('layouts.app')
@section('title', 'Eventos')
@section('head')
    <link rel="stylesheet" href="{{ asset('styles/list.css') }}">
@endsection
@section('content')

    <div class="titleBlock">
        <h2 class="mt-5 p-4">EVENTOS</h2>
    </div>

    {{-- BLOQUES PRINCIPALES --}}
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

                        <div class="form-group col-2 p-1">
                            <input type="text" class="form-control" name="entidad" id="entidad" placeholder="Entidad">
                        </div>

                        <div class="form-group col-3 p-1">
                            <select name="sala" id="sala" class="form-select">
                                <option value="-">-</option>
                                @foreach ($data['rooms'] as $elem)
                                    <option value="{{ $elem->idSala }}">
                                        {{ $elem->nombre}}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-2 p-1">
                            <input type="date" class="form-control" name="fecha" id="fecha" placeholder="Fecha">
                        </div>

                        {{-- BLOQUE ACCIONADORES --}}
                        <div class="col-3 p-1">
                            <button type="submit" class="btn border" onclick="charge()"
                                formaction="{{ route('event.filter') }}">
                                <img src="{{ asset('media/ico/search.ico') }}" width="20px" height="20px"
                                    alt="searchICO">
                            </button>
                            <button type="reset" class="btn border">
                                <img src="{{ asset('media/ico/clean.ico') }}" width="20px" height="20px" alt="cleanICO">
                            </button>
                            <a href="{{ route('event.create') }}" class="btn border">+</a>
                        </div>

                    </form>

                    {{-- BLOQUE PAGINADOR --}}
                    <div class="col-2 d-flex align-items-center">
                        {{ $data['events']->links('other.paginator') }}
                    </div>
                </div>
            </div>
            {{-- TABLA DE DATOS --}}
            <table class="w-100 listTable">
                <tr class="row mt-3 mx-3 listHead">
                    <th class="col-1">Id</th>
                    <th class="col-2">Titulo</th>
                    <th class="col-1">Sala</th>
                    <th class="col-2">Entidad Organizadora</th>
                    <th class="col-2">Informacion</th>
                    <th class="col-1">Asistentes Prev</th>
                    <th class="col-1">F.Evento</th>
                    <th class="col-1">H.Evento</th>
                    <th class="col-1"></th>
                </tr>
                @foreach ($data['events'] as $elem)
                    <tr class="row mx-3 listRow">
                        <td class="col-1">{{ $elem->idEvento }}</td>
                        <td class="col-2">{{ $elem->titulo }}</td>
                        <td class="col-1">{{ $elem->sala }}</td>
                        <td class="col-2">{{ $elem->entidadOrg }}</td>
                        <td class="col-2">{{ $elem->informacion }}</td>
                        <td class="col-1">{{ $elem->numeroAsistentes }}</td>
                        <td class="col-1">{{ $elem->fechaEvento }}</td>
                        <td class="col-1">{{ $elem->horaEvento }}</td>
                        <td class="col-1 p-0">
                            <div class="w-100 h-100 m-0 d-flex justify-content-between">
                                <form class="w-100 h-100 m-0  d-flex justify-content-between"
                                    action="{{ route('event.view', $elem->idEvento) }}" method="get">
                                    @csrf
                                    <button class="listFormButton">
                                        <img src="{{ asset('media/ico/view.ico') }}" alt="View user button">
                                    </button>
                                </form>
                                <form class="w-100 h-100 m-0  d-flex justify-content-between"
                                    action="{{ route('event.edit', $elem->idEvento) }}" method="get">
                                    @csrf
                                    <button class="listFormButton">
                                        <img src="{{ asset('media/ico/edit.ico') }}" alt="Edit user button">
                                    </button>
                                </form>
                                <form class="w-100 h-100 m-0  d-flex justify-content-between"
                                    action="{{ route('event.disable', $elem->idEvento) }}" method="post">
                                    @method('put')
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
        </div>
    </div>

@endsection
