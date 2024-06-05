@extends('layouts.app')
@section('title', 'Socios')
@section('head')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts/dist/apexcharts.css">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
@endsection
@section('content')

    <div class="titleBlock">
        <h2 class="mt-5 p-4">ESTADISTICAS</h2>
    </div>

    {{-- BLOQUE PRINCIPAL --}}
    <div class="d-flex align-items-center justify-content-center">

        <div class="p-3" style="width:90%; position-relative">
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

            <div class="row p-3 flex-column d-flex justify-content-center align-items-center">
                <div id="chart" style="statisticBlock">
                    {!! $charts['chartInc']->container() !!}
                </div>
            
                {!! $charts['chartInc']->script() !!}

                <div id="chart" style="statisticBlock">
                    {!! $charts['chartNew']->container() !!}
                </div>
            
                {!! $charts['chartNew']->script() !!}
            </div>
        </div>
    </div>

@endsection
