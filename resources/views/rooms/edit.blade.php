@extends('layouts.app')
@section('title', 'Socios')
@section('head')
    <link rel="stylesheet" href="{{ asset('styles/list.css') }}">
@endsection
@section('content')

    <div class="titleBlock">
        <h2 class="mt-5 p-4">ACTUALIZAR SALA</h2>
    </div>

    <div class="d-flex align-items-center justify-content-center">
        <div class="p-3" style="width:70%">
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

            <form action="{{ route('room.update', $data[0]['idSala'] ) }}" method="POST">
                @method('put')
                @csrf
                <div class="row mb-3">
                    <div class="form-group col-3">
                        <label for="id">Id:</label>
                        <input readonly type="text" class="form-control" name="id" id="id" value="{{$data[0]['idSala']}}">
                    </div>
                    <div class="form-group col-9">
                        <label for="nombre">Nombre:</label>
                        <input type="text" class="form-control" name="nombre" id="nombre" value="{{$data[0]['nombre']}}">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="info">Información:</label>
                    <textarea class="form-control" style="height: 350px;" name="info" id="info">{{$data[0]['informacion']}}</textarea>
                </div>
                <button type="submit" class="btn btn-success mt-3">Actualizar</button>
            </form>
        </div>
    </div>

@endsection
