@extends('layout')

@section('content')
    <h1>Categories Table</h1>

    <div class="d-flex justify-content-end my-3">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
            + Add
        </button>
    </div>

    <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr class="text-center">
                <th>#</th>
                <th>Nama</th>
                <th>Division PJ</th>
                <th>Total Item</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $index => $item)
                <tr class="text-center">
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->division }}</td>
                    <td>{{ $item->items_count }}</td>
                    <td>
                        <button 
                            type="button" 
                            class="btn btn-warning btn-sm" 
                            data-bs-toggle="modal" 
                            data-bs-target="#updateCategoryModal-{{ $item->id }}">
                            Edit
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- create modal --}}
    <form action="{{ route('categories.store') }}" method="POST">
    @csrf
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Tambah Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="col-form-label">Name :</label>
                        <input type="text" class="form-control" name="name" placeholder="Masukkan Name" required>
                    </div>
                    <div class="mb-3">
                        <label class="col-form-label">Division PJ :</label>
                        <select name="division" class="form-select" required>
                            <option value="" selected disabled>-- Pilih Division --</option>
                            <option value="Sarpras">Sarpras</option>
                            <option value="Tata Usaha">Tata Usaha</option>
                            <option value="Tefa">Tefa</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>

            </div>
        </div>
    </div>
    </form>

    {{-- update modal --}}
    @foreach ($categories as $item)
        <form action="{{ route('categories.update', $item->id) }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="modal fade" id="updateCategoryModal-{{ $item->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title">Update Category</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="col-form-label">Name :</label>
                                <input type="text" class="form-control" name="name" value="{{ $item->name }}" placeholder="Masukkan Name" required>
                            </div>
                            <div class="mb-3">
                                <label class="col-form-label">Division PJ :</label>
                                <select name="division" class="form-select" required>
                                    <option value="" selected disabled>-- Pilih Division --</option>
                                    <option value="Sarpras" {{ $item->division === 'Sarpras' ? 'selected' : '' }}>Sarpras</option>
                                    <option value="Tata Usaha" {{ $item->division === 'Tata Usaha' ? 'selected' : '' }}>Tata Usaha</option>
                                    <option value="Tefa" {{ $item->division === 'Tefa' ? 'selected' : '' }}>Tefa</option>
                                </select>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>

                    </div>
                </div>
            </div>
        </form>
    @endforeach

@endsection