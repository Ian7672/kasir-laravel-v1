<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;

class BarangController extends Controller
{
    public function checkBarang(Request $request)
    {
        $exists = Barang::where('nama_barang', $request->nama_barang)->exists();
        return response()->json(['exists' => $exists]);
    }
}
