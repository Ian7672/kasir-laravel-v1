<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function checkPelanggan(Request $request)
    {
        $exists = Pelanggan::where('nama', $request->nama)->exists();
        return response()->json(['exists' => $exists]);
    }
}
