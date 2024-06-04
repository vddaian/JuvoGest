@extends('layouts.app')
@section('title', 'Usuarios')
@section('head')
    <link rel="stylesheet" href="{{ asset('styles/list.css') }}">
@endsection
@section('content')

    <div class="titleBlock">
        <h2 class="mt-5 p-4">Usuarios</h2>
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
                    <form action="" method="post" class="d-flex col-10" style="float: left">
                        @csrf

                        <div class="form-group col-3 p-1">
                            <input type="text" class="form-control" name="entidad" id="entidad" placeholder="Entidad">
                        </div>

                        <div class="form-group col-3 p-1">
                            <input type="text" class="form-control" name="usuario" id="usuario"
                                placeholder="Usuario">
                        </div>

                        <div class="form-group col-3 p-1">
                            <input type="text" class="form-control" name="localidad" id="localidad" placeholder="Localidad">
                        </div>

                        {{-- BLOQUE ACCIONADORES --}}
                        <div class="col-3 p-1">
                            <button type="submit" class="btn border" onclick="charge()"
                                formaction="{{ route('user.filter') }}">
                                <img src="{{ asset('media/ico/search.ico') }}" width="20px" height="20px"
                                    alt="searchICO">
                            </button>
                            <button type="reset" class="btn border">
                                <img src="{{ asset('media/ico/clean.ico') }}" width="20px" height="20px" alt="cleanICO">
                            </button>
                            <a href="{{ route('user.create') }}" class="btn border">+</a>
                        </div>

                    </form>

                    {{-- BLOQUE PAGINADOR --}}
                    <div class="col-2 d-flex align-items-center" style="float: right">
                        {{ $data->links('other.paginator') }}
                    </div>
                </div>
            </div>

            {{-- TABLA DE DATOS --}}
            @if (!isset($data[0]))
                <div class="m-2 p-3 info">
                    <p>No hay usuarios!</p>
                </div>
            @else
                <table class="w-100 listTable">
                    <tr class="row mt-3 mx-3 listHead">
                        <th class="col-1"></th>
                        <th class="col-1">Id</th>
                        <th class="col-3">N.Entidad</th>
                        <th class="col-1">N.Usuario</th>
                        <th class="col-1">CP</th>
                        <th class="col-1">Localidad</th>
                        <th class="col-2">Email</th>
                        <th class="col-1">Rol</th>
                        <th class="col-1"></th>
                    </tr>
                    @foreach ($data as $elem)
                        <tr class="row mx-3 listRow">
                            <td class="col-1 justify-content-center"><img src="data:image/png;base64,{{ $elem->foto }}"
                                    alt=""></td>
                            <td class="col-1">{{ $elem->id }}</td>
                            <td class="col-3">{{ $elem->nombreEntidad }}</td>
                            <td class="col-1">{{ $elem->username }}</td>
                            <td class="col-1">{{ $elem->cp }}</td>
                            <td class="col-1">{{ $elem->localidad }}</td>
                            <td class="col-2">{{ $elem->email }}</td>
                            <td class="col-1">{{ $elem->rol }}</td>
                            <td class="col-1 p-0">
                                <div class="w-100 h-100 m-0 d-flex justify-content-between">
                                    <form class="w-100 h-100 m-0  d-flex justify-content-between"
                                        action="{{ route('user.view', $elem->id) }}" method="get">
                                        @csrf
                                        <button class="listFormButton">
                                            <img src="{{ asset('media/ico/view.ico') }}" alt="View user button">
                                        </button>
                                    </form>
                                    <form class="w-100 h-100 m-0  d-flex justify-content-between"
                                        action="{{ route('user.edit', $elem->id) }}" method="get">
                                        @csrf
                                        <button class="listFormButton">
                                            <img src="{{ asset('media/ico/edit.ico') }}" alt="Edit user button">
                                        </button>
                                    </form>
                                    <form class="w-100 h-100 m-0  d-flex justify-content-between"
                                        action="{{ route('admin.user.info.delete') }}" method="post">
                                        @method('put')
                                        @csrf
                                        <input type="hidden" value="{{ $elem->id }}" name="id" id="id">
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
