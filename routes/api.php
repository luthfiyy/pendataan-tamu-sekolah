<?php

use App\Models\Tamu;
use Illuminate\Http\Request;
use Symfony\Component\Routing\Route;

Route::get('/tamu-baru', function (Request $request) {
    $tamuBaru = Tamu::where('status', 'Menunggu konfirmasi')
                     ->orderBy('created_at', 'desc')
                     ->get();
    return response()->json($tamuBaru);
});
