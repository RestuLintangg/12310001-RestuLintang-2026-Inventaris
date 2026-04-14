<?php

namespace App\Exports;

use App\Models\Item;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromArray;

class ItemsExport implements FromArray
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function array() : array
    {
        $items = Item::with('category')->get();

        $data = [];
        $data[] = ['Category', 'Nama Item', 'Total', 'Total Repair', 'Last Updated'];

        foreach ($items as $item) {
            $repairValue = $item->repair == 0 ? '-' : $item->repair;
            $lastUpdated = Carbon::parse($item->updated_at)->format('M d, Y');
            $data[] = [
                $item->category->name,
                $item->name,
                $item->total,
                $repairValue,
                $lastUpdated
            ];
        }

        return $data;
    }
}
