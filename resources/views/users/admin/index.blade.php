@extends('layout')

@section('content')
    <h1>Admin Users Table</h1>

    <div class="d-flex justify-content-end my-3">
        <a href="{{ route('user.admin.export') }}" class="d-flex btn btn-success me-2">Export Excel</a>
        <button class="d-flex btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addUserModal">+ Add</button>
    </div>

    <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr class="text-center">
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $index => $user)
                <tr class="text-center">
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}">Edit</a>
                        <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteUserModal{{ $user->id }}">Delete</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- add modal --}}
    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Masukan Data</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-3">
                            <label class="col-form-label">Name:</label>
                            <input type="text" class="form-control" name="name" placeholder="Masukkan nama" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="col-form-label">Email:</label>
                            <input type="email" class="form-control" name="email" placeholder="Masukkan email" required>
                        </div>

                        <div class="mb-3">
                            <label class="col-form-label">Role:</label>
                            <select name="role" class="form-select" required>
                                <option selected disabled hidden>-- Pilih Role --</option>\
                                <option value="admin">Admin</option>
                                <option value="staff">Staff</option>
                            </select>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>

                </div>
            </div>
        </div>
    </form>

    {{-- update modal --}}
    @foreach ($users as $item)
        <div class="modal fade" id="editUserModal{{ $item->id }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">

                    <form action="{{ route('users.update', $item->id) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="modal-header">
                            <h5 class="modal-title">Edit User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">

                            <div class="mb-3">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" value="{{ $item->name }}" required>
                            </div>

                            <div class="mb-3">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" value="{{ $item->email }}" required>
                            </div>

                            <div class="mb-3">
                                <label>Role</label>
                                <select name="role" class="form-select" required>
                                    <option value="admin" {{ $item->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="staff" {{ $item->role == 'staff' ? 'selected' : '' }}>Staff</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label>New Password (optional)</label>
                                <input type="password" name="new_password" class="form-control">
                                <small class="text-muted">Kosongkan jika tidak ingin ganti password</small>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
     @endforeach

     {{-- delete modal --}}
    @foreach ($users as $item)
        <div class="modal fade" id="deleteUserModal{{ $item->id }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">

                    <form action="{{ route('users.destroy', $item->id) }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <div class="modal-header">
                            <h5 class="modal-title">Delete User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <p>Apakah Anda yakin ingin menghapus pengguna <strong>{{ $item->name }}</strong>?</p>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection