@extends('layout')

@section('content')
    <h1>Items Admin Table</h1>

    <div class="d-flex justify-content-end my-3">
        <a href="{{ route('items.export') }}" class="d-flex btn btn-success me-2">export excel</a>
        <button type="button" class="d-flex btn btn-primary" data-bs-toggle="modal" data-bs-target="#addItemModal">+ Add</button>
    </div>

    <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr class="text-center">
                <th>#</th>
                <th>Category</th>
                <th>Name</th>
                <th>Total</th>
                <th>Repair</th>
                <th>Lending</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $index => $item)
                <tr class="text-center">
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->category->name }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->total }}</td>
                    <td>{{ $item->repair }}</td>
                    <td>
                        @if($item->lendingTotal() > 0)
                            <a href="#" data-bs-toggle="modal" data-bs-target="#modalLending{{ $item->id }}">
                                {{ $item->lendingTotal() }}
                            </a>
                        @else
                            0
                        @endif
                    </td>
                    <td>
                        <button class="btn btn-warning btn-sm" data-bs-target="#updateItemModal{{ $item->id }}" data-bs-toggle="modal">Edit</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- add modal --}}
    <form action="{{ route('items.store') }}" method="POST">
        @csrf
        <div class="modal fade" id="addItemModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Masukan Data</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-3">
                            <label class="col-form-label">Name:</label>
                            <input type="text" class="form-control" name="name" placeholder="Masukkan Name" required>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label">Category:</label>
                            <select name="category_id" class="form-select" required>
                                <option value="">Pilih Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label">Total:</label>
                            <input type="number" class="form-control" name="total" placeholder="Masukkan Total" required>
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
    @foreach ($items as $item)
        <form action="{{ route('items.update', $item->id) }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="modal fade" id="updateItemModal{{ $item->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h1 class="modal-title fs-5">Edit Item</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">

                            <div class="mb-3">
                                <label class="col-form-label">Name:</label>
                                <input type="text" class="form-control" name="name" value="{{ $item->name }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="col-form-label">Category:</label>
                                <select name="category_id" class="form-select" required>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ $item->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="col-form-label">Total:</label>
                                <input type="number" class="form-control" name="total" value="{{ $item->total }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">New Broke Item (currently: {{ $item->repair }})</label>
                                <input type="number" name="new_broke_item" class="form-control" min="0">
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

    {{-- detail lending modal --}}
    @foreach($items as $item)
        <div class="modal fade" id="modalLending{{ $item->id }}">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">
                            Detail Lending - {{ $item->name }}
                        </h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        @if($item->lendingDetails->count() > 0)
                        <table class="table table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Items</th>
                                    <th>Total</th>
                                    <th>Ket</th>
                                    <th>Date</th>
                                    <th>Returned</th>
                                    <th>Edited By</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($item->lendingDetails as $detail)
                                    <tr>
                                        <td>{{ $index+1 }}</td>
                                        <td>{{ $detail->lending->name }}</td>
                                        <td>
                                            {{ $detail->item->name }} <br>
                                        </td>
                                        <td>
                                            {{ $detail->total }} <br>
                                        </td>
                                        <td>{{ $detail->lending->ket }}</td>
                                        <td>{{ \Carbon\Carbon::parse($detail->lending->date)->format('d F Y') }}</td>
                                        <td>
                                            {{ $detail->lending->return_date ? \Carbon\Carbon::parse($detail->lending->return_date)->format('d F Y') 
                                                : '-' 
                                            }}
                                        </td>
                                        <td>{{ $detail->lending->edited_by }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="text-end fw-bold">
                            Total: {{ $item->lendingTotal() }}
                        </div>

                        @else
                            <p class="text-center text-muted">Tidak ada data lending</p>
                        @endif

                    </div>

                </div>
            </div>
        </div>
    @endforeach
@endsection