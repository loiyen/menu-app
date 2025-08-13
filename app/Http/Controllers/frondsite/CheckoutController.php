<?php

namespace App\Http\Controllers\frondsite;

use Midtrans\Snap;


use Midtrans\Config;
use App\Models\kategoris;
use Midtrans\Notification;
use Illuminate\Http\Request;
use App\Services\MidtransService;
use App\Http\Controllers\Controller;
use App\Models\orders;
use Illuminate\Validation\Rules\Unique;

class CheckoutController extends Controller
{

    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.sanitized');
        Config::$is3ds = config('midtrans.3ds');
    }

    public function index()
    {

        $kategori = kategoris::with('menu')->get();

        $cart = session('cart', []);


        if (count($cart) == 0) {
            return redirect('/')->with('error', 'Silakan pilih menu terlebih dahulu!');
        }

        $totalHarga = 0;
        $totalItem = 0;

        foreach ($cart as $item) {
            $totalHarga += $item['harga'] * $item['qty'];
            $totalItem += $item['qty'];
        }

        if ($totalHarga < 100) {
            return response()->json([
                'message' => 'Total pembayaran tidak boleh kurang dari Rp100.',
            ], 400);
        }

        return view('frondsite.halamanCheckout', [
            'title' => 'Checkout',
            'tampilkan_alert' => true,
            'kategori' => $kategori,
            'keranjang' => $cart,
            'total_harga' => $totalHarga,
            'total_item' => $totalItem,

        ]);
    }

    public function show_snap(MidtransService $midtrans, Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'opsi_gula' => 'required',

        ]);

        $cart = session('cart', []);

        $totalHarga = 0;
        $totalItem = 0;

        foreach ($cart as $item) {
            $totalHarga += $item['harga'] * $item['qty'];
            $totalItem += $item['qty'];
        }

        $params = [
            'transaction_details' => [
                'order_id' => 'ORD-' . uniqid(),
                'gross_amount' => $totalHarga,
            ],
            'customer_details' => [
                'first_name' => $request->nama,
                'last_name' => $request->nama,
                'email' => 'guest@example.com',
                'phone' => '08123456789',
            ],
            'enabled_payments' => [ // Opsional: batasi metode pembayaran
                'credit_card',
                'gopay',
                'shopeepay',

            ],
        ];

        try {
            $snapToken = $midtrans->createSnapToken($params);
            ;

            // Simpan data transaksi sementara di session
            session()->flash('pending_order', [
                'order_id' => $params['transaction_details']['order_id'],
                'nama' => $request->nama,
                'total' => $totalHarga,
                'opsi_gula' => $request->opsi_gula,
                'snap_token' => $snapToken
            ]);

            return response()->json([
                'status' => 'success',
                'snap_token' => $snapToken,
                'order_id' => $params['transaction_details']['order_id']
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal memproses pembayaran: ' . $e->getMessage()
            ], 500);
        }
    }
    public function proses(MidtransService $midtransService, Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'opsi_gula' => 'required|in:Normal,Less,Tanpa Gula',
            'metode' => 'required|in:tunai,midtrans',
            'catatan' => 'nullable|string'
        ]);

        // Hitung total dari cart
        $cart = session('cart', []);
        $totalHarga = 0;
        $totalItem = 0;

        foreach ($cart as $item) {
            $totalHarga += $item['harga'] * $item['qty'];
            $totalItem += $item['qty'];
        }

        //untuk midtrans
        $itemDetails = [];
        foreach ($cart as $id => $item) {
            $itemDetails[] = [
                'id' => $id,
                'name' => $item['nama'],
                'price' => $item['harga'],
                'quantity' => $item['qty'],

            ];
        }

        //simpan kedatabase order
        $order = orders::create([
            'order_id' => 'ORD-' . uniqid(),
            'nama' => $request->nama,
            'meja_id' => 1,
            'waktu_pesan' => now(),
            'status' => 'pending',
            'payment_status' => 'unpaid',
            'opsi' => $request->opsi_gula,
            'catatan' => $request->catatan,
            'total_harga' => $totalHarga
        ]);

        //simpan ke orders item
        foreach ($cart as $item) {
            $order->items()->create([
                'order_id' => $order->id,
                'menu_id' => $item['id'],
                'nama_menu' => $item['nama'],
                'sub_total' => $totalHarga,
                'qty' => $item['qty'],
                'status' => 'Proses'

            ]);
        }

        // Jika metode midtrans, generate snap token
        if ($request->metode === 'midtrans') {
            try {
                $params = [
                    'transaction_details' => [
                        'order_id' => $order->id,
                        'gross_amount' => $totalHarga,
                    ],
                    'customer_details' => [
                        'first_name' => $request->nama,
                        'email' => 'guest@example.com',
                        'phone' => '08123456789',
                    ],
                    'item_details' => $itemDetails,
                    'enabled_payments' => [
                        'gopay',
                        'shopeepay',
                        'bank_transfer', 
                        'bca_va', 
                        'bni_va', 
                        'bri_va',
                    ],
                ];

                $snapToken = $midtransService->getSnapToken($params);

                // Update order dengan data midtrans
                $order->update([
                    'midtrans_order_id' => $order->id,
                    'midtrans_response' => json_encode(['snap_token' => $snapToken])
                ]);

                return response()->json([
                    'status' => 'success',
                    'snap_token' => $snapToken,
                    'order_id' => $order->id
                ]);

            } catch (\Exception $e) {
                $order->update(['payment_status' => 'failed']);

                return response()->json([
                    'status' => 'error',
                    'message' => 'Gagal memproses pembayaran: ' . $e->getMessage()
                ], 500);
            }
        }

        // Jika metode tunai
        return response()->json([
            'status' => 'success',
            'order_id' => $order->id,
            'message' => 'Order berhasil dibuat. Silakan bayar di kasir.'
        ]);
    }

    public function update_qty(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'qty' => 'required|integer|min:1'
        ]);

        $cart = session('cart', []);

        $index = collect($cart)->search(fn($item) => $item['id'] == $request->id);

        if ($index !== false) {
            $cart[$index]['qty'] = $request->qty;
            session(['cart' => $cart]);
            return redirect('/checkout')->with('success', 'Qty berhasil ditambahkan!');
        }
    }

    // public function proses(Request $request)
    // {
    //     $request->validate([
    //         'nama'          => 'required',
    //         'catatan'       => 'nullable|string',
    //         'opsi_gula'     => 'nullable|string',
    //         'result_data'   => 'nullable|string',
    //         'metode'        => 'required|in:tunai,midtrans'
    //     ]);

    //     // dd($request);

    //     $cart = session('cart', []);
    //     $totalHarga = 0;
    //     $totalItem =  0;

    //     foreach ($cart as $item) {
    //         $totalHarga += $item['harga'] * $item['qty'];
    //         $totalItem  += $item['qty'];
    //     }

    //     $order = orders::create([
    //         'order_id'      => 'ORD-' . uniqid(),
    //         'nama'          => $request->nama,
    //         'meja_id'       => 1,
    //         'waktu_pesan'   => now(),
    //         'status'        => 'menunggu',
    //         'opsi'          => $request->opsi_gula,
    //         'catatan'       => $request->catatan,
    //         'total_harga'   => $totalHarga
    //     ]);

    //     foreach ($cart as $item) {
    //         $order->items()->create([
    //             'order_id'      => $order->id,
    //             'menu_id'       => $item['id'],
    //             'nama_menu'     => $item['nama'],
    //             'sub_total'     => $item['harga'] * $item['qty'],
    //             'qty'           => $item['qty'],
    //             'status'        => 'Proses'

    //         ]);
    //     }

    //     if ($request->metode == 'tunai') {
    //         $order->pembayaran()->create([
    //             'orders_id'         => $order->id,
    //             'metode'            => 'tunai',
    //             'jumlah_bayar'      =>  null,
    //             'status'            => 'menunggu',
    //             'waktu_bayar'       =>  now()
    //         ]);

    //         session()->forget('cart');

    //         return redirect()->route('detail.pemesananuser', $order->order_id)->with('success', 'Segera melakukan pembayaran dikasir!');
    //     }

    //     $order->pembayaran()->create([
    //         'orders_id'      => $order->id,
    //         'metode'        => 'transfer',
    //         'jumlah_bayar'  => $totalHarga,
    //         'status'        => 'lunas',
    //         'waktu_bayar'   => now()
    //     ]);

    // }

    public function get_pesanan_detail($Id)
    {
        // Gunakan nama model yang benar (PascalCase)
        $orders = orders::with('items', 'meja')->findOrFail($Id);

        // dd($orders);

        $cart = session('cart', []);
        $kategori = kategoris::with('menu')->get(); // Perbaiki penulisan model

        $totalHarga = 0;
        $totalItem = 0;

        // Perbaikan perhitungan total
        foreach ($orders->items as $item) {

            $totalHarga += $item->harga * $item->qty;
            $totalItem += $item->qty;
        }

        return view('frondsite.halamanDetailpembelian', [
            'title' => 'Detail pemesanan',
            'kategori' => $kategori,
            'keranjang' => $cart,
            'orders' => $orders,
            'order_items' => $orders->items,
            'total_harga' => $totalHarga,
            'total_item' => $totalItem,
        ]);
    }

    public function delate_cartitem($id)
    {
        $cart = session('cart', []);

        $cart = collect($cart)->filter(function ($item) use ($id) {
            return $item['id'] != $id;
        })->values()->toArray();

        session(['cart' => $cart]);

        return redirect('/checkout')->with('success', 'Cart item dihapus!');
    }

    public function cart_destroy()
    {
        session()->forget('cart');

        return redirect('/')->with('success', 'Checkout dibatalkan!.');
    }


    public function receive(Request $request)
    {
        $notification = new Notification();

        $transaction = $notification->transaction_status;
        $order_id = $notification->order_id;
        $payment_type = $notification->payment_type;
        $fraud_status = $notification->fraud_status;

        // Sesuaikan dengan model Order kamu
        $order = orders::where('order_id', $order_id)->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Tangani status transaksi
        switch ($transaction) {
            case 'capture':
                if ($payment_type == 'credit_card') {
                    if ($fraud_status == 'challenge') {
                        $order->status = 'challenge';
                    } else {
                        $order->status = 'success';
                    }
                }
                break;
            case 'settlement':
                $order->status = 'success';
                break;
            case 'pending':
                $order->status = 'pending';
                break;
            case 'deny':
            case 'cancel':
            case 'expire':
                $order->status = 'failed';
                break;
        }

        $order->save();

        return response()->json(['message' => 'Notification processed']);
    }
}
