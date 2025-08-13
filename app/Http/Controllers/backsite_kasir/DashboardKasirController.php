<?php

namespace App\Http\Controllers\backsite_kasir;

use Carbon\Carbon;
use App\Models\orders;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Models\pembayarans;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Auth;

class DashboardKasirController extends Controller
{
    public function index(Request $request)
    {
        $user       = Auth::user();
        $today      = Carbon::today();
        $perPage    = $request->get('perPage', 20);

        $orderHariIni = orders::whereDate('waktu_pesan', $today)->count();
        $pembayaran = pembayarans::whereDate('waktu_bayar', $today);

        $pembayaranTunai = (clone $pembayaran)->where('metode', 'tunai')->count();
        $pembayaranTransfer = (clone $pembayaran)->where('metode', 'transfer')->count();

        $orders = orders::with('meja', 'pembayaran','items.menu')
            ->whereDate('waktu_pesan', $today)
            ->paginate($perPage);

        //sesion kasir
        $kasir = session(key: 'kasir');

        $total_perhari                  = OrderItem::whereDate('created_at', $today)->sum('qty');
        $total_perdapatanbyhari         = orders::whereDate('waktu_pesan', $today)->sum('total_harga');
        $total_pembayaranTunai          = (clone $pembayaran)->where('metode', 'tunai')->sum('jumlah_bayar');
        $total_pembayaranTf             = (clone $pembayaran)->where('metode', 'transfer')->sum('jumlah_bayar');

        return view('backsite_kasir.halamanDashboardKasir', [
            'title'                 => 'Dashboard || Kasir',
            'user'                  => $user,
            'today'                 => $today,
            'order_hari_ini'        => $orderHariIni,
            'pembayaran_tunai'      => $pembayaranTunai,
            'pembayaran_transfer'   => $pembayaranTransfer,
            'order'                 => $orders,
            'kasir'                 => $kasir,
            'total_perhari'         => $total_perhari,
            'total_pendapatanbyhari'=> $total_perdapatanbyhari,  
            'total_pembayaranTunai' => $total_pembayaranTunai,
            'total_pembayaranTf'    => $total_pembayaranTf
        ]);
    }

    public function detail_kasir($id)
    {
        $user = Auth::user();

        $order = orders::with('pembayaran', 'items.menu', 'meja')->findOrFail($id);

        $total_item = 0;
        foreach ($order->items as $item) {
            $total_item += $item->qty;
        }

        $pembayaran = pembayarans::sum('jumlah_bayar');

        return view('backsite_kasir.riwayat.halamanDetailKasir', [
            'title' => 'Detail || kasir',
            'user' => $user,
            'order' => $order,
            'total_item' => $total_item,
            'pembayaran' => $pembayaran,
        ]);
    }

    public function searchLive_kasir(Request $request)
    {
        $query = $request->get('q');
        $today = Carbon::today();

        if (empty($query)) {
            return response()->noContent();
        }

        $result = orders::with('pembayaran', 'meja', 'items')->whereDate('waktu_pesan', $today)
            ->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('order_id', 'like', '%' . $query . '%')
                    ->orWhere('nama', 'like', '%' . $query . '%');
            })->orderBy('waktu_pesan', 'desc')->limit(20)->get();



        // return view('backsite_kasir.partial.search_result', compact('result'));
        return view('backsite_kasir.partial.search_result', [
            'result' => $result // Mengubah variabel $result menjadi $results untuk konsistensi
        ]);
    }

    public function pembayaran_kasir($id)
    {
        $user = Auth::user();

        $order = orders::with('items.menu', 'pembayaran')->findOrfail($id);
        $total_item = 0;

        foreach ($order->items as $item) {
            $total_item += $item->qty;
        }

        return view('backsite_kasir.halamanPembayaranKasir', [
            'title' => 'Pembayaran || kasir',
            'user' => $user,
            'order' => $order,
            'total_item' => $total_item
        ]);
    }

    public function pembayaran_proses(Request $request, $id)
    {

        $request->validate([
            'nominal_bayar' => 'required'
        ]);

        $total_harga = (int) $request->total_harga;
        $nominal_bayar = (int) $request->nominal_bayar;

        if ($nominal_bayar < $total_harga) {
            return redirect()->route('bayar.kasir', $id)->with('error', 'Nominal bayar tidak memenuhi!.');
        }

        $kembalian = $nominal_bayar - $total_harga;

        $order = orders::findOrFail($id);
        $pembayaran = $order->pembayaran()->first();

        if ($pembayaran) {

            $pembayaran->update([
                'jumlah_bayar' => $nominal_bayar,
                'kembalian' => $kembalian,
                'status' => 'lunas',
                'waktu_bayar' => now()
            ]);
        }

        return redirect()->route('nota.kasir', $id)->with('success', 'Pembayaran berhasil!');
    }

    public function nota_pembayaran($id)
    {

        $user = Auth::user();

        $order = orders::with('pembayaran', 'items.menu')->findOrFail($id);

        return view('backsite_kasir.halamanNotaPembayaran', [
            'title' => 'Pembayaran || kasir',
            'user' => $user,
            'order' => $order
        ]);
    }

    public function print_nota_kasir($id)
    {
        $order = orders::with('pembayaran', 'meja', 'items.menu')->findOrFail($id);
        return view('backsite_kasir.partial.print_order', [
            'title' => 'Print-nota',
            'order' => $order
        ]);
    }
}
