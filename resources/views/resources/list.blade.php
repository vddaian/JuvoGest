@extends('layouts.app')
@section('title', 'Socios')
@section('head')
    <link rel="stylesheet" href="{{ asset('styles/list.css') }}">
    <script src="{{ asset('js/list.js') }}"></script>
@endsection
@section('content')

    <div class="titleBlock">
        <h2 class="mt-5 p-4">RECURSOS</h2>
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

            <div class="row p-3">

                {{-- BLOQUE DE CREACIÓN --}}
                <div class="col-2" id="createForm">
                    <h4>Crear</h4>
                    <hr class="del">
                    <form method="post" action="{{ route('resource.store') }}">
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
                                <option value="DEPORTE">DEPORTE</option>
                                <option value="OTROS">OTROS</option>
                            </select>
                        </div>
                        <div class=" p-1">
                            <button type="submit" class="btn btn-success">Añadir</button>
                        </div>
                    </form>
                </div>

                {{-- BLOQUE DE ACTUALIZACIÓN --}}
                <div class="col-2" id="updateForm" hidden>
                    <h4>Actualizar</h4>
                    <hr class="del">
                    <form method="post" action="{{ route('resource.update') }}">
                        @method('put')
                        @csrf
                        <input type="hidden" name="idRecurso" id="upRecurso">
                        <div class="form-group mb-2">
                            <label for="sala">Sala:</label>
                            <select name="sala" id="upSala" class="form-select">
                                @foreach ($data['rooms'] as $elem)
                                    <option value="{{ $elem->idSala }}">{{ $elem->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <label for="">Nombre:</label>
                            <input type="text" class="form-control" name="nombre" id="upNombre">
                        </div>
                        <div class="form-group mb-2">
                            <label for="tipo">Tipo:</label>
                            <select name="tipo" id="upTipo" class="form-select">
                                <option value="JUEGOS">JUEGOS</option>
                                <option value="OFICINA">OFICINA</option>
                                <option value="OFICINA">DEPORTE</option>
                                <option value="OTROS">OTROS</option>
                            </select>
                        </div>
                        <div class=" p-1">
                            <button type="submit" class="btn btn-success">Actualizar</button>
                        </div>
                    </form>
                </div>

                {{-- BLOQUE DE LISTA --}}
                <div class="col-10">
                    <div class="d-flex justify-content-between w-100 px-2">
                        <div class="w-100 listPanels col-12">

                            {{-- BLOQUE DE FILTROS --}}
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
                                <div class="form-group col-2 p-1">
                                    <select name="tipo" id="tipo" class="form-select">
                                        <option value="-">-</option>
                                        <option value="JUEGOS">JUEGOS</option>
                                        <option value="DEPORTE">DEPORTE</option>
                                        <option value="OFICINA">OFICINA</option>
                                        <option value="OTROS">OTROS</option>
                                    </select>
                                </div>

                                {{-- BLOQUE ACCIONADORES --}}
                                <div class="col-3 p-1">
                                    <button type="submit" class="btn border" onclick="charge()"
                                        formaction="{{ route('resource.filter') }}">
                                        <img src="{{ asset('media/ico/search.ico') }}" width="20px" height="20px"
                                            alt="searchICO">
                                    </button>
                                    <button type="reset" class="btn border">
                                        <img src="{{ asset('media/ico/clean.ico') }}" width="20px" height="20px"
                                            alt="cleanICO">
                                    </button>
                                    <button type="button" onclick="changeToCreateForm()" class="btn border">+</button>
                                </div>

                            </form>

                            {{-- BLOQUE PAGINADOR --}}
                            <div class="col-2 d-flex align-items-center">
                                {{ $data['resources']->links('other.paginator') }}
                            </div>
                        </div>
                    </div>

                    @if (!isset($data['resources'][0]))
                        <div class="m-2 p-3 info">
                            <p>No hay recursos en esta sala, añade uno!</p>
                        </div>
                    @else
                        <table class="w-100 listTable">
                            <tr class="row mt-3 mx-3 listHead">
                                <th class="col-1">IdRecurso</th>
                                <th class="col-1">IdSala</th>
                                <th class="col-8">Nombre</th>
                                <th class="col-1">Tipo</th>
                                <th class="col-1"></th>
                            </tr>
                            @foreach ($data['resources'] as $elem)
                                <tr class="row mx-3 listRow">
                                    <td class="col-1 text-right">{{ $elem->idRecurso }}</td>
                                    <td class="col-1 text-right">{{ $elem->idSala }}</td>
                                    <td class="col-8">{{ $elem->nombre }}</td>
                                    <td class="col-1">{{ $elem->tipo }}</td>
                                    <td class="col-1 p-0">
                                        <div class="w-100 h-100 m-0 d-flex justify-content-between">
                                            <button class="listFormButton"
                                                onclick="changeToUpdateForm('{{ $elem->idRecurso }}','{{ $elem->idSala }}', '{{ $elem->nombre }}' , '{{ $elem->tipo }}')">
                                                <img src="{{ asset('media/ico/edit.ico') }}" alt="Edit user button">
                                            </button>
                                            <form class="w-100 h-100 m-0  d-flex justify-content-between"
                                                action="{{ route('resource.disable') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="id" id="id"
                                                    value="{{ $elem->idRecurso }}">
                                                <button type="submit" class="listFormButton">
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

@endsection
