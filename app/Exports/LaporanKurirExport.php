<?php

namespace App\Exports;

use App\Models\KedatanganEkspedisi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LaporanKurirExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return kedatanganEkspedisi::with('ekspedisi', 'user')->get();
    }

    public function headings(): array
    {
        return [
            'Nama Kurir',
            'Ekspedisi',
            'Nomor Telepon',
            'Nama Pegawai Yang Dituju',
            'Tanggal',
        ];
    }

    public function map($kedatanganEkspedisi): array
    {
        return [
            $kedatanganEkspedisi->ekspedisi->nama_kurir,
            $kedatanganEkspedisi->ekspedisi->ekspedisi,
            $kedatanganEkspedisi->ekspedisi->no_telp,
            $kedatanganEkspedisi->user->name,
            $kedatanganEkspedisi->tanggal_waktu,
        ];
    }
}
