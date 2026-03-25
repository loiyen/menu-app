<?php

namespace App\Http\Controllers\frondsite;

use App\Http\Controllers\Controller;
use App\Models\Kategoris;
use App\Models\menus;
use App\Models\Menuses;
use App\Models\order;
use App\Models\Orders;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Unique;
use Midtrans\Config;
use Midtrans\Notification;
use Midtrans\Snap;

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

        $kategori       = Kategoris::with('menu')->get();
        $menu           = Menuses::orderBy('created_at', 'desc')->take(10)->get();

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
            'title' => 'Pesanan',
            'tampilkan_alert' => true,
            'kategori' => $kategori,
            'keranjang' => $cart,
            'total_harga' => $totalHarga,
            'total_item' => $totalItem,
            'menu'  => $menu

        ]);
    }

    

    public function update_qty(Request $request)
    {
        $cart = session()->get('cart', []);

        $id  = $request->input('id');
        $qty = (int) $request->input('qty', 1);

        if ($request->qty > 10) {
            return redirect('/checkout')->with('error', 'Maximal 10 item!');
        }

        if (isset($cart[$id])) {
            $cart[$id]['qty'] = $qty;

            if (isset($cart[$id]['harga'])) {
                $cart[$id]['subtotal'] = $qty * $cart[$id]['harga'];
            }
        } else {
            $cart[$id] = [
                'id'  => $id,
                'qty' => $qty,
            ];
        }

        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'message' => 'Cart updated',
            'cart'    => $cart,
        ]);
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
    public function get_pesanan_detail($Id)
    {

        $orders = Orders::with('items', 'meja', 'transaction')->findOrFail($Id);

        $cart = session('cart', []);
        $kategori = Kategoris::with('menu')->get();

        $totalHarga = 0;
        $totalItem = 0;

        foreach ($orders->items as $item) {

            $totalHarga += $item->harga * $item->qty;
            $totalItem += $item->qty;
        }

        return view('frondsite.pesanan.halamanDetailpembelian', [
            'title' => 'Detail pemesanan',
            'kategori' => $kategori,
            'keranjang' => $cart,
            'orders' => $orders,
            // 'order_items' => $orders->items,
            'total_harga' => $totalHarga,
            'total_item' => $totalItem,
        ]);
    }

    //edit pesanan
    public function edit_pesanan($id)
    {

        $cart = session('cart', []);
        $kategori = Kategoris::with('menu')->get();

        $totalHarga = 0;
        $totalItem = 0;

        foreach ($cart as $item) {
            $totalHarga += $item['harga'] * $item['qty'];
            $totalItem += $item['qty'];
        }

        $item     = $cart[$id] ?? null;

        return view('frondsite.halamanEditPesanan', [
            'title'         => 'Edit pesanan',
            'pesanan'       => $item,
            'keranjang' => $cart,
            'kategori' => $kategori,
            'total_harga' => $totalHarga,
            'total_item' => $totalItem
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
    public function pesanan_selesai()
    {
        session()->forget('cart');

        return redirect('/')->with('success', 'Pesanan selesai!');
    }

    public function pembayaran()
    {
        
        $kategori       = Kategoris::with('menu')->get();
        $menu           = Menuses::orderBy('created_at', 'desc')->take(10)->get();

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
}



