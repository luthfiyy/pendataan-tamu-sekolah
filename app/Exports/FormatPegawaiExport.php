<?php

namespace App\Exports;

use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class FormatPegawaiExport implements FromArray, WithHeadings, ShouldAutoSize, WithStyles
{
    public function array(): array
    {
        return [
            [
                '123456789',              // nip
                'John Doe',               // name
                'john.doe@example.com',   // email
                '08123456789',            // no_telp
                'produktif rpl',          // ptk
                'password123'             //password
            ],
        ];
    }

    public function headings(): array
    {
        return [
            'nip',
            'name',
            'email',
            'no_telp',
            'ptk',
            'password'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}

