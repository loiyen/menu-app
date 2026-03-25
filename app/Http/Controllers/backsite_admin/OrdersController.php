<?php

namespace App\Http\Controllers\backsite_admin;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use App\Models\Pembayarans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{

    public function index(Request $request)
    {

        $perPage         = $request->get('perPage', 20); 
        $pembayaran      = Pembayarans::sum('jumlah_bayar');
        $user            = Auth::user();
        $orders          = Orders::with('meja','transaction')->paginate($perPage);


        return view('backsite.order.halamanOrder', [
            'title'         => 'Order || coffe shop',
            'user'          => $user,
            'pembayaran'    => $pembayaran,
            'order'         => $orders,
        ]);
    }

    public function show($id)
    {
        $pembayaran     = Pembayarans::sum('jumlah_bayar');
        $user           = Auth::user();

        $order_detail   = Orders::with(['items.menu', 'meja', 'pembayaran'])->findOrFail($id);

        $total_item = 0;
        foreach ($order_detail->items as $item) {
            $total_item += $item->qty;
        }

        return view('backsite.order.halamanDetailOrder', [
            'title'             => 'Detail || coffe shopp',
            'order'             => $order_detail,
            'user'              => $user,
            'pembayaran'        => $pembayaran,
            'total_item'        => $total_item,

        ]);
    }

    public function searchLive(Request $request)
    {
        $keyword = $request->get('q');

        if ($keyword === '') {
            return response('');
        }

        $result = Orders::with(['items.menu', 'meja', 'pembayaran'])
            ->where('order_id', 'like', "%$keyword%")
            ->paginate(20);


        return view('backsite.partial.search_result_order', compact('result'));
    }

    public function filter_Data_by_date(Request $request)
    {
        $pembayaran     = Pembayarans::sum('jumlah_bayar');
        $user           = Auth::user();

        $dari   = $request->input('dari');
        $sampai = $request->input('sampai');
        $perPage = 20; 

        $order = Orders::when($dari && $sampai, function ($query) use ($dari, $sampai) {
            return $query->whereDate('waktu_pesan', '>=', $dari)
                ->whereDate('waktu_pesan', '<=', $sampai);
        })->paginate($perPage);

        return view('backsite.order.halamanOrder', [
            'title'         => 'Order || coffe shop',
            'user'          => $user,
            'pembayaran'    => $pembayaran,
            'order'         => $order,
        ]);
    }

}
