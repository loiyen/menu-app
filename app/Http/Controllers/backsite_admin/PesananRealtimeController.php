<?php

namespace App\Http\Controllers\backsite_admin;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class PesananRealtimeController extends Controller
{
    public function index()
    {
        $user           = Auth::user();

        return view('backsite.pesanan.pesanan-dashboard-admin', [
            'title'     => 'Pesanan',
            'user'          => $user,
        ]);
    }

    public function data(): JsonResponse
    {
        $orders = Orders::query()
            ->with(['items.menu', 'meja'])
            ->where('payment_status', 'paid')
            ->whereIn('status_order', ['proses', 'selesai'])
            ->orderByDesc('waktu_pesan')
            ->take(50)
            ->get();

        $pesananProses = Orders::where('payment_status', 'paid')
            ->where('status_order', 'proses')
            ->count();

        $pesananSelesai = Orders::where('payment_status', 'paid')
            ->where('status_order', 'selesai')
            ->count();

        $pesananHariIni = Orders::where('payment_status', 'paid')
            ->whereDate('waktu_pesan', now())
            ->count();

        $totalPaidHariIni = Orders::where('payment_status', 'paid')
            ->whereDate('waktu_pesan', now())
            ->sum('total_harga');

        return response()->json([
            'stats' => [
                'proses' => $pesananProses,
                'selesai' => $pesananSelesai,
                'hari_ini' => $pesananHariIni,
                'total_paid_hari_ini' => 'Rp' . number_format($totalPaidHariIni, 0, ',', '.'),
            ],

            'latest_id' => $orders->max('id') ?? 0,

            'orders' => $orders->map(function ($order) {
                return [
                    'id' => $order->id,

                    'invoice' => $order->nomor_pesanan ?? 'ORD-' . $order->id,

                    'meja' => $order->meja->nama
                        ?? $order->meja->nomor_meja
                        ?? $order->meja->kode_meja
                        ?? '-',

                    'customer' => $order->nama ?? 'Pelanggan',

                    'phone' => $order->phone ?? '-',

                    'email' => $order->email ?? '-',

                    // CATATAN ORDER
                    'catatan' => $order->catatan ?? null,

                    'payment_status' => $order->payment_status,

                    'status_order' => $order->status_order,

                    'total' => 'Rp' . number_format($order->total_harga ?? 0, 0, ',', '.'),

                    'created_at' => $order->waktu_pesan
                        ? \Carbon\Carbon::parse($order->waktu_pesan)->format('d M Y, H:i')
                        : '-',

                    'items' => $order->items->map(function ($item) {
                        return [
                            'name' => $item->nama_menu
                                ?? $item->menu->nama
                                ?? $item->menu->name
                                ?? 'Menu',

                            'qty' => $item->qty ?? 1,

                            'price' => 'Rp' . number_format($item->harga ?? 0, 0, ',', '.'),

                            'subtotal' => 'Rp' . number_format($item->sub_total ?? 0, 0, ',', '.'),

                            // CATATAN PER MENU
                            'catatan_menu' => $item->catatan_menu ?? null,

                            'status' => $item->status ?? null,
                        ];
                    })->values(),
                ];
            })->values(),
        ]);
    }

    public function selesai(Orders $order): JsonResponse
    {
        if ($order->payment_status !== 'PAID') {
            return response()->json([
                'message' => 'Pesanan belum paid, tidak bisa divalidasi selesai.',
            ], 422);
        }

        if ($order->status_order === 'selesai') {
            return response()->json([
                'message' => 'Pesanan sudah selesai.',
            ]);
        }

        $order->update([
            'status_order' => 'selesai',
        ]);

        return response()->json([
            'message' => 'Pesanan berhasil ditandai selesai.',
        ]);
    }
}
