<?php
namespace App\Exports;

use App\Models\Pegawai;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PegawaiExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Pegawai::with('user')->get();
    }

    public function headings(): array
    {
        return [
            'ID', 'Nama', 'Email', 'No Telepon', 'NIP', 'PTK', 'Created At', 'Updated At'
        ];
    }

    public function map($pegawai): array
    {
        return [
            $pegawai->id,
            $pegawai->user->nama,
            $pegawai->user->email,
            $pegawai->no_telp,
            $pegawai->nip,
            $pegawai->ptk,
            $pegawai->created_at,
            $pegawai->updated_at,
        ];
    }
}
