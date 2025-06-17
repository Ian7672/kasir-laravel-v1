<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\barang;
use App\Models\penjualan;
use App\Models\pelanggan;
use App\Models\DetilPenjualan;
use App\Models\User;

class ActionController extends Controller
{
    /**
     * Barang - menampilkan data berdasarkan role
     */
    public function barang()
    {
        $barangs = barang::all();
        $penjualans = penjualan::all();
        $pelanggans = pelanggan::all();
        $detil_penjualans = DetilPenjualan::all();

        // Ambil role user yang sedang login
        $userRole = auth()->user()->role;

        // Jika admin, kirim data users juga
        if ($userRole === 'admin') {
            $Users = User::all();
            return view('barang', compact('barangs', 'penjualans', 'pelanggans', 'detil_penjualans', 'Users', 'userRole'));
        }

        // Jika karyawan, hanya kirim data dasar
        return view('barang', compact('barangs', 'penjualans', 'pelanggans', 'detil_penjualans', 'userRole'));
    }

    /**
     * Tampilkan form untuk tambah data Barang.
     */
    public function createBarang()
    {
        return view('action.post_barang');
    }

    /**
     * Simpan data Barang.
     */
    public function storeBarang(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|min:3',
            'harga_barang' => 'required|numeric',
            'stock' => 'required|integer'
        ]);

        barang::create($request->all());

        return redirect()->route('barang')->with('success', 'Barang berhasil ditambahkan!');
    }

    // Menampilkan form edit Barang
    public function editbarang($id_barang)
    {
        $barang = barang::findOrFail($id_barang);
        return view('action.edit_barang', compact('barang'));
    }

    // Menyimpan perubahan data Barang
    public function updatebarang(Request $request, $id_barang)
    {
        $request->validate([
            'nama_barang' => 'required|min:3',
            'harga_barang' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        $barang = barang::findOrFail($id_barang);
        $barang->update($request->all());

        return redirect()->route('barang')->with('success', 'Barang berhasil diupdate!');
    }

    public function deletebarang($id_barang)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('barang')->with('error', 'Akses ditolak. Hanya admin yang dapat menghapus barang.');
        }

        $barang = barang::findOrFail($id_barang);
        $barang->delete();

        return redirect()->route('barang')->with('success', 'Barang berhasil dihapus!');
    }

    /**
     * Tampilkan form untuk tambah data Pelanggan.
     */
    public function createpelanggan()
    {
        return view('action.post_pelanggan');
    }

    /**
     * Simpan data Pelanggan.
     */
    public function storepelanggan(Request $request)
    {
        $request->validate([
            'nama' => 'required|min:3',
            'gender' => 'required|in:L,P'
        ]);

        pelanggan::create($request->all());

        return redirect()->route('pelanggan')->with('success', 'Pelanggan berhasil ditambahkan!');
    }

    public function editpelanggan($id_pelanggan)
    {
        $pelanggan = pelanggan::findOrFail($id_pelanggan);

        if (!$pelanggan) {
            return redirect()->route('barang')->with('error', 'Data pelanggan tidak ditemukan.');
        }

        return view('action.edit_pelanggan', compact('pelanggan'));
    }

    public function updatepelanggan(Request $request, $id_pelanggan)
    {
        $request->validate([
            'nama' => 'required|min:3',
            'gender' => 'required|in:Laki-laki,Perempuan',
        ]);

        $pelanggan = pelanggan::findOrFail($id_pelanggan);

        if (!$pelanggan) {
            return redirect()->route('barang')->with('error', 'Data pelanggan tidak ditemukan.');
        }

        $gender = ($request->input('gender') == 'Laki-laki') ? 'L' : 'P';

        $pelanggan->update([
            'nama' => $request->input('nama'),
            'gender' => $gender,
        ]);

        return redirect()->route('barang')->with('success', 'Pelanggan berhasil diupdate!');
    }

    public function deletepelanggan($id_pelanggan)
    {
        $pelanggan = pelanggan::findOrFail($id_pelanggan);
        $pelanggan->delete();

        return redirect()->route('barang')->with('success', 'Pelanggan berhasil dihapus!');
    }

    public function pelanggan()
    {
        $pelanggans = pelanggan::all();
        $role = auth()->user()->role;
        return view('pelanggan', compact('pelanggans', 'role'));
    }

    public function createUser()
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('barang')->with('error', 'Akses ditolak. Hanya admin yang dapat menambah user.');
        }

        return view('action.post_user');
    }

    public function storeUser(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('barang')->with('error', 'Akses ditolak. Hanya admin yang dapat menambah user.');
        }

        $request->validate([
            'username' => 'required|string|max:50|unique:user',
            'email' => 'required|email|max:100|unique:user',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,karyawan',
        ]);

        User::create([
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'role' => $request->input('role'),
        ]);

        return redirect()->route('user')->with('success', 'User berhasil ditambahkan!');
    }

    public function editUser($username)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('barang')->with('error', 'Akses ditolak. Hanya admin yang dapat mengedit user.');
        }

        $user = User::findOrFail($username);
        return view('action.edit_user', compact('user'));
    }

    public function updateUser(Request $request, $username)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('barang')->with('error', 'Akses ditolak. Hanya admin yang dapat mengupdate user.');
        }

        $request->validate([
            'username' => 'required|string|max:50|unique:user,username,' . $username . ',id_user',
            'email' => 'required|email|max:100|unique:user,email,' . $username . ',id_user',
            'password' => 'nullable|string|min:6|max:50',
            'role' => 'required|in:admin,karyawan',
        ]);

        $user = User::findOrFail($username);
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->role = $request->input('role');

        if ($request->input('password')) {
            $user->password = $request->input('password');
        }

        $user->save();

        return redirect()->route('user')->with('success', 'User berhasil diperbarui!');
    }

    public function deleteUser($username)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('barang')->with('error', 'Akses ditolak. Hanya admin yang dapat menghapus user.');
        }

        $user = User::findOrFail($username);
        $user->delete();

        return redirect()->route('barang')->with('success', 'User berhasil dihapus!');
    }

    public function user()
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('barang')->with('error', 'Akses ditolak. Hanya admin yang dapat melihat daftar user.');
        }

        $users = User::all();
        $role = auth()->user()->role;
        return view('user', compact('users', 'role'));
    }
}
