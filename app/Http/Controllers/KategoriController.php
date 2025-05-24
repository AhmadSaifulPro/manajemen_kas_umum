<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $aktif = Kategori::whereNull('deleted_at')->get();
        $terhapus = Kategori::onlyTrashed()->get();

        return view('kategori.index', compact('aktif', 'terhapus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kategori.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required',
            'jenis' => 'required',
            'deskripsi' => 'required',
        ]);

        Kategori::create([
            'nama_kategori' => $request->nama_kategori,
            'jenis' => $request->jenis,
            'deskripsi' => $request->deskripsi,
        ]);
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id_kategori)
    {
        $kategori = Kategori::find($id_kategori);
        return view('kategori.edit', compact('kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $kategori = Kategori::find($id);
        $kategori->nama_kategori = $request->nama_kategori;
        $kategori->jenis = $request->jenis;
        $kategori->deskripsi = $request->deskripsi;
        $kategori->save();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id_kategori)
    {
        $kategori = Kategori::findOrFail($id_kategori);
        $kategori->delete();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus');
    }

    public function restore($id_kategori)
    {
        $kategori = Kategori::withTrashed()->findOrFail($id_kategori);
        $kategori->restore();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dipulihkan.');
    }

    public function forceDelete($id_kategori)
    {
        $kategori = Kategori::withTrashed()->findOrFail($id_kategori);

        if ($kategori->deleted_at === null) {
            return redirect()->route('kategori.index')->with('error', 'Data belum dihapus secara sementara.');
        }

        $kategori->forceDelete();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus permanen.');
    }
}
