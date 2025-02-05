<?php

namespace App\Http\Controllers;

use App\Models\M_kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class controller_kategori extends Controller
{
    //
    //
    public function show()
    {
        $user = Auth::user();
        $title = 'Kelola kategori';
        $categorys = M_kategori::paginate(5);
        return view('admin.kategori.index', compact('categorys', 'user', 'title'));
    }
    // create 
    public function create(Request $request)
    {
        $request->validate([
            'kategori' => 'required|string|max:225',
            'deskripsi' => 'required|string|max:225',
        ]);
        $kategori = new M_kategori();
        $kategori->kategori = $request->kategori;
        $kategori->deskripsi = $request->deskripsi;
        $kategori->save();
        return redirect()->route('kelola_kategori')->with('success', 'Kategori ' . $request->kategori .  ' telah ditambahkan');
    }

    // update
    public function edit($id)
    {
        $title = 'Kelola Kategori';
        $kategori = M_kategori::findOrFail($id);
       
        return view('admin.kategori.edit', compact('title', 'kategori'));
    }
    public function update($id, Request $request)
    {
        $validatedData = $request->validate([
            'kategori' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:255',

        ]);
        $deskripsi = M_kategori::where('id_kategori', $id)->firstOrFail();
        $deskripsi->kategori = $request->kategori;
        $deskripsi->deskripsi = $request->deskripsi;
        $deskripsi->save();
        return redirect()->route('kelola_kategori')->with('success', 'Data kategori berhasil diperbarui.');
    }
    // delete
    public function delete($id)
    {
        // Temukan buku berdasarkan ID
        $buku = M_kategori::findOrFail($id);
        // Hapus buku
        $buku->delete();

        // Simpan pesan berhasil ke dalam session
        return redirect()->back()->with('success', 'Kategori telah dihapus');
    }
}
