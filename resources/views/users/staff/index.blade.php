@extends('layout')

@section('content')
    <h1>Staff Users List</h1>
    
    <div class="d-flex justify-content-end my-3">
        <a href="{{ route('user.staff.export') }}" class="d-flex btn btn-success me-2">export excel</a>
        <button type="button" class="d-flex btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">+ Add</button>
    </div>

    <table class="table table-bordered table-striped table-hover">
        <tr class="text-center">
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Action</th>
        </tr>

        @foreach ($users as $index => $user)
        <tr class="text-center">
            <td>{{ $index + 1 }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
                <div class="d-flex justify-content-center gap-2">
                    <button class="btn btn-danger btn-sm" data-bs-target="#deleteUserModal{{ $user->id }}" data-bs-toggle="modal">
                        Delete
                    </button>

                    <button class="btn btn-info btn-sm" data-bs-target="#resetPasswordModal{{ $user->id }}" data-bs-toggle="modal">
                        Reset Password
                    </button>
                </div>
            </td>
        </tr>
        @endforeach
    </table>

    {{-- Modal Add --}}
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
                            <input type="text" class="form-control" name="name" placeholder="Masukkan Nama" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="col-form-label">Email:</label>
                            <input type="email" class="form-control" name="email" placeholder="Masukkan Email" required>
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

     {{-- modal delete --}}
     @foreach ($users as $item)
        <div class="modal fade" id="deleteUserModal{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Delete</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah anda yakin ingin menghapus user <strong>{{ $item->name }}</strong> ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <form action="{{ route('users.destroy', $item->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" >Delete</button>
                    </form>
                </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- modal reset password --}}
    @foreach ($users as $user)
        <div class="modal fade" id="resetPasswordModal{{ $user->id }}" tabindex="-1" aria-labelledby="resetPasswordModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="resetPasswordModalLabel">Reset Password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah anda yakin ingin mereset password user <strong>{{ $user->name }}</strong> ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <form action="{{ route('users.reset', $user->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-info">Reset Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

@endsection