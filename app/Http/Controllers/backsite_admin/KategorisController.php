<?php

namespace App\Http\Controllers\backsite_admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatekategorisRequest;
use App\Models\Kategoris;
use App\Models\Pembayarans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KategorisController extends Controller
{

    public function index()
    {
        $pembayaran     = Pembayarans::sum('jumlah_bayar');
        $user           = Auth::user();
        $kategori       = Kategoris::withCount('menu')->get();

        return view('backsite.kategori.halamanKategori', [
            'title'         => 'Kategori || coffe shop',
            'user'          => $user,
            'pembayaran'    => $pembayaran,
            'kategori'      => $kategori
        ]);
        
    }   


    public function create(Request $request)
    {
        $request->validate([
            'nama'          => 'required|string|max:255',
           
        ]);

        Kategoris::create([
            'nama' => $request->nama,
        ]);

        return redirect('/kategori')->with('success', 'Kategori berhasil ditambah!');
    }


    public function destroy($id)
    {
        $kategori = Kategoris::findOrFail($id);
        $kategori->delete();

        return redirect('/kategori')->with('success', 'Data dihapus!');
    }
}
