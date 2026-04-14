@extends('layout')

@section('content')
    <h1>Lendings Table</h1>

    <div class="d-flex justify-content-end my-3">
        <a href="{{ route('lendings.export')}}" class="btn btn-success me-2">export excel</a>
        <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#modalLendingAdd">+ Add</button>
    </div>

    <table class="table table-bordered table-striped">
        <thead>
            <tr class="text-center">
                <th>#</th>
                <th>Name</th>
                <th>Items</th>
                <th>Total</th>
                <th>Ket</th>
                <th>Date</th>
                <th>Edited By</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            @foreach($lendings as $index => $lending)
            <tr>
                <td class="text-center">{{ $index+1 }}</td>
                <td>{{ $lending->name }}</td>
                <td>
                    {{-- Loop Detail Barang --}}
                    @foreach($lending->lendingDetails as $detail)
                        <div class="d-flex justify-content-between align-items-center mb-2 ">
                            <span>{{ $detail->item->name }} ({{ $detail->total }})</span>
                            
                            <div>
                                {{-- CEK return_date milik DETAIL, bukan milik LENDING --}}
                                @if($detail->return_date == null)
                                    <form action="{{ route('lendings.returnItem', $detail->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-warning btn-sm" style="font-size: 10px;">Return</button>
                                    </form>
                                @else
                                    {{-- TANGGAL MUNCUL DI SINI --}}
                                    <span class="">
                                        {{ \Carbon\Carbon::parse($detail->return_date)->format('d/m/y h:i A') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </td>
                <td class="text-center">{{ $lending->total }}</td>
                <td>{{ $lending->ket }}</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($lending->date)->format('d/m/y h:i A') }}</td>
                <td class="text-center">{{ $lending->edited_by }}</td>
                <td class="text-center">
                    <a href="#" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#lendingModal{{ $lending->id }}">Detail</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- add modal --}}
    <div class="modal fade" id="modalLendingAdd">
        <div class="modal-dialog">
            <div class="modal-content">

                <form action="{{ route('lendings.store') }}" method="POST">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title">Add Lending</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-2">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Masukkan Nama" required>
                        </div>
                        <div id="items-wrapper">
                            <div class="row mb-2 item-row">
                                <label for="items">Item</label>
                                <div class="col-6">
                                    <select name="items[]" class="form-control" required>
                                        <option disabled selected>Pilih Item</option>
                                        @foreach($items as $i)
                                            <option value="{{ $i->id }}">
                                                {{ $i->name }} ({{ $i->available() }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-4">
                                    <input type="number" name="totals[]" class="form-control" placeholder="Total" required>
                                </div>
                                <div class="col-2">
                                    <button type="button" class="btn btn-danger remove">X</button>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="add-more" class="btn btn-sm btn-secondary">+ More</button>
                        <div class="mt-2">
                            <label>Keterangan</label>
                            <textarea name="ket" class="form-control" placeholder="Keterangan"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- detail modal --}}
    @foreach ($lendings as $lending)
        <div class="modal fade" id="lendingModal{{ $lending->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Detail Peminjaman</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th width="30%">Name</th>
                                    <td>{{ $lending->name }}</td>
                                </tr>
                                <tr>
                                    <th>Total</th>
                                    <td>{{ $lending->total }}</td>
                                </tr>
                                <tr>
                                    <th>Keterangan</th>
                                    <td>{{ $lending->ket }}</td>
                                </tr>
                                <tr>
                                    <th>Date</th>
                                    <td>{{ $lending->created_at->format('M d, Y h:i A') }}</td>
                                </tr>
                                <tr>
                                    <th>Return Date</th>
                                    <td>
                                        {{ $lending->return_date 
                                            ? \Carbon\Carbon::parse($lending->return_date)->format('M d, Y h:i A')
                                            : '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Edited By</th>
                                    <td>{{ $lending->edited_by ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Item Name</th>
                                    <td> 
                                        {{ $lending->lendingDetails->map(function ($detail) {
                                            return $detail->item->name ?? '-';
                                        })->implode(', ') }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>  
    @endforeach
@endsection

@push('script')
    <script>
        document.getElementById('add-more').addEventListener('click', function () {

            let html = `
            <div class="row mb-2 item-row">
                <div class="col-6">
                    <select name="items[]" class="form-control">
                        @foreach($items as $i)
                            <option value="{{ $i->id }}">
                                {{ $i->name }} ({{ $i->available() }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-4">
                    <input type="number" name="totals[]" class="form-control" placeholder="Total">
                </div>

                <div class="col-2">
                    <button type="button" class="btn btn-danger remove">X</button>
                </div>
            </div>
            `;

            document.getElementById('items-wrapper').insertAdjacentHTML('beforeend', html);
        });

        document.addEventListener('click', function(e){
            if(e.target.classList.contains('remove')){
                e.target.closest('.item-row').remove();
            }
        });
    </script>
@endpush