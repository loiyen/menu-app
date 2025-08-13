<?php

namespace App\Http\Controllers\backsite_admin;

use App\Models\menus;
use Intervention\Image\ImageManager;

use Intervention\Image\Drivers\Gd\Driver;

use App\Models\kategoris;
use App\Models\pembayarans;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdatemenusRequest;


class MenusController extends Controller
{

    public function index(Request $request)
    {
        $perPage        = $request->get('perPage', 20); 
        $pembayaran     = pembayarans::sum('jumlah_bayar');
        $user           = Auth::user();
        $kategori       = kategoris::all();

        $menu           = menus::with('kategori')->paginate($perPage);

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
            $image     = $request->file('gambar');
            $filename  = uniqid() . '.' . $image->getClientOriginalExtension();
            $imagePath = 'menus/' . $filename;

            // ✅ Buat ImageManager dengan driver GD secara eksplisit
            $manager = new ImageManager(new Driver());

            // Resize dan kompres
            $resizedImage = $manager->read($image)
                ->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->toJpeg(75); // Atau toPng(8) jika ingin PNG

            // Simpan ke storage
            Storage::disk('public')->put($imagePath, $resizedImage->toString());

            $path = $imagePath;
        }

        menus::create([
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

        $menu = Menus::findOrFail($id);

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
        $menu = menus::findOrFail($id);

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
            // Hapus gambar lama
            if ($menu->gambar && Storage::disk('public')->exists($menu->gambar)) {
                Storage::disk('public')->delete($menu->gambar);
            }

            $image     = $request->file('gambar');
            $filename  = uniqid() . '.' . $image->getClientOriginalExtension();
            $imagePath = 'menus/' . $filename;

            // Gunakan ImageManager dengan driver GD (v3)
            $manager = new ImageManager(new Driver());

            // Resize dan kompres
            $resizedImage = $manager->read($image)
                ->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->toJpeg(75); // toPng(8) jika gambar PNG

            // Simpan ke storage
            Storage::disk('public')->put($imagePath, $resizedImage->toString());

            // Simpan path ke DB
            $menu->gambar = $imagePath;
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

        $result = menus::where('nama', 'like', "%$keyword%")->get();

        return view('backsite.partial.search_result', compact('result'));
    }

    public function destroy($id)
    {

        $menus = menus::findOrFail($id);
        $menus->delete();

        return redirect('/menu')->with('success', 'Data dihapus!');
    }
}
