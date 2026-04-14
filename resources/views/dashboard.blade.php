@extends('layout')

@section('content')
    <h1>Selamat datang {{ Auth::user()->name }} as a {{ Auth::user()->role }}</h1>
@endsection