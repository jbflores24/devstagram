@extends('layouts.app')
@section('titulo')
    Página Principal
@endsection
@section('contenido')
    <x-listarpost :posts="$posts"/>
@endsection
