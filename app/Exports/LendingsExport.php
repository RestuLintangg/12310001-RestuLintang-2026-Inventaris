<?php

namespace App\Exports;

use App\Models\Lending;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeSheet;

class LendingsExport implements FromArray,  WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function array(): array
    {
        $lendings = Lending::with('lendingDetails')->get();

        $data = [];
        $data[] = ['no', 'Item', 'Total', 'Name', 'Ket.', 'Date', 'Return Date', 'Edited By'];

        foreach ($lendings as $index => $l) {

        $data[] = [
            $index + 1,
            $l->lendingDetails->map(function($d){
                return optional($d->item)->name;
            })->implode(', ') ?: '-',
            $l->total,
            $l->name,
            $l->ket,
            $l->created_at->format('M d, Y'),
            $l->return_date ? \Carbon\Carbon::parse($l->return_date)->format('M d, Y') : '-',
            $l->edited_by ? $l->edited_by : '-'
        ];
        }

        return $data;
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {
                $event->sheet->insertNewRowBefore(1);
                $event->sheet->setCellValue('A1', 'DATA PEMINJAMAN BARANG');
                $event->sheet->mergeCells('A1:H1');
                $event->sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
            },
        ];
    }
}
