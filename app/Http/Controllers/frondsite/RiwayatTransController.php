<?php

namespace App\Http\Controllers\frondsite;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class RiwayatTransController extends Controller
{
    public function index()
    {

        $phone = session('phone');
        
        $today = now()->timezone('Asia/Jakarta')->startOfDay();

        $orders = Order::with('transaction', 'items.menu')->where('phone', $phone)->whereDate('waktu_pesan',$today)->get();

        $cart = session('cart', []);
        
        $totalHarga = 0;
        $totalItem = 0;

        foreach ($cart as $item) {
            $totalHarga += $item['harga'] * $item['qty'];
            $totalItem += $item['qty'];
        }

        $totalItempembalian = 0;
        //mencari jumlah item
        foreach ($orders as $order) {
            foreach ($order->items as $item) {
                $totalItempembalian += $item->qty;
            }
        }

        return view('frondsite.riwayat.halamanRiwayatTrans', [
            'title'             => 'Riwayat',
            'orders'            => $orders,
            'keranjang'         => $cart,
            'total_harga'       => $totalHarga,
            'total_item'        => $totalItem,
            'total_itembeli'    => $totalItempembalian
        ]);
    }

    public function detail_riwayat_pemesanan($id)
    {
        $cart = session('cart', []);
        $totalHarga = 0;
        $totalItem = 0;

        foreach ($cart as $item) {
            $totalHarga += $item['harga'] * $item['qty'];
            $totalItem += $item['qty'];
        }

        $orders  = Order::with('items','transaction')->findOrFail($id);

        $totalItem = $orders->items->sum('qty');

        return view('frondsite.riwayat.halamanDetailRiwayat', [
            'title'         => 'Detail',
            'orders'        => $orders,
            'keranjang'     => $cart,
            'total_harga'   => $totalHarga,
            'total_item'    => $totalItem,
        ]);
    }
}
