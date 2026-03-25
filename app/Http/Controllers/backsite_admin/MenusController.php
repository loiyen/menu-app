<?php

namespace App\Http\Controllers\backsite_admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatemenusRequest;
use App\Models\Kategoris;
use App\Models\Menuses;
use App\Models\Pembayarans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;


class MenusController extends Controller
{

    public function index(Request $request)
    {
        $perPage        = $request->get('perPage', 20);
        $pembayaran     = Pembayarans::sum('jumlah_bayar');
        $user           = Auth::user();
        $kategori       = Kategoris::all();

        $menu           = Menuses::with('kategori')->paginate($perPage);

        return view('backsite.menu.halamanMenu', [
            'title'         => 'Menu || coffe shopp',
            'user'          => $user,
            'pembayaran'    => $pembayaran,
            'menu'          => $menu,
            'kategori'      => $kategori,

        ]);
    }


    public function create(Request $request)
    {
        $validate = $request->validate([
            'nama'     => 'required',
            'kategori' => 'required',
            'harga'    => 'required|numeric',
            'stok'     => 'required|numeric',
            'gambar'   => 'required|image|mimes:jpg,jpeg,png|max:5048'
        ]);

        $path = null;

        if ($request->hasFile('gambar')) {
            $ext = $request->file('gambar')->getClientOriginalExtension();
            $filename = uniqid() . '.' . $ext;
            $path = $request->file('gambar')->storeAs('menus', $filename, 'public');
        }


        Menuses::create([
            'nama'        => $validate['nama'],
            'kategori_id' => $validate['kategori'],
            'harga'       => $validate['harga'],
            'stok'        => $validate['stok'],
            'gambar'      => $path
        ]);

        return redirect('/menu')->with('success', 'Menu berhasil ditambah!');
    }


    public function edit($id)
    {
        $pembayaran     = pembayarans::sum('jumlah_bayar');
        $user           = Auth::user();
        $kategori       = kategoris::all();

        $menu = Menuses::findOrFail($id);

        return view('backsite.menu.halamanEdit', [
            'title'         => 'Edit || coffe shop',
            'menu'          => $menu,
            'user'          => $user,
            'kategori'      => $kategori,
            'pembayaran'    => $pembayaran

        ]);
    }


    public function update(Request $request, $id)
    {
        $menu = Menuses::findOrFail($id);

        $validate = $request->validate([
            'nama'     => 'required',
            'kategori' => 'required',
            'harga'    => 'required|numeric',
            'stok'     => 'required|numeric',
            'gambar'   => 'nullable|image|mimes:jpg,jpeg,png|max:5048'
        ]);

        // Update data biasa
        $menu->nama        = $validate['nama'];
        $menu->kategori_id = $validate['kategori'];
        $menu->harga       = $validate['harga'];
        $menu->stok        = $validate['stok'];

        // Jika ada upload gambar baru
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama kalau ada
            if ($menu->gambar && Storage::disk('public')->exists($menu->gambar)) {
                Storage::disk('public')->delete($menu->gambar);
            }

            // Simpan gambar baru
            $path = $request->file('gambar')->storeAs(
                'menus',
                uniqid() . '.' . $request->file('gambar')->getClientOriginalExtension(),
                'public'
            );


            // Update path di database
            $menu->gambar = $path;
        }

        $menu->save();

        return redirect('/menu')->with('success', 'Data berhasil diubah!');
    }


    public function searchLive_ds(Request $request)
    {
        $keyword = $request->get('q');

        if ($keyword === '') {
            return response('');
        }

        $result = Menuses::where('nama', 'like', "%$keyword%")->get();

        return view('backsite.partial.search_result', compact('result'));
    }

    public function destroy($id)
    {

        $menus = Menuses::findOrFail($id);
        $menus->delete();

        return redirect('/menu')->with('success', 'Data dihapus!');
    }
}
