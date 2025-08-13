<?php

namespace App\Http\Controllers\backsite_kasir;
use App\Models\orders;

use App\Models\pembayarans;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RiwayatKasirController extends Controller
{

    public function index(Request $request)
    {
        $user = Auth::user();
        $perPage = $request->get('perPage', 20);
        $total_transaksi = pembayarans::sum('jumlah_bayar');
        $total_tunai = pembayarans::where('metode', 'tunai')->sum('jumlah_bayar');
        $total_tf = pembayarans::where('metode', 'transfer')->sum('jumlah_bayar');

        $orders = orders::with('pembayaran')->paginate($perPage);


        return view('backsite_kasir.riwayat.halamanRiwayatKasir', [
            'title' => 'Riwayat || Kasir',
            'user' => $user,
            'total_transaksi' => $total_transaksi,
            'total_tunai' => $total_tunai,
            'total_tf' => $total_tf,
            'orders' => $orders
        ]);
    }

    public function filter_datakasir(Request $request)
    {
        $user = Auth::user();
        $perPage = 20;
        $total_transaksi = pembayarans::sum('jumlah_bayar');
        $total_tunai = pembayarans::where('metode', 'tunai')->sum('jumlah_bayar');
        $total_tf = pembayarans::where('metode', 'transfer')->sum('jumlah_bayar');


        $dari = $request->input('dari');
        $sampai = $request->input('sampai');


        $orders = orders::when($dari && $sampai, function ($query) use ($dari, $sampai) {
            return $query->whereDate('waktu_pesan', '>=', $dari)
                ->whereDate('waktu_pesan', '<=', $sampai);
        })->paginate($perPage);

        return view('backsite_kasir.riwayat.halamanRiwayatKasir', [
            'title' => 'Riwayat || Kasir',
            'user' => $user,
            'total_transaksi' => $total_transaksi,
            'total_tunai' => $total_tunai,
            'total_tf' => $total_tf,
            'orders' => $orders
        ]);
    }

    public function search_by_nama(Request $request)
    {
        $kyword = $request->input('q');

        if ($kyword === '') {
            return response('');
        }

        $result = orders::with('pembayaran')->where('order_id', 'like', "%$kyword%")
            ->paginate(20);

        return view('backsite_kasir.partial.search_resultkasir', compact('result'));

    }

}
