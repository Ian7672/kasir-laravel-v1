<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TokoSeeder extends Seeder
{
    public function run()
    {
        // Data barang
        $barangs = [
            [
                'id_barang' => 10,
                'nama_barang' => 'sabun',
                'harga_barang' => 5000,
                'stok' => 20,
            ],
            [
                'id_barang' => 11,
                'nama_barang' => 'mie goreng',
                'harga_barang' => 2500,
                'stok' => 15,
            ],
            [
                'id_barang' => 12,
                'nama_barang' => 'minyak goreng',
                'harga_barang' => 10000,
                'stok' => 5,
            ],
            [
                'id_barang' => 13,
                'nama_barang' => 'roti',
                'harga_barang' => 3000,
                'stok' => 16,
            ],
            [
                'id_barang' => 14,
                'nama_barang' => 'pasta gigi',
                'harga_barang' => 5000,
                'stok' => 6,
            ],
        ];

        // Data pelanggan
        $pelanggans = [
            [
                'id_pelanggan' => 1,
                'nama' => 'Zabil',
                'gender' => 'L',
            ],
            [
                'id_pelanggan' => 2,
                'nama' => 'Zacky',
                'gender' => 'L',
            ],
            [
                'id_pelanggan' => 3,
                'nama' => 'Zidan',
                'gender' => 'L',
            ],
            [
                'id_pelanggan' => 4,
                'nama' => 'Iqbal',
                'gender' => 'L',
            ],
            [
                'id_pelanggan' => 5,
                'nama' => 'Ega',
                'gender' => 'L',
            ],
        ];

        // Data penjualan
        $penjualans = [
            [
                'id_transaksi' => 20,
                'id_pelanggan' => 1,
                'tgl_transaksi' => '2025-01-01',
                'total_transaksi' => 10000,
            ],
            [
                'id_transaksi' => 21,
                'id_pelanggan' => 2,
                'tgl_transaksi' => '2025-01-15',
                'total_transaksi' => 2500,
            ],
            [
                'id_transaksi' => 22,
                'id_pelanggan' => 3,
                'tgl_transaksi' => '2025-01-05',
                'total_transaksi' => 5000,
            ],
            [
                'id_transaksi' => 23,
                'id_pelanggan' => 4,
                'tgl_transaksi' => '2025-01-12',
                'total_transaksi' => 6000,
            ],
            [
                'id_transaksi' => 24,
                'id_pelanggan' => 5,
                'tgl_transaksi' => '2025-01-22',
                'total_transaksi' => 5000,
            ],

        ];

        // Data detil penjualan
        $detilPenjualans = [
            [
                'id_transaksi_detil' => 30,
                'id_transaksi' => 20,
                'id_barang' => 12,
                'jml_barang' => 1,
                'harga_satuan' => 10000,
            ],
            [
                'id_transaksi_detil' => 31,
                'id_transaksi' => 21,
                'id_barang' => 11,
                'jml_barang' => 1,
                'harga_satuan' => 2500,
            ],
            [
                'id_transaksi_detil' => 32,
                'id_transaksi' => 22,
                'id_barang' => 10,
                'jml_barang' => 1,
                'harga_satuan' => 5000,
            ],
            [
                'id_transaksi_detil' => 33,
                'id_transaksi' => 23,
                'id_barang' => 13,
                'jml_barang' => 2,
                'harga_satuan' => 3000,
            ],
            [
                'id_transaksi_detil' => 34,
                'id_transaksi' => 24,
                'id_barang' => 14,
                'jml_barang' => 1,
                'harga_satuan' => 5000,
            ],
        ];

        $users = [
            [
                'id_user' => 123,
                'username' => 'Iqbal',
                'password' => '1234',
                'role' => 'admin',
            ],
            [
                'id_user' => 135,
                'username' => 'Fai',
                'password' => '12345',
                'role' => 'karyawan',
            ],
        ];

        // Insert data ke tabel
        foreach ($barangs as $barang) {
            DB::table('barang')->insert($barang);
        }

        foreach ($pelanggans as $pelanggan) {
            DB::table('pelanggan')->insert($pelanggan);
        }

        foreach ($penjualans as $penjualan) {
            DB::table('penjualan')->insert($penjualan);
        }

        foreach ($detilPenjualans as $detilPenjualan) {
            DB::table('detil_penjualan')->insert($detilPenjualan);
        }

        foreach ($users as $user) {
            DB::table('user')->insert($user);
        }
    }
}
