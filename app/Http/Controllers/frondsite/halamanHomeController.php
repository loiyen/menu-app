<?php

namespace App\Http\Controllers\frondsite;

use App\Http\Controllers\Controller;
use App\Models\kategoris;
use App\Models\menus;
use Illuminate\Http\Request;

class halamanHomeController extends Controller
{

    public function index()
    {

        $kategori       = kategoris::with('menu')->get();
        $menu           = menus::orderBy('created_at', 'desc')->take(10)->get();

        $cart = session('cart', []);


        $totalHarga = 0;
        $totalItem =  0;

        foreach ($cart as $item) {
            $totalHarga += $item['harga'] * $item['qty'];
            $totalItem  += $item['qty'];
        }

        return view('frondsite.halamanBeranda', [
            'title'         => 'Kafe-one',
            'kategori'      => $kategori,
            'menu_lain'          => $menu,
            'keranjang'     => $cart,
            'total_harga'   => $totalHarga,
            'total_item'    => $totalItem

        ]);
    }

    public function detail_itemMenu($id)
    {
        $kategori = kategoris::with('menu')->get();
        $menu     = menus::with('kategori')->findOrFail($id);
        $menu2    = menus::orderBy('created_at', 'desc')->take(10)->get();

        $cart = session('cart', []);

        $totalHarga = 0;
        $totalItem =  0;

        foreach ($cart as $item) {
            $totalHarga += $item['harga'] * $item['qty'];
            $totalItem  += $item['qty'];
        }

        return view('frondsite.halamanDetailMenu', [
            'title'         => 'Detail menu',
            'kategori'      => $kategori,
            'menu'          => $menu,
            'menu_lain'     => $menu2,
            'total_harga'   => $totalHarga,
            'keranjang'     => $cart,
            'total_item'    => $totalItem


        ]);
    }


    public function add_cart(Request $request)
    {
        $request->validate([
            'id'     => 'required',
            'nama'   => 'required',
            'harga'  => 'required|numeric',
            'qty'    => 'required|integer|min:1',
        ]);

        $id  = $request->id;
        $qty = $request->qty;
        $harga = $request->harga;

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            // update qty
            $cart[$id]['qty'] += $qty;
            // update total harga untuk item ini
            $cart[$id]['total'] = $cart[$id]['qty'] * $cart[$id]['harga'];
        } else {
            $cart[$id] = [
                'id'     => $request->id,
                'nama'   => $request->nama,
                'harga'  => $harga,
                'qty'    => $qty,
                'total'  => $harga * $qty,
                'catatan' => $request->catatan
            ];
        }

        session()->put('cart', $cart);

        return redirect('/')
            ->with('success', 'Di simpan ke keranjang.');
    }


    public function delate_cartitem($id)
    {
        $cart = session('cart', []);

        $cart = collect($cart)->filter(function ($item) use ($id) {
            return $item['id'] != $id;
        })->values()->toArray();

        session(['cart' => $cart]);

        return redirect('/')->with('success', 'Menu Keranjang di hapus!');
    }

    public function delate_cart()
    {
        session()->forget('cart');

        return redirect('/')->with('success', 'Kerajang di hapus!');
    }


    //info kafe
    public function info_jam_kafe()
    {
        $cart = session('cart', []);

        $totalHarga = 0;
        $totalItem =  0;

        foreach ($cart as $item) {
            $totalHarga += $item['harga'] * $item['qty'];
            $totalItem  += $item['qty'];
        }

        return view('frondsite.halamanInfo', [
            'title'     => 'Info',
            'total_harga'   => $totalHarga,
            'keranjang'     => $cart,
            'total_item'    => $totalItem

        ]);
    }
}
