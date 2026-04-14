@extends('layout')

@section('content')
    <div class="text-center py-5">

        <h1 class="fw-bold mb-3">
            <i class="fas fa-boxes me-2 text-primary"></i>
            Sistem Inventaris Restu
        </h1>

        <p class="text-muted mb-4">
            Aplikasi manajemen peminjaman dan inventaris barang dengan mudah, cepat, dan terstruktur.
        </p>

        <div class="d-flex justify-content-center gap-3 mb-5">
            @auth
                @if(auth()->user()->role == 'admin')
                    <a href="{{ route('items.index') }}" class="btn btn-primary">
                        <i class="fas fa-box me-1"></i> Kelola Items
                    </a>
                    <a href="{{ route('categories.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-list me-1"></i> Categories
                    </a>
                @else
                    <a href="{{ route('lendings.index') }}" class="btn btn-primary">
                        <i class="fas fa-hand-holding me-1"></i> Lendings
                    </a>
                    <a href="{{ route('items.staff.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-box me-1"></i> Items
                    </a>
                @endif
            @else
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalLogin">
                    <i class="fas fa-sign-in-alt me-1"></i> Login untuk mulai
                </button>
            @endauth
        </div>

    </div>

    {{-- Feature Section --}}
    <div class="row text-center g-4">

        <div class="col-md-4">
            <div class="card p-4 h-100">
                <i class="fas fa-box-open fa-2x text-primary mb-3"></i>
                <h5>Manajemen Barang</h5>
                <p class="text-muted">Kelola semua barang inventaris dengan mudah dan terstruktur.</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-4 h-100">
                <i class="fas fa-exchange-alt fa-2x text-primary mb-3"></i>
                <h5>Peminjaman</h5>
                <p class="text-muted">Catat keluar masuk barang dengan sistem peminjaman yang rapi.</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-4 h-100">
                <i class="fas fa-chart-line fa-2x text-primary mb-3"></i>
                <h5>Laporan</h5>
                <p class="text-muted">Export data peminjaman ke Excel untuk kebutuhan laporan.</p>
            </div>
        </div>

    </div>

    {{-- Footer --}}
    <div class="text-center mt-5 text-muted small">
        © {{ date('Y') }} Inventaris Restu - All rights reserved
    </div>

@endsection