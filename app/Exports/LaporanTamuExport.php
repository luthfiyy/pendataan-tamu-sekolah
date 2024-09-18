<?php
namespace App\Exports;

use App\Models\KedatanganTamu;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LaporanTamuExport implements FromCollection, WithHeadings, WithMapping

{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return KedatanganTamu::with('tamu', 'user')->get();

    }

    public function headings(): array
    {
        return [
            'Nama Tamu',
            'Alamat',
            'Email',
            'No Telepon',
            'Nama Pegawai Yang Dituju',
            'Tujuan',
            'Instansi',
            'Waktu Perjanjian',
            'Waktu Kedatangan'
        ];
    }

    public function map($kedatanganTamu): array
    {
        return [
            $kedatanganTamu->tamu->nama,
            $kedatanganTamu->tamu->alamat,
            $kedatanganTamu->tamu->email,
            $kedatanganTamu->tamu->no_telp,
            $kedatanganTamu->user->name,
            $kedatanganTamu->tujuan,
            $kedatanganTamu->instansi,
            $kedatanganTamu->waktu_perjanjian,
            $kedatanganTamu->waktu_kedatangan,
        ];
    }

}
