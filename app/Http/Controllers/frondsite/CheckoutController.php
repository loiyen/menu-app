<?php

namespace App\Http\Controllers\frondsite;

use Midtrans\Snap;

use Midtrans\Config;
use App\Models\kategoris;
use Midtrans\Notification;
use Illuminate\Http\Request;
use App\Services\MidtransService;
use App\Http\Controllers\Controller;
use App\Models\menus;
use App\Models\order;
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

        $kategori       = kategoris::with('menu')->get();
        $menu           = menus::orderBy('created_at', 'desc')->take(10)->get();

        $cart = session('cart', []);
        $tambahcatatan = session('dataCatatanOpsi', []);//untuk catatan lainya.

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
            'title' => 'Pesanan',
            'tampilkan_alert' => true,
            'kategori' => $kategori,
            'keranjang' => $cart,
            'total_harga' => $totalHarga,
            'total_item' => $totalItem,
            'menu'  => $menu

        ]);
    }

    public function pembayaran()
    {
        
        $kategori       = kategoris::with('menu')->get();
        $menu           = menus::orderBy('created_at', 'desc')->take(10)->get();

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

        return view('frondsite.halamanPembayaran', [
            'title'     => 'Pembayaran',
            'kategori' => $kategori,
            'keranjang' => $cart,
            'total_harga' => $totalHarga,
            'total_item' => $totalItem,
            'menu'  => $menu
        ]);
    }


    public function proses(MidtransService $midtransService, Request $request)
    {
        // dd($request->all());
        $request->validate([
            'nama' => 'required|string|max:255',
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

        // simpan order ke database
        $order = order::create([
            'order_id'       => 'ORD-' . uniqid(),
            'nama'           => $request->nama,
            'meja_id'        => 1,
            'waktu_pesan'    => now(),
            'status'         => 'pending',
            'payment_status' => 'unpaid',
            'opsi'           => $request->opsi_gula,
            'catatan'        => $request->catatan,
            'total_harga'    => $totalHarga
        ]);

        // simpan order items
        foreach ($cart as $item) {
            $order->items()->create([
                'order_id'      => $order->id,
                'menu_id'       => $item['id'],
                'nama_menu'     => $item['nama'],
                'sub_total'     => $item['harga'] * $item['qty'],
                'qty'           => $item['qty'],
                'status'        => 'Proses'
            ]);
        }

      

            // untuk midtrans
            $payment = $order->pembayaran ? $order->pembayaran->last() : null;

            // siapkan item_details untuk Midtrans (sudah kamu punya)
            $itemDetails = [];
            foreach ($cart as $id => $item) {
                $itemDetails[] = [
                    'id'       => (string) $id,
                    'name'     => $item['nama'],
                    'price'    => (int) $item['harga'],
                    'quantity' => (int) $item['qty'],
                ];
            }

            if ($payment === null || $payment->status === 'gagal') {
                try {
                    // RANGKAI PARAMS SESUAI SPEK MIDTRANS
                    $params = [
                        'transaction_details' => [
                            // penting: gunakan kode unik yang kamu simpan di kolom order_id (mis. "ORD-xxxx"),
                            // bukan $order->id agar konsisten & unik di Midtrans
                            'order_id'     => $order->order_id,
                            'gross_amount' => (int) $totalHarga,
                        ],
                        'customer_details' => [
                            'first_name' => $request->nama,
                            'email'      => $request->email ?? 'guest@example.com',
                            'phone'      => $request->phone ?? '',
                        ],
                        'item_details'     => $itemDetails,
                        'enabled_payments' => [
                            'gopay',
                            'shopeepay',
                            'bank_transfer',
                            'bca_va',
                            'bni_va',
                            'bri_va',
                        ],
                        // opsional: atur kedaluwarsa
                        // 'expiry' => ['unit' => 'minutes', 'duration' => 120],
                    ];

                    // PANGGIL SERVICE DENGAN ARRAY
                    $snapToken = $midtransService->createSnapToken($params);

                    // simpan payment baru
                    $order->pembayaran()->create([
                        // 'snap_token'   => $snapToken,
                        'metode'       => 'transfer',
                        'jumlah_bayar' => $totalHarga,
                        'status'       => 'Menunggu',
                        'waktu_bayar'  => now(),
                    ]);
                } catch (\Exception $e) {
                    return response()->json([
                        'status'  => 'error',
                        'message' => 'Gagal memproses pembayaran: ' . $e->getMessage(),
                    ], 500);
                }
            } else {
                $snapToken = $payment->snap_token;
            }

            return response()->json([
                'status'     => 'success',
                'order_id'   => $order->id,       // ini untuk URL redirect kamu
                'snap_token' => $snapToken,       // ini untuk snap.pay()
            ]);
        
    }


    public function update_qty(Request $request)
    {
        $request->validate([
            'id'  => 'required',
            'qty' => 'required|integer|min:1'
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$request->id])) {

            $cart[$request->id]['qty'] = $request->qty;

            $cart[$request->id]['total'] = $cart[$request->id]['harga'] * $request->qty;

            session()->put('cart', $cart);

            return redirect('/checkout')->with('success', 'Qty berhasil diperbarui!');
        }

        return redirect('/checkout')->with('error', 'Item tidak ditemukan di keranjang!');
    }

    public function update_catatan(Request $request)
    {
        $request->validate([
            'id'        => 'required',
            'catatan'   => 'required'
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$request->id])) {
            $cart[$request->id]['catatan'] = $request->catatan;

            session()->put('cart', $cart);

            return redirect('/checkout')->with('success', 'Catatan diperbarui!');
        }
        return redirect('/checkout')->with('error', 'Item tidak ditemukan di keranjang.');
    }

    public function update_CatatandanOpsi(Request $request)
    {

        $catatanOpsi = session()->get('dataCatatanOpsi', []);

        $catatanOpsi[] = [
            'catatan'       => $request->catatan_optional,
            'opsi_gula'     => $request->opsi_gula
        ];

        session()->put('dataCatatanOpsi', $catatanOpsi);

        return redirect('/checkout')->with('success', 'Catatan dan Opsi di tambahkan.');
    }

    //halaman setelah pembayaran sukses
    // public function get_pesanan_detail($Id)
    // {
        
    //     $orders = orders::with('items', 'meja')->findOrFail($Id);

    //     // dd($orders);

    //     $cart = session('cart', []);
    //     $kategori = kategoris::with('menu')->get(); // Perbaiki penulisan model

    //     $totalHarga = 0;
    //     $totalItem = 0;

    //     // Perbaikan perhitungan total
    //     foreach ($orders->items as $item) {

    //         $totalHarga += $item->harga * $item->qty;
    //         $totalItem += $item->qty;
    //     }

    //     return view('frondsite.halamanDetailpembelian', [
    //         'title' => 'Detail pemesanan',
    //         'kategori' => $kategori,
    //         'keranjang' => $cart,
    //         'orders' => $orders,
    //         'order_items' => $orders->items,
    //         'total_harga' => $totalHarga,
    //         'total_item' => $totalItem,
    //     ]);
    // }

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
    public function pesanan_selesai()
    {
        session()->forget('cart');

        return redirect('/')->with('success', 'Pesanan selesai!');
    }
}
