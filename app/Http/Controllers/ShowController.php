<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShowController extends Controller
{

    public function tentangKami ()
    {
        return view("user.tentang-kami");
    }

    public function guru()
    {
        $pegawai = Pegawai::where('ptk', '!=', 'tendik')->paginate(10);
        return view('user.pegawai-guru', compact('pegawai'));
    }

    public function tendik()
    {
        $pegawai = Pegawai::where('ptk', 'tendik')->paginate(10);
        return view('user.pegawai-tendik', compact('pegawai'));
    }


        public function kurir()
    {
        return view("user.pendaftaran-kurir");
    }


}
