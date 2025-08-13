<?php

namespace App\Http\Controllers\backsite_barista;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Models\orders;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardBaristaController extends Controller
{
    public function index(Request $request)
    {
        $user          = Auth::user();
        $today         = Carbon::today();

        $perPage       = $request->get('perPage', 20);

        $order_hari_ini         = OrderItem::whereDate('created_at', $today);

        $jumlahproses           = (clone $order_hari_ini)->where('status', 'proses')->count();
        $jumlahselesai          = (clone $order_hari_ini)->where('status', 'siap')->count();
        $order_batal            = orders::where('status', 'dibatalkan')->count();

        $order                  = orders::with('meja')->whereDate('created_at', $today)->paginate($perPage);


        return view('backsite_barista.halamanDashboard', [
            'title'             => 'Dashboar || coffe shopp',
            'user'              => $user,
            'order'             => $order,
            'item_proses'       => $jumlahproses,
            'item_selesai'      => $jumlahselesai,
            'order_batal'       => $order_batal,
            'today'             => $today
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
        

        return view('backsite_barista.halamanDetailOrder', [
            'title'         => 'Detail order || coffe shopp',
            'user'          => $user,
            'detail'        => $order_detail,
            
        ]);
    }

    public function proses(Request $request, $id)
    {
        $item = OrderItem::findOrFail($id);
        $item->status = 'siap';
        $item->save();

        return response()->json(['success' => true]);
    }

    public function selesai(Request $request, $id)
    {

        $order = orders::findOrFail($id);
        $order->status = $request->input('status', 'selesai');
        $order->save();

        return response()->json(['success' => true]);
    }

    public function searchLive_barista_today(Request $request)
    {
        $keyword = $request->get('q');

        if ($keyword === '') {
            return response('');
        }

        $today = Carbon::today();

        $result = orders::whereDate('created_at', $today)
            ->where('order_id', 'like', "%$keyword%")
            ->paginate(20);

        return view('backsite_barista.partial.search_result_today', compact('result'));
    }

    public function print_order($id)
    {
        $order = orders::with('items.menu', 'meja',)->findOrFail($id);

        return view('backsite_barista.partial.print_order', [
            'title'         => 'Print order',
            'order'         => $order
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', ' Anda berhasil keluar!');
    }
}
