@extends('layouts.app')
@section('title', 'Socios')
@section('head')
    <link rel="stylesheet" href="{{ asset('styles/list.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/view.css') }}">
@endsection
@section('content')

    <div class="titleBlock">
        <h2 class="mt-5 p-4">SOCIO {{ $data['partner'][0]['idSocio'] }}</h2>
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

            {{-- PRIMERA FILA --}}
            <div class="row mb-4">

                {{-- BLOQUE IMAGEN --}}
                <div class="col-3">
                    <img src="data:image/png;base64,{{ $data['partner'][0]['foto'] }}" alt="partnerImage" width="300px"
                        height="300px" class="rounded-circle">
                </div>

                {{-- BLOQUE DATOS PERSONALES --}}
                <div class="col-9">
                    <h3>Datos personales</h3>
                    <hr class="del">
                    <div class="p-3">
                        {{-- BLOQUE OTROS CAMPOS --}}
                        <div class="row mb-2">
                            <div class="col-6">
                                <p class="viewLabel">DNI:</p>
                                <p class="viewField">{{ $data['partner'][0]['dni'] }}</p>
                            </div>
                            <div class="col-6">
                                <p class="viewLabel">Fecha nacimiento:</p>
                                <p class="viewField">{{ $data['partner'][0]['fechaNacimiento'] }}</p>
                            </div>
                        </div>

                        {{-- BLOQUE NOMBRES --}}
                        <div class="row mb-2">
                            <div class="col-6">
                                <p class="viewLabel">Primer nombre:</p>
                                <p class="viewField">{{ $data['partner'][0]['prNombre'] }}</p>
                            </div>
                            <div class="col-6">
                                <p class="viewLabel">Segundo nombre:</p>
                                <p class="viewField">{{ $data['partner'][0]['sgNombre'] }}</p>
                            </div>
                        </div>

                        {{-- BLOQUE APELLIDOS --}}
                        <div class="row mb-2">
                            <div class="col-6">
                                <p class="viewLabel">Primer apellido:</p>
                                <p class="viewField">{{ $data['partner'][0]['prApellido'] }}</p>
                            </div>
                            <div class="col-6">
                                <p class="viewLabel">Segundo apellido:</p>
                                <p class="viewField">{{ $data['partner'][0]['sgApellido'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SEGUNDA FILA --}}
            <div class="row">

                {{-- BLOQUE DIRECCIÓN --}}
                <div class="col-6">
                    <h3>Dirección</h3>
                    <hr class="del">
                    <div class="p-3">
                        <div class="mb-2">
                            <p class="viewLabel">Direccion:</p>
                            <p class="viewField">{{ $data['partner'][0]['direccion'] }}</p>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6">
                                <p class="viewLabel">Localidad:</p>
                                <p class="viewField">{{ $data['partner'][0]['localidad'] }}</p>
                            </div>
                            <div class="col-6">
                                <p class="viewLabel">Codigo postal:</p>
                                <p class="viewField">{{ $data['partner'][0]['cp'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- BLOQUE DE CONTACTO --}}
                <div class="col-6">
                    <h3>Contacto</h3>
                    <hr class="del">
                    <div class="p-3">
                        <div class="row mb-2">
                            <div class="col-4">
                                <p class="viewLabel">Telefono:</p>
                                <p class="viewField">{{ $data['partner'][0]['telefono'] }}</p>
                            </div>
                            <div class="col-4">
                                <p class="viewLabel">1º Telefono responsable:</p>
                                <p class="viewField">{{ $data['partner'][0]['prTelefonoResp'] }}</p>
                            </div>
                            <div class="col-4">
                                <p class="viewLabel">2º Telefono responsable:</p>
                                <p class="viewField">{{ $data['partner'][0]['sgTelefonoResp'] }}</p>
                            </div>
                        </div>
                        <div class="mb-2">
                            <p class="viewLabel">Email:</p>
                            <p class="viewField">{{ $data['partner'][0]['email'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- BLOQUE DE ALERGIAS --}}
            <div>
                <h3>Alergias</h3>
                <hr class="del">
                <div class="p-3">
                    <p class="viewField" style="height: 200px;">{{ $data['partner'][0]['alergias'] }}</p>
                </div>
            </div>

            {{-- BLOQUE DE INCIDENCIAS --}}
            <div>
                <h3>Incidencias</h3>
                <hr class="del">
                <div class="w-100 listPanels col-12">

                    {{-- BLOQUE FILTROS --}}
                    <form action="" method="post" class="d-flex col-9">
                        @csrf
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
                                formaction="{{ route('incident.partner.filter', $data['partner'][0]['idSocio']) }}">
                                <img src="{{ asset('media/ico/search.ico') }}" width="20px" height="20px"
                                    alt="searchICO">
                            </button>
                            <button type="reset" class="btn border">
                                <img src="{{ asset('media/ico/clean.ico') }}" width="20px" height="20px"
                                    alt="cleanICO">
                            </button>
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
                    <p>El socio no tiene incidencias!</p>
                </div>
            @else
                <table class="w-100 listTable">
                    <tr class="row mt-3 mx-3 listHead">
                        <th class="col-1">Id</th>
                        <th class="col-1">Tipo</th>
                        <th class="col-3">Info</th>
                        <th class="col-3">F.Incidencia</th>
                        <th class="col-3">Exp.Fin</th>
                        <th class="col-1"></th>
                    </tr>
                    @foreach ($data['incidents'] as $elem)
                        <tr class="row mx-3 listRow">
                            <td class="col-1">{{ $elem->idIncidencia }}</td>
                            <td class="col-1">{{ $elem->tipo }}</td>
                            <td class="col-3">{{ $elem->informacion }}</td>
                            <td class="col-3">{{ $elem->fechaInc }}</td>
                            <td class="col-3">{{ $elem->fechaFinExp }}</td>
                            <td class="col-1 p-0">
                                <div class="w-100 h-100 m-0 d-flex justify-content-between">
                                    <form class="w-100 h-100 m-0 d-flex justify-content-between"
                                        action="{{ route('incident.view', $elem->idIncidencia) }}" method="get">
                                        @csrf
                                        <button class="listFormButton">
                                            <img src="{{ asset('media/ico/view.ico') }}" alt="View user button">
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
