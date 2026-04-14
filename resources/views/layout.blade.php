<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventaris Restu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background: #f0f2f5;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

        a {
            color: #2563eb;
            text-decoration: none;
        }   
        
        .navbar {
            background: white;
            box-shadow: black;
            padding: 0.75rem 0;
        }
        
        .navbar-brand {
            font-weight: 600;
            color: blue;
        }
        
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: black;
            transition: all 0.2s;
        }
        
        .btn {
            border-radius: 30px;
            padding: 6px 20px;
            font-weight: 500;
            font-size: 0.875rem;
        }
        
        .btn-primary {
            background-color: #2563eb;
            border-color: #2563eb;
        }
        
        .btn-outline-primary {
            border-color: #2563eb;
            color: #2563eb;
        }
        
        .btn-outline-primary:hover {
            background-color: #2563eb;
            color: white;
        }
        
        .btn-outline-secondary {
            border-color: #6c757d;
            color: #6c757d;
        }
        
        .table {
            border-collapse: separate;
            border-spacing: 0;
        }
        
        .table thead th {
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #1e293b;
            padding: 12px 16px;
        }
        
        .table tbody td {
            padding: 12px 16px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
        }
        
        .alert {
            border: none;
            border-radius: 12px;
            padding: 12px 20px;
            margin: 5px;
        }
        
        .alert-success {
            background: #e6f7e6;
            color: #2e7d32;
        }
        
        .alert-danger {
            background: #fee2e2;
            color: #c62828;
        }
        
        .modal-content {
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 35px rgba(0,0,0,0.1);
        }
        
        .modal-header {
            border-bottom: 1px solid #eef2f6;
            background: white;
            border-radius: 20px 20px 0 0;
            padding: 20px 24px;
        }
        
        .modal-body {
            padding: 24px;
        }
        
        .modal-footer {
            border-top: 1px solid #eef2f6;
            padding: 16px 24px;
        }
        
        .form-control, .form-select {
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            padding: 8px 14px;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
        }
        
        .dropdown-menu {
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
            padding: 8px 0;
        }
        
        .dropdown-item {
            padding: 8px 20px;
            font-size: 0.875rem;
        }
        
        .dropdown-item:hover {
            background: #f8fafc;
        }
        
        .container {
            max-width: 1280px;
        }
        
        .badge-custom {
            background: #e6f0ff;
            color: #2563eb;
            padding: 4px 12px;
            border-radius: 30px;
            font-size: 0.75rem;
            font-weight: 500;
        }
    </style>
</head>

<body>
    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-boxes me-2"></i>Inventaris
            </a>
            
            @guest
                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalLogin">
                    <i class="fas fa-sign-in-alt me-1"></i>Login
                </button>
            @endguest
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                @if (auth()->check() && auth()->user()->role == 'admin')
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('categories.index') }}">
                                Categories
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('items.index') }}">
                                Items
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                User
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('users.admin.index') }}">Admin</a></li>
                                <li><a class="dropdown-item" href="{{ route('users.staff.index') }}">Staff</a></li>
                            </ul>
                        </li>
                    </ul>
                @endif

                @if (auth()->check() && auth()->user()->role == 'staff')
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('lendings.index') }}">
                                Lendings
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('items.staff.index') }}">
                                Items
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                User
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('users.staffs.index') }}">Edit Profile</a></li>
                            </ul>
                        </li>
                    </ul>
                @endif

                @auth
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge-custom">
                            <i class="fas fa-user-circle me-1"></i>{{ auth()->user()->name ?? auth()->user()->role }}
                        </span>
                        <a href="{{ route('logout') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-sign-out-alt me-1"></i>Logout
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </nav>
    

    @if(Session::get('success'))
        <div class="alert alert-success mb-3">{{ Session::get('success') }}</div>
    @endif
    
    @if ($errors->any())
        <div class="alert alert-danger mb-3">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('failed'))
        <div class="alert alert-danger mb-3">
            {{ session('failed') }}
        </div>
    @endif
    
    {{-- Form Login Modal --}}
    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="modal fade" id="modalLogin" tabindex="-1" aria-labelledby="modalLoginLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="modalLoginLabel">
                            <i class="fas fa-key me-2"></i>Login to Your Account
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="contoh@email.com" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="********" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    {{-- Main Content --}}
    <div class="container mt-4">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('script')
</body>
</html>