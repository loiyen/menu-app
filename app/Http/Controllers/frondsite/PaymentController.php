<?php

namespace App\Http\Controllers\frondsite;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\XenditService;
use App\Services\MidtransService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Orders;

class PaymentController extends Controller
{
    protected XenditService $xendit;


    public function __construct(XenditService $xendit)
    {
        $this->xendit = $xendit;
    }

    public function createOrder(Request $request)
    {
        $request->validate([
            'nama'      => 'required|string|max:255',
            'phone'     => 'required|string|max:255',
            'email'     => 'required|string|max:255',
            'metode'    => 'required',
        ]);

        session()->put('phone', $request->phone);

        // Hitung total dari cart
        $meja = session('id');
        $cart = session('cart', []);

        $totalHarga = 0;
        $totalItem = 0;
        $ppn = 4000;

        foreach ($cart as $item) {
            $totalHarga += $item['harga'] * $item['qty'];
            $totalItem += $item['qty'];
        }
        if (empty($meja)) {
            return redirect('/pembayaran-pesanan')->with('error', 'Data meja kosong!. Scan barcode meja');
        }

        $order = Orders::where('phone', $request->phone)->where('payment_status', 'UNPAID')->first();

        if ($order) {
            return redirect(route('riwayat.pesananuser'))->with('error', 'Anda sudah memiliki pesanan yang belum dibayar');
        }

        $order = Orders::create([
            'nomor_pesanan'       => 'ORD-' . Str::uuid(),
            'nama'                => $request->nama,
            'phone'               => $request->phone,
            'email'               => $request->email,
            'meja_id'             => $meja,
            'waktu_pesan'         => now(),
            'payment_status'      => 'UNPAID',
            'catatan'             => $request->catatan,
            'total_harga'         => $totalHarga + $ppn,
        ]);


        foreach ($cart as $item) {
            $order->items()->create([
                'menu_id'       => $item['id'],
                'nama_menu'     => $item['nama'],
                'sub_total'     => $item['harga'] * $item['qty'],
                'qty'           => $item['qty'],
                'harga'         => $item['harga'],
                'catatan_menu'  => $item['catatan'],
                'status'        => 'Proses'
            ]);
        }

        $transaction = (new XenditService())->createQrisTransaction($order);
        return redirect($transaction->invoice_url);
    }


    public function success(Request $request)
    {
        session()->forget('cart');

        return redirect(route('riwayat.pesananuser'))->with('success', 'Payment success');
    }

    public function failed(Request $request)
    {
        return redirect(route('history.order'))->with('error', 'Payment failed');
    }

    public function bayar($id)
    {
        $order = Orders::with('transaction')->findOrFail($id);

        if (!$order->transaction) {
            return back()->with('error', 'Transaksi tidak ditemukan');
        }

        if ($order->transaction->transaction_status === 'PAID') {
            return back()->with('success', 'Sudah dibayar');
        }


        return redirect($order->transaction->invoice_url);
    }
}
