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
            'menu'          => $menu,
            'keranjang'     => $cart,
            'total_harga'   => $totalHarga,
            'total_item'    => $totalItem

        ]);
    }


    public function add_cart(Request $request)
    {
        $request->validate([
            'id'        => 'required',
            'nama'      => 'required',
            'harga'     => 'required',
            'qty'       => 'required|integer|min:1',
            'gambar'     => 'required'
            
        ]);

        $id     = $request->id;
        $qty    = $request->qty;

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['qty'] += $qty;
        } else {
            $cart[$id] = [
                'id'    => $request->id,
                'nama'  => $request->nama,
                'harga' => $request->harga,
                'qty'   => $request->qty,
                'gambar'=> $request->gambar
            ];
        }

        session()->put('cart', $cart);
        return redirect('/')->with('success', 'Disimpan ke keranjang belanja.');
    }

    public function delate_cartitem($id)
    {
        $cart = session('cart', []);

        $cart = collect($cart)->filter(function ($item) use ($id) {
            return $item['id'] != $id;
        })->values()->toArray();

        session(['cart' => $cart]);

        return redirect('/')->with('success', 'Cart item dihapus!');
    }

    public function delate_cart()
    {
        session()->forget('cart');

        return redirect('/')->with('success', 'Kerajang dihapus!');
    }
}
