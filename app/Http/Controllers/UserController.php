<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\KedatanganTamu;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // Buat user baru
        $user = User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'pegawai',
        ]);

        return $user;
    }

    public function role($view)
    {
        $pegawai = User::where('role', 'pegawai')->get();
        return view($view, compact('pegawai'));
    }


    public function qr_code()
    {
        $kedatanganTamu = KedatanganTamu::where('qr_code')->get();
        return view('user.qr-code', compact('kedatanganTamu'));
    }
}
