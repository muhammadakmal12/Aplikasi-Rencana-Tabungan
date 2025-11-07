<?php

namespace App\Http\Controllers;

use App\Models\Saving;
use App\Models\Goal;
use Illuminate\Http\Request;

class SavingController extends Controller
{
    public function create($goal_id)
    {
        $goal = Goal::findOrFail($goal_id);
        return view('setoran', compact('goal'));
    }

    public function store(Request $request, $goal_id)
    {
        $request->validate([
            'tanggal_setor' => 'required|date',
            'jumlah_setor' => 'required|numeric|min:1',
        ]);

        $goal = Goal::findOrFail($goal_id);

        Saving::create([
            'goal_id' => $goal_id,
            'tanggal_setor' => now(),
            'jumlah_setor' => $request->jumlah_setor,
        ]);

        $total = $goal->savings()->sum('jumlah_setor');

        if ($total >= $goal->harga_barang) {
            $goal->update(['status' => 'tercapai']);
        }

        return redirect()->route('home')->with('success', 'Setoran berhasil ditambahkan!');
    }
}
