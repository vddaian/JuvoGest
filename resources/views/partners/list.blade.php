@extends('layouts.app')
@section('title', 'Socios')
@section('head')
    <link rel="stylesheet" href="{{asset('styles/list.css')}}">
@endsection
@section('content')
    <div class="list-container h-25 align-self-end mt-5 mx-5" style="background-color:rgb(188, 255, 188)">
        <div class="position-relative" style="top:-10%;">
            Titulo
        </div>
        <div>Filtros</div>
        <div>
            <button onclick="window.location='{{ url("partner/create") }}'">+</button>
        </div>
        <table>
        </table>
    </div>
@endsection