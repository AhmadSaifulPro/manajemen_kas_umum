<?php

namespace App\Http\Controllers;

use App\Models\Kas;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class KasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $aktif = Kas::whereNull('deleted_at')->get();
        $terhapus = Kas::onlyTrashed()->get();
        $kategori = Kategori::all();

        return view('kas.index', compact('aktif', 'terhapus', 'kategori'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategori = Kategori::all();
        return view('kas.create', compact('kategori'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'jenis' => 'required',
            // 'tanggal' => 'required',
            'nominal' => 'required',
            'keterangan' => 'required',
            'kategori_id' => 'required',
            // 'user_id' => 'required',
        ]);

        $kategori = Kategori::where('id_kategori', $request->kategori_id)
            ->where('jenis', $request->jenis)
            ->first();

        if (!$kategori) {
            return back()
                ->withErrors(['kategori_id' => 'Kategori tidak sesuai dengan jenis yang dipilih.'])
                ->withInput();
        }

        Kas::create([
            'jenis' => $request->jenis,
            'tanggal' => now(),
            'nominal' => $request->nominal,
            'keterangan' => $request->keterangan,
            'kategori_id' => $request->kategori_id,
            'user_id' => Auth::id()
        ]);

        return redirect()->route('kas.index')->with('success', 'Kas Berhasil di Tambahkan');
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
    public function edit(string $id_kas)
    {
        $kas = Kas::findOrFail($id_kas);
        $kategori = Kategori::all();
        return view('kas.edit', compact('kas', 'kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id_kas)
    {
        $kas = Kas::findOrFail($id_kas);
        $kas->jenis = $request->jenis;

        if ($request->has('tanggal') && $request->tanggal != $kas->tanggal) {
            $kas->tanggal = $request->tanggal;
        } else {
            $kas->tanggal = now();
        }
        // $kas->tanggal = $request->tanggal;
        // $kas->tanggal = now();
        $kas->nominal = $request->nominal;
        $kas->keterangan = $request->keterangan;
        $kas->kategori_id = $request->kategori_id;
        $kas->save();

        return redirect()->route('kas.index')->with('success', 'Kas Berhasil di Ubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id_kas)
    {
        $kas = Kas::findOrFail($id_kas);
        $kas->delete();

        return redirect()->route('kas.index')->with('success', 'Kas Berhasil di Hapus');
    }

    public function restore($id_kas)
    {
        $kas = Kas::withTrashed()->findOrFail($id_kas);
        $kas->restore();

        return redirect()->route('kas.index')->with('success', 'Kas Berhasil di Pulihkan');
    }

    public function forceDelete($id_kas)
    {
        $kas = Kas::withTrashed()->findOrFail($id_kas);

        if ($kas->deleted_at === null) {
            return redirect()->route('kas.index')->with('error', 'Data belum dihapus secara sementara.');
        }

        $kas->forceDelete();

        return redirect()->route('kas.index')->with('success', 'Kategori berhasil dihapus permanen.');
    }
}
