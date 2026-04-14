@extends('layout')

@section('content')
    <h1>Items Staff Table</h1>

    <div class="my-3">
        <table class="table table-bordered table-striped">
            <thead>
                <tr class="text-center">
                    <th>#</th>
                    <th>Category</th>
                    <th>Name</th>
                    <th>Total</th>
                    <th>Lending</th>
                    <th>Available</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($items as $index =>$item)
                <tr class="text-center">
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->category->name }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->total }}</td>
                    <td>{{ $item->lendingTotal() }}</td>
                    <td>{{ $item->available() }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection