@extends('layouts.app')
@section('title', 'Socios')
@section('head')
    <link rel="stylesheet" href="{{ asset('styles/list.css') }}">
@endsection
@section('content')

    <div class="titleBlock">
        <h2 class="mt-5 p-4">SOCIOS</h2>
    </div>

    {{-- BLOQUE PRINCIPAL --}}
    <div class="d-flex align-items-center justify-content-center">

        <div class="p-3" style="width:90%">
            {{-- BLOQUE ACCIONADORES INFORMATIVOS --}}
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

            <div class="d-flex justify-content-between w-100 px-2">
                <div class="w-100 listPanels col-12">

                    {{-- BLOQUE FILTROS --}}
                    <form action="" method="post" class="row col-lg-10" style="float: left">
                        @csrf
                        <div class="form-group col-lg-1 p-1">
                            <input type="text" class="form-control" name="dni" id="dni" placeholder="DNI">
                        </div>

                        <div class="form-group col-lg-3 p-1">
                            <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre">
                        </div>

                        <div class="form-group col-lg-3 p-1">
                            <input type="text" class="form-control" name="apellido" id="apellido"
                                placeholder="Apellido">
                        </div>

                        <div class="form-group col-lg-2 p-1">
                            <input type="date" class="form-control" name="fecha" id="fecha" placeholder="Fecha">
                        </div>

                        {{-- BLOQUE ACCIONADORES --}}
                        <div class="col-lg-3 p-1">
                            <button type="submit" class="btn border" onclick="charge()"
                                formaction="{{ route('admin.partners.filter') }}">
                                <img src="{{ asset('media/ico/search.ico') }}" width="20px" height="20px"
                                    alt="searchICO">
                            </button>
                            <button type="reset" class="btn border">
                                <img src="{{ asset('media/ico/clean.ico') }}" width="20px" height="20px" alt="cleanICO">
                            </button>
                        </div>

                    </form>

                    {{-- BLOQUE PAGINADOR --}}
                    <div class="col-lg-2 d-flex align-items-center" style="float: right">
                        {{ $data->links('other.paginator') }}
                    </div>
                </div>
            </div>

            {{-- TABLA DE DATOS --}}
            @if (!isset($data[0]))
                <div class="m-2 p-3 info">
                    <p>No hay socios!</p>
                </div>
            @else
                <table class="w-100 listTable noMobile">
                    <tr class="row mt-3 mx-3 listHead">
                        <th class="col-1"></th>
                        <th class="col-1">DNI</th>
                        <th class="col-3">Nombre</th>
                        <th class="col-1">Localidad</th>
                        <th class="col-1">Teléfono</th>
                        <th class="col-2">Email</th>
                        <th class="col-2">F.Nacimiento</th>
                        <th class="col-1"></th>
                    </tr>
                    @foreach ($data as $elem)
                        <tr class="row mx-3 listRow">
                            <td class="col-1 justify-content-center"><img src="data:image/png;base64,{{ $elem->foto }}"
                                    alt=""></td>
                            <td class="col-1">{{ $elem->dni }}</td>
                            <td class="col-3">
                                {{ $elem->prNombre . ' ' . $elem->sgNombre . ' ' . $elem->prApellido . ' ' . $elem->sgApellido }}
                            </td>
                            <td class="col-1">{{ $elem->localidad }}</td>
                            <td class="col-1">{{ $elem->telefono }}</td>
                            <td class="col-2">{{ $elem->email }}</td>
                            <td class="col-2">{{ $elem->fechaNacimiento }}</td>
                            <td class="col-1 p-0">
                                <div class="w-100 h-100 m-0 d-flex justify-content-between">
                                    <form class="w-100 h-100 m-0  d-flex justify-content-between"
                                        action="{{ route('admin.partner.info.delete') }}" method="post">
                                        @method('put')
                                        @csrf
                                        <input type="hidden" value="{{$elem->idSocio}}" name="id" id="id">
                                        <button class="listFormButton">
                                            <img src="{{ asset('media/ico/delete.ico') }}" alt="Delete user button">
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
                <div class="w-100 listBlock mobile">
                    @foreach ($data as $elem)
                        <div class="listElem">
                            <div class="row p-3">
                                <span class="col-lg-2"><img src="data:image/png;base64,{{ $elem->foto }}"
                                        alt=""></span>
                                <div class="col-lg-6 d-flex flex-column">
                                    <span class="col-12"><strong>DNI/NIE:</strong> {{ $elem->dni }}</span>
                                    <span class="col-12"><strong>Nombre completo:</strong>
                                        {{ $elem->prNombre . ' ' . $elem->sgNombre . ' ' . $elem->prApellido . ' ' . $elem->sgApellido }}</span>
                                    <span class="col-12"><strong>Localidad:</strong> {{ $elem->localidad }}</span>

                                </div>
                                <div class="col-lg-4 d-flex flex-column">
                                    <span class="col-12"><strong>Telefono:</strong> {{ $elem->telefono }}</span>
                                    <span class="col-12"><strong>Email:</strong> {{ $elem->email }}</span>
                                    <span class="col-12"><strong>F.Nacimiento:</strong>
                                        {{ $elem->fechaNacimiento }}</span>
                                </div>

                            </div>

                            <span class="p-0">
                                <div class="w-100 h-100 m-0 d-flex justify-content-between">
                                    <form class="w-100 h-100 m-0  d-flex justify-content-between"
                                        action="{{ route('admin.partner.info.delete') }}" method="post">
                                        @method('put')
                                        @csrf
                                        <input type="hidden" value="{{$elem->idSocio}}" name="id" id="id">
                                        <button class="listFormButton">
                                            <img src="{{ asset('media/ico/delete.ico') }}" alt="Delete user button">
                                        </button>
                                    </form>
                                </div>
                            </span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

@endsection
