<?php

namespace App\Http\Controllers\backsite_admin;

use App\Models\User;

use App\Http\Controllers\Controller;
use App\Models\Kategoris;
use App\Models\Mejas;
use App\Models\Menuses;
use App\Models\OrderItems;
use App\Models\Orders;
use App\Models\Pembayarans;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class halamanDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $user_data = User::count();
        $menu = Menuses::count();
        $order = Orders::count();
        $order_item = OrderItems::count();
        $meja = Mejas::count();

        //order
        $pembayaran = Pembayarans::sum('jumlah_bayar');
        $total_order = Orders::where('payment_status', 'paid')->sum('total_harga');

        //kategori
        $kategori = Kategoris::withCount('menu')->get();

        $total_gross_amount         = Transaction::where('payment_type','qris')->sum('gross_amount');
        $total_paid                 = Transaction::where('transaction_status','paid')->count();
        $total_expired              = Transaction::where('transaction_status','expired')->count();
        
        $pembayaran_status_sukses       = Pembayarans::where('status','lunas')->count();
        $pembayaran_status_menunggu     = Pembayarans::where('status','menunggu')->count();
        $pembayaran_status_gagal        = Pembayarans::where('status','gagal')->count();


        return view('backsite.halamanDashboar', [
            'title'                 => 'Dashboard || Coffe',
            'user'                  => $user,
            'user_data'             => $user_data,
            'menu'                  => $menu,
            'order'                 => $order,
            'order_item'            => $order_item,
            'total_order'           => $total_order,
            'meja'                  => $meja,
            'pembayaran'            => $pembayaran,
            'kategori'              => $kategori,
            'pendapatan'            => $total_gross_amount,
            'paid'                  => $total_paid,
            'expired'               => $total_expired,
            // 'pembayaran_tunai'      => $pembayaran_metode_tunai,    
            // 'pembayaran_trans'      => $pembayaran_metode_trans,
            'pembayaran_sukses'     => $pembayaran_status_sukses,    
            'pembayaran_menunggu'   => $pembayaran_status_menunggu,    
            'pembayaran_gagal'      => $pembayaran_status_gagal,    
        ]);
    }

    public function scan_qr($nomor_meja)
    {

        $meja = Mejas::where('nomor_meja', $nomor_meja)->first();

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
