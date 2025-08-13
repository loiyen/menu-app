<?php

namespace App\Http\Controllers\backsite_admin;

use App\Models\orders;

use App\Models\pembayarans;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreordersRequest;
use App\Http\Requests\UpdateordersRequest;
use App\Models\menus;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $perPage        = $request->get('perPage', 20); // default 5

        $pembayaran     = pembayarans::sum('jumlah_bayar');
        $user           = Auth::user();
        $orders         = orders::with('meja')->paginate($perPage);


        return view('backsite.order.halamanOrder', [
            'title'         => 'Order || coffe shop',
            'user'          => $user,
            'pembayaran'    => $pembayaran,
            'order'         => $orders,
        ]);
    }

    public function show($id)
    {
        $pembayaran     = pembayarans::sum('jumlah_bayar');
        $user           = Auth::user();

        $order_detail   = orders::with(['items.menu', 'meja', 'pembayaran'])->findOrFail($id);

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

        $result = orders::with(['items.menu', 'meja', 'pembayaran'])
            ->where('order_id', 'like', "%$keyword%")
            ->paginate(20);


        return view('backsite.partial.search_result_order', compact('result'));
    }

    public function filter_Data_by_date(Request $request)
    {
        $pembayaran     = pembayarans::sum('jumlah_bayar');
        $user           = Auth::user();

        $dari   = $request->input('dari');
        $sampai = $request->input('sampai');
        $perPage = 20; 

        $order = orders::when($dari && $sampai, function ($query) use ($dari, $sampai) {
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



    public function edit(orders $orders)
    {
        //
    }


    public function update(UpdateordersRequest $request, orders $orders)
    {
        //
    }

    public function destroy(orders $orders)
    {
        //
    }
}
