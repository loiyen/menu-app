<?php

namespace App\Http\Controllers\backsite_barista;

use App\Models\orders;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RiwayatPesanController extends Controller
{
    public function index(Request $request)
    {
        $perPage        = $request->get('perPage', 20);
        $user          = Auth::user();
        $order         = orders::with('meja')->paginate($perPage);

        return view('backsite_barista.riwayat.halamanRiwayat', [
            'title'     => 'Riwayat',
            'user'      => $user,
            'order'     => $order
        ]);
    }

    public function detail_order_customer($id)
    {
        $user           = Auth::user();

        $order_detail   = orders::with(['items.menu', 'meja', 'pembayaran'])->findOrFail($id);

         $total_item = 0;
        foreach ($order_detail->items as $item) {
            $total_item += $item->qty;
        }

        return view('backsite_barista.riwayat.halamanRiwayatDetail', [
            'title'         => 'Detail order || coffe shopp',
            'user'          => $user,
            'detail'        => $order_detail,
            'item'          => $total_item

        ]);
    }

    public function searchLive_barista(Request $request)
    {
        $keyword = $request->get('q');

        if ($keyword === '') {
            return response('');
        }

        $result = orders::where('order_id', 'like', "%$keyword%")->paginate(20);

        return view('backsite_barista.partial.search_result', compact('result'));
    }
}
