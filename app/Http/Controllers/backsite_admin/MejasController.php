<?php

namespace App\Http\Controllers\backsite_admin;
use App\Http\Controllers\Controller;

use App\Models\mejas;
use App\Models\pembayarans;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoremejasRequest;
use App\Http\Requests\UpdatemejasRequest;
use Illuminate\Http\Request;

class MejasController extends Controller
{
    
    public function index()
    {
        $pembayaran     = pembayarans::sum('jumlah_bayar');
        $user           = Auth::user();

        $meja           = mejas::all();

        return view('backsite.meja.halamanMeja', [
            'title'         => 'Meja || coffe shopp',
            'user'          => $user,
            'pembayaran'    => $pembayaran,
            'meja'          => $meja

        ]);

    }

    public function create(Request $request)
    {
        $validate = $request->validate([
            'nomor'       => 'required',
            'lokasi'           => 'required',
        ]);

        mejas::create([
            'nomor_meja'        => $validate['nomor'],
            'lokasi'            => $validate['lokasi'],
        ]);

        return redirect('/meja')->with('success', 'Meja berhasil ditambah!');
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatemejasRequest $request, mejas $mejas)
    {
        
    }

    
    public function destroy($id)
    {
        $meja   = mejas::findOrFail($id);
        $meja->delete();

        return redirect('/meja')->with('success', 'Data berhasil dihapus!');
    }
}
