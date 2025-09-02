<?php

namespace App\Http\Controllers\frondsite;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class RiwayatTransController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        $totalHarga = 0;
        $totalItem = 0;

        foreach ($cart as $item) {
            $totalHarga += $item['harga'] * $item['qty'];
            $totalItem += $item['qty'];
        }
        return view('frondsite.riwayat.halamanRiwayatTrans', [
            'title'     => 'Riwayat',
            'keranjang' => $cart,
            'total_harga' => $totalHarga,
            'total_item' => $totalItem,
        ]);
    }

    public function detail_riwayat_pemesanan()
    {
        $cart = session('cart', []);
        $totalHarga = 0;
        $totalItem = 0;

        foreach ($cart as $item) {
            $totalHarga += $item['harga'] * $item['qty'];
            $totalItem += $item['qty'];
        }
        return view('frondsite.riwayat.halamanDetailRiwayat', [
            'title'     => 'Detail',
            'keranjang' => $cart,
            'total_harga' => $totalHarga,
            'total_item' => $totalItem,
        ]);
    }
}
