<?php

namespace App\Http\Controllers\backsite_admin;

use App\Models\User;
use App\Models\mejas;
use App\Models\menus;
use App\Models\order;
use App\Models\kategoris;
use App\Models\pembayarans;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class halamanDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $user_data = User::count();
        $menu = menus::count();
        $order = order::count();
        $order_item = OrderItem::count();
        $meja = mejas::count();

        //order
        $pembayaran = pembayarans::sum('jumlah_bayar');
        $total_order_rp = order::sum('total_harga');

        //kategori
        $kategori = kategoris::withCount('menu')->get();

        $pembayaran_metode_tunai  = pembayarans::where('metode','tunai')->sum('jumlah_bayar');
        $pembayaran_metode_trans  = pembayarans::where('metode','transfer')->sum('jumlah_bayar');
        
        $pembayaran_status_sukses       = pembayarans::where('status','lunas')->count();
        $pembayaran_status_menunggu     = pembayarans::where('status','menunggu')->count();
        $pembayaran_status_gagal        = pembayarans::where('status','gagal')->count();


        return view('backsite.halamanDashboar', [
            'title'                 => 'Dashboard || Coffe',
            'user'                  => $user,
            'user_data'             => $user_data,
            'menu'                  => $menu,
            'order'                 => $order,
            'order_item'            => $order_item,
            'total_order'           => $total_order_rp,
            'meja'                  => $meja,
            'pembayaran'            => $pembayaran,
            'kategori'              => $kategori,
            'pembayaran_tunai'      => $pembayaran_metode_tunai,    
            'pembayaran_trans'      => $pembayaran_metode_trans,
            'pembayaran_sukses'     => $pembayaran_status_sukses,    
            'pembayaran_menunggu'   => $pembayaran_status_menunggu,    
            'pembayaran_gagal'      => $pembayaran_status_gagal,    

        ]);
    }

    public function scan_qr($nomor_meja)
    {
        $nomor_meja = 2;

        $meja = mejas::where('nomor_meja', $nomor_meja)->first();

        if (!$meja) {
            abort(404, 'Meja tidak ditemukan');
        }

        session(['nomor_meja' => $nomor_meja, 'id' => $meja->id]);

        return redirect('/');
    }


    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/')->with('sukses', ' Anda berhasil keluar!');
    }

}
