<?php

namespace App\Http\Controllers\backsite_admin;

use App\Http\Controllers\Controller;
use App\Models\kategoris;
use App\Models\pembayarans;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\UpdatekategorisRequest;
use Illuminate\Http\Request;

class KategorisController extends Controller
{

    public function index()
    {
        $pembayaran     = pembayarans::sum('jumlah_bayar');
        $user           = Auth::user();
        $kategori       = kategoris::withCount('menu')->get();

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

        kategoris::create([
            'nama' => $request->nama,
        ]);

        return redirect('/kategori')->with('success', 'Kategori berhasil ditambah!');
    }


    public function destroy($id)
    {
        $kategori = kategoris::findOrFail($id);
        $kategori->delete();

        return redirect('/kategori')->with('success', 'Data dihapus!');
    }
}
