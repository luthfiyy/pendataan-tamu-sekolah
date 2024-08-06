<?php

namespace App\Imports;

use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;

class PegawaiImport implements ToModel, WithHeadingRow
{
        /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Set password dan type default
        $defaultPassword = 'pegawai123';
        $defaultType = 'pegawai';

        // Buat atau perbarui entri pengguna
        $user = User::updateOrCreate(
            ['email' => $row['email']],
            [
                'name' => $row['name'],
                'password' => Hash::make($defaultPassword),
                'role' => $defaultType,
            ]
        );

        // Buat entri pegawai dengan menghubungkan id_user dari entri user
        return new Pegawai([
            'id_user' => $user->id,
            'nip' => $row['nip'],
            'no_telp' => $row['no_telp'],
            'ptk' => $row['ptk'],
        ]);
    }
}
