<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\Pelanggan;
use App\Models\DetilPenjualan;
use App\Models\Barang;

class InvoiceController extends Controller
{
    /**
     * Cetak Invoice.
     */
    public function printInvoice($id_transaksi)
    {
        try {
            $penjualan = Penjualan::with(['pelanggan', 'detilPenjualan.barang'])->findOrFail($id_transaksi);

            $invoiceData = [
                'isPreview' => false,
                'transactionNumber' => 'INV-' . str_pad($penjualan->id_transaksi, 6, '0', STR_PAD_LEFT),
                'pelanggan' => optional($penjualan->pelanggan)->id_pelanggan ?? 'N/A',
                'nama' => optional($penjualan->pelanggan)->nama ?? 'Pelanggan tidak ditemukan',
                'gender' => optional($penjualan->pelanggan)->gender == 'L' ? 'Laki-laki' : 'Perempuan',
                'tanggal' => $penjualan->tgl_transaksi ? $penjualan->tgl_transaksi->format('d F Y') : 'Tanggal tidak tersedia',
                'waktu' => $penjualan->created_at ? $penjualan->created_at->format('H:i:s') : 'Waktu tidak tersedia',
                'totalTransaksi' => $penjualan->total_transaksi,
                'itemCount' => $penjualan->detilPenjualan->sum('jml_barang'),
                'itemsHTML' => $this->generateItemsHTML($penjualan->detilPenjualan),
            ];

            return view('form.invoice-template', $invoiceData);
        } catch (\Exception $e) {
            abort(404, 'Invoice tidak ditemukan');
        }
    }

    /**
     * Tampilkan Invoice.
     */
    public function showInvoice($id_transaksi)
    {
        $penjualan = Penjualan::with(['pelanggan', 'detilPenjualan.barang'])->findOrFail($id_transaksi);

        $invoiceData = [
            'isPreview' => false,
            'transactionNumber' => 'INV-' . str_pad($penjualan->id_transaksi, 6, '0', STR_PAD_LEFT),
            'pelanggan' => optional($penjualan->pelanggan)->id_pelanggan,
            'nama' => optional($penjualan->pelanggan)->nama ?? 'Pelanggan tidak ditemukan',
            'gender' => optional($penjualan->pelanggan)->gender == 'L' ? 'Laki-laki' : 'Perempuan',
            'tanggal' => $penjualan->tgl_transaksi ? $penjualan->tgl_transaksi->format('d/m/Y') : 'Tanggal tidak tersedia',
            'waktu' => $penjualan->created_at ? $penjualan->created_at->format('H:i:s') : 'Waktu tidak tersedia',
            'totalTransaksi' => $penjualan->total_transaksi,
            'itemCount' => $penjualan->detilPenjualan->sum('jml_barang'),
            'itemsHTML' => $this->generateItemsHTML($penjualan->detilPenjualan),
        ];

        return view('form.invoice-template', $invoiceData);
    }

    /**
     * Generate HTML untuk items invoice.
     */
    private function generateItemsHTML($items)
    {
        $html = '<table class="items-table">';
        $html .= '<thead><tr>
                    <th>Nama Barang</th>
                    <th>Qty</th>
                    <th>Harga</th>
                    <th>Subtotal</th>
                  </tr></thead><tbody>';

        foreach ($items as $item) {
            $html .= '<tr>
                        <td>' . $item->barang->nama_barang . '</td>
                        <td>' . $item->jml_barang . '</td>
                        <td>' . number_format($item->harga_satuan, 0, ',', '.') . '</td>
                        <td>' . number_format($item->jml_barang * $item->harga_satuan, 0, ',', '.') . '</td>
                      </tr>';
        }

        $html .= '</tbody></table>';
        return $html;
    }

    public function showTemplate(Request $request)
    {
        return view('form.invoice-template', [
            'isPreview' => $request->has('preview')
        ]);
    }
}
