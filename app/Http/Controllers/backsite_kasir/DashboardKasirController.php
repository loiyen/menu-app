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
        $user = Auth::user();
        $hariIni = Carbon::today();
        $perPage = $request->get('perPage', 20);

        // Validasi input perPage
        $perPage = max(1, min(100, (int)$perPage));

        // Query dasar
        $queryPesananHariIni = orders::whereDate('waktu_pesan', $hariIni);
        $queryPembayaranHariIni = pembayarans::whereDate('waktu_bayar', $hariIni);

        // Hitung jumlah
        $jumlahPesananHariIni = $queryPesananHariIni->count();
        $jumlahPembayaranTunai = (clone $queryPembayaranHariIni)->where('metode', 'tunai')->count();
        $jumlahPembayaranTransfer = (clone $queryPembayaranHariIni)->where('metode', 'transfer')->count();

        // Data pesanan dengan pagination
        $daftarPesanan = $queryPesananHariIni->with('meja', 'pembayaran', 'items.menu')
            ->paginate($perPage);

        // Hitung total
        $totalItemHariIni = OrderItem::whereDate('created_at', $hariIni)->sum('qty');
        $totalPendapatanHariIni = $queryPesananHariIni->sum('total_harga');
        $totalNominalTunai = (clone $queryPembayaranHariIni)->where('metode', 'tunai')->sum('jumlah_bayar');
        $totalNominalTransfer = (clone $queryPembayaranHariIni)->where('metode', 'transfer')->sum('jumlah_bayar');

        return view('backsite_kasir.halamanDashboardKasir', [
            'title' => 'Dashboard || Kasir',
            'user' => $user,
            'today' => $hariIni,
            'order_hari_ini' => $jumlahPesananHariIni,
            'pembayaran_tunai' => $jumlahPembayaranTunai,
            'pembayaran_transfer' => $jumlahPembayaranTransfer,
            'order' => $daftarPesanan,
            'kasir' => session('kasir'), // langsung ambil dari session
            'total_perhari' => $totalItemHariIni,
            'total_pendapatanbyhari' => $totalPendapatanHariIni,
            'total_pembayaranTunai' => $totalNominalTunai,
            'total_pembayaranTf' => $totalNominalTransfer
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
