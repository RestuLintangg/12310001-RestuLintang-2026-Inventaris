<?php

namespace App\Http\Controllers;

use App\Models\LendingDetail;
use App\Models\Lending;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LendingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $lendings = Lending::with('lendingDetails.item', 'user')->get();
        $items = Item::all();

        return view('lendings.index', compact('lendings', 'items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required',
            'items' => 'required|array',
            'totals' => 'required|array',
        ]);

        foreach ($request->items as $index => $itemId) {

            $item = Item::find($itemId);
            $total = $request->totals[$index];

            if ($total > $item->available()) {
                return back()->with('failed', 'Jumlah peminjaman melebihi stok tersedia.');
            }
        }

        $lending = Lending::create([
            'name'     => $request->name,
            'user_id'  => Auth::id(),
            'ket'      => $request->ket,
            'date'     => now(),
            'total'    => 0,
            'edited_by' => Auth::user()->name
        ]);

        $totalAll = 0;

        foreach ($request->items as $index => $itemId) {

            $total = $request->totals[$index];

            LendingDetail::create([
                'lending_id' => $lending->id,
                'item_id'    => $itemId,
                'total'      => $total,
                'edited_by'  => Auth::user()->name
            ]);

            $totalAll += $total;
        }

        $lending->update(['total' => $totalAll]);

        return back()->with('success', 'Lending Added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lending $lending)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lending $lending)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lending $lending)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $lending = Lending::find($id);

        // kalau belum return → balikin stock otomatis
        if (!$lending->return_date) {
            foreach ($lending->lendingDetails as $d) {
                // gak perlu update item karena available dihitung otomatis
            }
        }

        $lending->delete();
        return back();
    }

    public function returnItem($id)
    {
        $detail = \App\Models\LendingDetail::find($id);
        $detail->return_date = now(); // Isi tanggal sekarang
        $detail->save(); // Simpan

        return back()->with('success', 'Berhasil dikembalikan!');
    }
}

