<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Pagination\Paginator; // Add this line
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PegawaiExport;
use App\Imports\PegawaiImport;
use Illuminate\Support\Facades\Log;

// use App\Imports\PegawaiImport;

class PegawaiController extends Controller
{

    public function index(Request $request) {
        $query = Pegawai::with('user');

        $pegawai = $query->paginate(10); // Adjust the number of items per page if needed
        return view("admin.pegawai", compact("pegawai"));
    }



    // public function create()
    // {
    //     return view('admin.pegawai');
    // }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'nip' => 'required|string|max:255',
            'no_telp' => 'required|string|max:255',
            'ptk' => 'required|string|max:255',
        ]);

        // Buat user baru
        $user = User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'pegawai',
        ]);

        // Cek apakah user berhasil dibuat
        if ($user) {
            // Buat pegawai baru
            $pegawai = Pegawai::create([
                'id_user' => $user->id,
                'nip' => $request->nip,
                'no_telp' => $request->no_telp,
                'ptk' => $request->ptk,
            ]);

            // Cek apakah pegawai berhasil dibuat
            if ($pegawai) {
                return redirect()->route('admin.pegawai')->with('success', 'Pegawai berhasil ditambahkan');
            } else {
                // Log error jika pegawai tidak berhasil dibuat
                \Log::error('Gagal menambahkan pegawai', ['user_id' => $user->id]);
                return redirect()->route('pegawai.create')->with('error', 'Gagal menambahkan pegawai');
            }
        } else {
            // Log error jika user tidak berhasil dibuat
            \Log::error('Gagal menambahkan user', ['request' => $request->all()]);
            return redirect()->route('pegawai.create')->with('error', 'Gagal menambahkan user');
        }
    }


    //     // Ambil data pegawai berdasarkan ID
    //     $pegawai = Pegawai::findOrFail($id);

    //     // Render view dengan data pegawai
    //     return view('admin.edit-pegawai', compact('pegawai'));
    // }

    // public function update(Request $request, $id): RedirectResponse
    // {
    //     // Validasi input
    //     $request->validate([
    //         'nama' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255|unique:users,email,'.$id,
    //         'password' => 'nullable|string|min:8',
    //         'nip' => 'required|string|max:255',
    //         'no_telp' => 'required|string|max:255',
    //         'ptk' => 'required|string|max:255',
    //     ]);

    //     // Temukan pegawai berdasarkan ID
    //     $pegawai = Pegawai::findOrFail($id);

    //     // Update data user terkait (jika ada perubahan)
    //     $user = $pegawai->user;
    //     $user->name = $request->nama;
    //     $user->email = $request->email;
    //     if ($request->filled('password')) {
    //         $user->password = Hash::make($request->password);
    //     }
    //     $user->save();

    //     // Update data pegawai
    //     $pegawai->nip = $request->nip;
    //     $pegawai->no_telp = $request->no_telp;
    //     $pegawai->no_wa = $request->no_telp; // Anggap saja no_wa sama dengan no_telp
    //     $pegawai->ptk = $request->ptk;
    //     $pegawai->save();

    //     // Redirect ke halaman yang sesuai
    //     return redirect()->route('admin.pegawai')->with(['success' => 'Data Pegawai Berhasil Diubah!']);
    // }

    public function update(Request $request)
    {

        // dd($request->all());
        // Ambil data pegawai berdasarkan nip
        $pegawai = Pegawai::where('nip', $request->input('nipToUpdate'))->first();

        if ($pegawai) {
            // Update atribut-atribut yang sesuai dari model Pegawai
            $pegawai->nip = $request->input('newNip');
            $pegawai->no_telp = $request->input('newNo_telp');
            $pegawai->ptk = $request->input('newPtk');

            // Simpan perubahan pada pegawai
            $pegawai->save();

            // Update juga atribut user jika diperlukan
            if ($pegawai->user) {
                $pegawai->user->name = $request->input('newNama');
                $pegawai->user->email = $request->input('newEmail');
                // Pastikan untuk mengenkripsi password jika diubah
                if (!empty($request->input('newPassword'))) {
                    $pegawai->user->password = bcrypt($request->input('newPassword'));
                }
                $pegawai->user->save();
            }

            return redirect()->back()->with('message', 'Pegawai updated successfully');
        } else {
            return redirect()->back()->with('error', 'Pegawai not found');
        }
    }

    public function destroy(string $nip)
    {
        // Ambil data pegawai berdasarkan nip
        $pegawai = Pegawai::where('nip', $nip)->first();

        if ($pegawai) {
            // Hapus pengguna terkait jika ada
            if ($pegawai->user) {
                $pegawai->user->delete();
            }

            // Hapus data pegawai
            $pegawai->delete();

            return redirect()->back()->with('message', 'Pegawai berhasil dihapus beserta data pengguna terkait');
        } else {
            return redirect()->back()->with('error', 'Pegawai tidak ditemukan');
        }
    }


    public function export()
    {
        return Excel::download(new PegawaiExport, 'pegawai.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);


        try {
            Excel::import(new PegawaiImport, $request->file('file'));
            // dd($request->all());
            return redirect()->back()->with('success', 'Data pegawai berhasil diimport');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengimport data: ' . $e->getMessage());
        }
    }

}
