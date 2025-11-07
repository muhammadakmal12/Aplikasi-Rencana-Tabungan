<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Goal;

class MainController extends Controller
{
    public function home(Request $request)
    {
        $status = $request->query('status');
        $search = $request->query('search');
        $query = Goal::with('savings')->where('user_id', auth()->id());

        if ($status) {
            if (in_array($status, ['tercapai', 'belum tercapai'])) {
                $query->where('status', $status);
            }
        }

        if ($search) {
            $query->where('nama_barang', 'like', '%' . $search . '%');
        }

        $goals = $query->get()->map(function($goal) {
        $goal->total_savings = $goal->savings->sum('jumlah_setor');
        $goal->status_tabungan = $goal->total_savings >= $goal->harga_barang ? 'tercapai' : 'belum tercapai';
        return $goal;
    });
        return view('home', compact('goals', 'status'));
    }

    public function tabungan(Request $request)
    {
        $status = $request->query('status');
        $query = Goal::with('savings')->where('user_id', auth()->id());

        if ($status) {
            if (in_array($status, ['tercapai', 'belum tercapai'])) {
                $query->where('status', $status);
            }
        }

        $goals = $query->get()->map(function($goal) {
        $goal->total_savings = $goal->savings->sum('jumlah_setor');
        $goal->status_tabungan = $goal->total_savings >= $goal->harga_barang ? 'tercapai' : 'belum tercapai';
        return $goal;
    });
        return view('tabungan', compact('goals', 'status'));
    }

    public function tmbh()
    {
        return view('tambah');
    }

    public function store(Request $request)
    {
        $request->validate([
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'nama_barang' => 'required|string|max:100',
            'harga_barang' => 'required|numeric|min:1',
            'target_tanggal' => 'required|date',
        ]);

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/goals'), $filename);
        } else {
            $filename = null;
            }

        Goal::create([
            'user_id' => auth()->id(),
            'gambar' => 'uploads/goals/' . $filename,
            'nama_barang' => $request->nama_barang,
            'harga_barang' => $request->harga_barang,
            'target_tanggal' => $request->target_tanggal,
            'status' => 'belum tercapai',
        ]);

        return redirect()->route('goals.index')->with('success', 'Tujuan tabungan berhasil ditambahkan!');
    }

    public function edt($id)
    {
        $goal = Goal::findOrFail($id);
        return view('edit', compact('goal'));
    }

    public function upd(Request $request, $id)
    {
        $request->validate([
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'nama_barang' => 'required|string|max:100',
            'harga_barang' => 'required|numeric|min:1',
            'target_tanggal' => 'required|date',
        ]);

        $goal = Goal::findOrFail($id);

        if ($request->hasFile('gambar')) {
        $file = $request->file('gambar');
        $filename = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('uploads/goals'), $filename);

        // hapus file lama jika ada
        if ($goal->gambar && file_exists(public_path($goal->gambar))) {
            unlink(public_path($goal->gambar));
        }

        $goal->gambar = 'uploads/goals/'.$filename;
    }

    $goal->nama_barang = $request->nama_barang;
    $goal->harga_barang = $request->harga_barang;
    $goal->target_tanggal = $request->target_tanggal;

    $goal->save();

        return redirect()->route('goals.index')->with('success', 'Tujuan tabungan berhasil diperbarui!');
    }

    public function hps($id)
    {
        $goal = Goal::findOrFail($id);
        $goal->delete();

        return redirect()->route('goals.index')->with('success', 'Tujuan tabungan berhasil dihapus!');
    }

}
