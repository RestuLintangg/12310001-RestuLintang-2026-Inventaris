@extends('layout')

@section('content')
    @php $user = auth()->user(); @endphp

    <div class="text-center">
        <button class="btn btn-warning px-4" data-bs-target="#editUserModal{{ $user->id }}" data-bs-toggle="modal">
            <i class="fas fa-edit me-2"></i>Edit Profile
        </button>
    </div>

    {{-- modal edit --}}
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
@endsection