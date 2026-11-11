<?php

namespace App\Http\Controllers;

use App\Models\Ruang;
use App\Models\AlatMedis;
use Illuminate\Http\Request;

class RuangController extends Controller
{
    // Read: Menampilkan daftar ruang
    public function index()
    {
        $daftar = Ruang::all();
        return view('index', compact('daftar'));
    }

    // Create: Menyimpan ruang baru
    public function storeRuang(Request $request)
    {
        $request->validate([
            'nama_ruang' => 'required',
            'jenis_poli' => 'required|in:Gigi,Umum',
            'gedung' => 'required',
            'lantai' => 'required|integer|min:1',
            'kapasitas' => 'required',
        ]);

        Ruang::create($request->all());
        return redirect()->route('ruang.index')->with('success', 'Ruang berhasil ditambahkan.');
    }
    // Update: Menampilkan form edit ruang
    public function editRuang($id)
    {
        $ruang = Ruang::findOrFail($id);
        return view('ruang-edit', compact('ruang'));
    }
    // Update: Menyimpan perubahan ruang
    public function updateRuang(Request $request, $id)
    {
        $data = $request->validate([
            'nama_ruang' => 'required',
            'jenis_poli' => 'required|in:Gigi,Umum',
            'gedung' => 'required',
            'lantai' => 'required|integer|min:1',
            'kapasitas' => 'required',
        ]);

        Ruang::findOrFail($id)->update($data);
        return redirect()->route('ruang.index')->with('success', 'Ruang berhasil diubah.');
    }
    // Delete: Menghapus ruang
    public function destroyRuang($id)
    {
        Ruang::destroy($id);
        return redirect()->route('ruang.index')->with('success', 'Ruang berhasil dihapus.');
    }

    // Detail Ruang & Inventaris Alat Medis
    public function show($id)
    {
        $ruang = Ruang::with('alatMedis')->findOrFail($id);
        return view('ruang-detail', compact('ruang'));
    }

    // Create: Menambah alat medis
    public function storeAlat(Request $request, $id)
    {
        $request->validate([
            'nama_alat' => 'required',
            'jumlah' => 'required|integer|min:1',
            'kondisi' => 'required|in:Baik,Perlu Perawatan,Rusak',
            'tahun_pengadaan' => 'required|integer|min:1990|max:' . date('Y'),
        ]);

        AlatMedis::create([
            'ruang_id' => $id,
            'nama_alat' => $request->nama_alat,
            'jumlah' => $request->jumlah,
            'kondisi' => $request->kondisi,
            'tahun_pengadaan' => $request->tahun_pengadaan,
        ]);

        return redirect()->route('ruang.show', $id)->with('success', 'Alat medis berhasil ditambahkan.');
    }

    // Delete: Menghapus alat medis
    public function destroyAlat($id)
    {
        $alat = AlatMedis::findOrFail($id);
        $ruangId = $alat->ruang_id;
        $alat->delete();

        return redirect()->route('ruang.show', $ruangId)->with('success', 'Alat medis berhasil dihapus.');
    }
}