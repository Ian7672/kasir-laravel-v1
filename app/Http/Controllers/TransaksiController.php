<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Penjualan;
use App\Models\Pelanggan;
use App\Models\DetilPenjualan;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    /**
     * Tampilkan form untuk tambah data Penjualan.
     */
    public function form()
    {
        $pelanggans = Pelanggan::all();
        $barangs = Barang::all();
        $role = auth()->user()->role;
        return view('form.form', compact('pelanggans', 'barangs', 'role'));
    }

    /**
     * Simpan data Penjualan.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_pelanggan' => 'required|integer|exists:pelanggan,id_pelanggan',
            'tgl_transaksi' => 'required|date|date_format:Y-m-d',
            'total_transaksi' => 'required|numeric|min:0',
            'detil_penjualan' => 'required|array|min:1',
            'detil_penjualan.*.id_barang' => 'required|integer|exists:barang,id_barang',
            'detil_penjualan.*.jml_barang' => 'required|integer|min:1',
            'detil_penjualan.*.harga_satuan' => 'required|numeric|min:1',
        ]);

        DB::beginTransaction();

        try {
            $totalTransaksi = 0;
            $items = [];

            foreach ($request->detil_penjualan as $detil) {
                $barang = Barang::findOrFail($detil['id_barang']);

                if ($barang->harga_barang != $detil['harga_satuan']) {
                    throw new \Exception("Harga barang {$barang->nama_barang} tidak valid");
                }

                if ($barang->stock < $detil['jml_barang']) {
                    throw new \Exception("Stok barang '{$barang->nama_barang}' tidak mencukupi");
                }

                $subtotal = $detil['jml_barang'] * $detil['harga_satuan'];
                $totalTransaksi += $subtotal;

                $items[] = [
                    'barang' => $barang,
                    'quantity' => $detil['jml_barang'],
                    'price' => $detil['harga_satuan']
                ];
            }

            if ($totalTransaksi != $request->total_transaksi) {
                throw new \Exception("Total transaksi tidak sesuai dengan perhitungan sistem");
            }

            $penjualan = Penjualan::create([
                'id_pelanggan' => $request->id_pelanggan,
                'tgl_transaksi' => $request->tgl_transaksi,
                'total_transaksi' => $totalTransaksi,
            ]);

            foreach ($items as $item) {
                $barang = $item['barang'];
                $barang->stock -= $item['quantity'];
                $barang->save();

                $penjualan->detilPenjualan()->create([
                    'id_barang' => $barang->id_barang,
                    'jml_barang' => $item['quantity'],
                    'harga_satuan' => $item['price'],
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'id_transaksi' => $penjualan->id_transaksi,
                'message' => 'Transaksi berhasil disimpan',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Laporan Penjualan.
     */
    public function laporan(Request $request)
    {
        $tanggal_awal = $request->input('tanggal_awal');
        $tanggal_akhir = $request->input('tanggal_akhir');
        $show_all = $request->input('show_all');
        $role = auth()->user()->role;

        $query = Penjualan::with('detilPenjualan');

        if ($tanggal_awal && $tanggal_akhir) {
            $query->whereBetween('tgl_transaksi', [$tanggal_awal, $tanggal_akhir]);
        }

        $penjualans = $show_all ? $query->get() : $query->paginate(10);

        return view('laporan.laporan', compact('penjualans', 'role'));
    }

    /**
     * Cetak Laporan Penjualan.
     */
    public function cetakLaporan(Request $request)
    {
        $tanggal_awal = $request->input('tanggal_awal');
        $tanggal_akhir = $request->input('tanggal_akhir');
        $show_all = $request->input('show_all');
        $search = $request->input('search');

        $query = Penjualan::with('detilPenjualan');

        if ($tanggal_awal && $tanggal_akhir) {
            $query->whereBetween('tgl_transaksi', [$tanggal_awal, $tanggal_akhir]);
        }

        if ($search) {
            $query->where('id_transaksi', 'like', '%' . $search . '%');
        }

        $penjualans = $show_all ? $query->get() : $query->paginate(10);

        return view('laporan.cetak', compact('penjualans', 'search'));
    }
}
