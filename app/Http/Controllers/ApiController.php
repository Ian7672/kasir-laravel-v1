<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Pelanggan;

class ApiController extends Controller
{
    /**
     * Ambil data Pelanggan.
     */
    public function getPelanggan(Request $request)
    {
        $pelanggan = Pelanggan::find($request->id_pelanggan);

        if ($pelanggan) {
            return response()->json([
                'nama' => $pelanggan->nama,
                'gender' => $pelanggan->gender == 'L' ? 'Laki-laki' : 'Perempuan'
            ]);
        }

        return response()->json(['error' => 'Pelanggan tidak ditemukan'], 404);
    }

    /**
     * Ambil data Barang.
     */
    public function getBarang(Request $request)
    {
        $barang = Barang::find($request->id_barang);

        if ($barang) {
            return response()->json([
                'nama_barang' => $barang->nama_barang,
                'harga_barang' => $barang->harga_barang,
                'stock' => $barang->stock,
            ]);
        }

        return response()->json(['error' => 'Barang tidak ditemukan'], 404);
    }

    /**
     * Ambil stok Barang.
     */
    public function getStockBarang(Request $request)
    {
        $barang = Barang::find($request->id_barang);

        if ($barang) {
            return response()->json([
                'stock' => $barang->stock
            ]);
        }

        return response()->json(['error' => 'Barang tidak ditemukan'], 404);
    }
}
