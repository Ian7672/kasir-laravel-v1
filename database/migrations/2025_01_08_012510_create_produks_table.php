<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduksTable extends Migration
{
    public function up()
    {
        // Tabel 'barang'
        if (!Schema::hasTable('barang')) {
            Schema::create('barang', function (Blueprint $table) {
                $table->increments('id_barang'); // Primary key dan auto-increment
                $table->string('nama_barang', 50); // Menggunakan 'string' untuk varchar
                $table->integer('harga_barang');
                $table->integer('stock');
                $table->timestamps(); // Tambahkan kolom created_at dan updated_at
            });
        }

        // Tabel 'pelanggan'
        if (!Schema::hasTable('pelanggan')) {
            Schema::create('pelanggan', function (Blueprint $table) {
                $table->increments('id_pelanggan'); // Primary key dan auto-increment
                $table->string('nama', 100); // Menggunakan 'string' untuk varchar
                $table->enum('gender', ['P', 'L']); // Enum dengan nilai 'P' dan 'L'
            });
        }

        // Tabel 'penjualan'
        if (!Schema::hasTable('penjualan')) {
            Schema::create('penjualan', function (Blueprint $table) {
                $table->increments('id_transaksi'); // Primary key dan auto-increment
                $table->unsignedInteger('id_pelanggan'); // Foreign key ke tabel pelanggan
                $table->date('tgl_transaksi'); // atau datetime jika perlu waktu
                $table->timestamps(); // untuk created_at dan updated_at
                $table->decimal('total_transaksi', 10, 2); // Menggunakan decimal untuk nilai uang

                // Foreign key constraint
                $table->foreign('id_pelanggan')->references('id_pelanggan')->on('pelanggan')->onDelete('cascade');
            });
        }

        // Tabel 'detil_penjualan'
        if (!Schema::hasTable('detil_penjualan')) {
            Schema::create('detil_penjualan', function (Blueprint $table) {
                $table->increments('id_transaksi_detil'); // Primary key dan auto-increment
                $table->unsignedInteger('id_transaksi'); // Foreign key ke tabel penjualan
                $table->unsignedInteger('id_barang'); // Foreign key ke tabel barang
                $table->integer('jml_barang');
                $table->decimal('harga_satuan', 10, 2); // Menggunakan decimal untuk nilai uang

                // Foreign key constraints
                $table->foreign('id_transaksi')->references('id_transaksi')->on('penjualan')->onDelete('cascade');
                $table->foreign('id_barang')->references('id_barang')->on('barang')->onDelete('cascade');
            });
        }

        // Tabel 'user'
        if (!Schema::hasTable('user')) {
            Schema::create('user', function (Blueprint $table) {
                $table->increments('id_user'); // Primary key dan auto-increment
                $table->string('username', 50); // Username
                $table->string('password'); // Password
                $table->enum('role', ['admin', 'karyawan']); // Role dengan nilai 'admin' atau 'karyawan'
            });
        }
    }

    public function down()
    {
        // Drop tabel yang telah dibuat
        Schema::dropIfExists('detil_penjualan');
        Schema::dropIfExists('penjualan');
        Schema::dropIfExists('pelanggan');
        Schema::dropIfExists('barang');
        Schema::dropIfExists('user');

        // Drop timestamps kolom jika tabel barang sudah ada
        Schema::table('barang', function (Blueprint $table) {
            $table->dropTimestamps(); // Hapus kolom created_at dan updated_at
        });
    }
}
