<?php

namespace App\Http\Controllers;

use App\Models\M_user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class controller_auth extends Controller
{
    //
    public function show()
    {
        return view('pengunjung.auth.login');
    }
    public function login(Request $request)
    {
        // Validasi data yang diterima dari form login
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string|max:50',
        ]);

        // Ambil username dan password dari request
        $username = $request->input('username');
        $password = $request->input('password');

        // Lakukan pengecekan data pada tabel tb_user
        $user = M_user::where('username', $username)->first();

        // Jika user tidak ditemukan, kembalikan response error
        if (!$user) {
            return back()->with('error', 'Username tidak ditemukan.');
        }

        // Jika otentikasi berhasil, data pengguna akan disimpan dalam session
        if (Auth::attempt(['username' => $username, 'password' => $password])) {
            // Jika otentikasi berhasil, arahkan pengguna ke halaman yang dimaksud
            // Jika pengguna memiliki peran 'admin', arahkan ke halaman dashboard
            if ($user->role === 'admin') {
                return redirect()->route('dashboard')->with('success', 'Login berhasil.');
            } else {
                // Jika tidak, arahkan ke halaman yang sesuai untuk pengguna biasa
                // return redirect()->intended('beranda');
              
            }
        } else {
            // Jika otentikasi gagal, kembalikan pengguna ke halaman login dengan pesan error
            return back()->with('error', 'Username atau password salah.');
        }
    }

}
