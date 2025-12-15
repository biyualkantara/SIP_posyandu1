<?php

namespace App\Exports;

use App\Models\KaderPosyandu;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KaderPosyanduExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return KaderPosyandu::with('duspy')->get()->map(function ($item) {
            return [
                'posyandu' => $item->duspy->nama_posyandu ?? '-',
                'nama' => $item->nama,
                'umur' => $item->umur,
                'jabatan' => $item->jabatan,
                'no_hp' => $item->no_hp,
                'alamat' => $item->alamat,
                'status' => $item->status,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nama Posyandu',
            'Nama Kader',
            'Umur',
            'Jabatan',
            'No HP',
            'Alamat',
            'Status',
        ];
    }
}
