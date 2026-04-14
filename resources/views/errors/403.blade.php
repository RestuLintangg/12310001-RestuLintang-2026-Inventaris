@extends('layout')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="height: 80vh;">
    <div class="text-center">

        <h1 style="font-size: 80px;">403</h1>
        <h4 class="mb-3">You can't access this page</h4>

        <p class="text-muted">
            Kamu tidak memiliki akses ke halaman ini.
        </p>

        <a href="{{ url()->previous() }}" class="btn btn-primary">
            Back
        </a>

    </div>
</div>
@endsection