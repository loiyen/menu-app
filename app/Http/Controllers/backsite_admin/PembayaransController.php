<?php

namespace App\Http\Controllers\backsite_admin;

use App\Models\pembayarans;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StorepembayaransRequest;
use App\Http\Requests\UpdatepembayaransRequest;

class PembayaransController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pembayaran         = pembayarans::sum('jumlah_bayar');
        $user               = Auth::user();

        $perPage            = $request->get('perPage', 20); // default 5

        $data_pembayaran     = pembayarans::whereHas('order')->with('order')->paginate($perPage);

        return view('backsite.pembayaran.halamanPembayaran', [
            'title'                => 'Pembayaran || coffe shopp',
            'user'                 => $user,
            'pembayaran'           => $pembayaran,
            'data_pembayaran'      => $data_pembayaran,

        ]);
    }

    public function detail_pembayaran($id)
    {
        $pembayaran         = pembayarans::sum('jumlah_bayar');
        $user               = Auth::user();

        $detail_pembayaran     = pembayarans::with('order.items')->findOrFail($id);
        $order = $detail_pembayaran->order;
        $items = $order->items;

        return view('backsite.pembayaran.halamanDetailPembayaran', [
            'title'                => 'Detail Pembayaran || coffe shopp',
            'user'                 => $user,
            'pembayaran'           => $pembayaran,
            'detail'               => $detail_pembayaran,
            'item'                 => $items,
            'order'                => $order,

        ]);
    }

    public function filter_Data_by_date(Request $request)
    {
        $pembayaran     = pembayarans::sum('jumlah_bayar');
        $user           = Auth::user();

        $dari   = $request->input('dari');
        $sampai = $request->input('sampai');
        $perPage = 20;

        $data_pembayaran = pembayarans::when($dari && $sampai, function ($query) use ($dari, $sampai) {
            return $query->whereDate('waktu_bayar', '>=', $dari)
                ->whereDate('waktu_bayar', '<=', $sampai);
        })->paginate($perPage);

        return view('backsite.pembayaran.halamanPembayaran', [
            'title'                => 'Pembayaran || coffe shopp',
            'user'                 => $user,
            'pembayaran'           => $pembayaran,
            'data_pembayaran'      => $data_pembayaran,

        ]);
    }
}
