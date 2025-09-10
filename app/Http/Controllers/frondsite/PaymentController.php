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
            'nama' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'metode' => 'required',
        ]);

        session()->put('phone', $request->phone);

         // Hitung total dari cart
         $cart = session('cart', []);
         $totalHarga = 0;
         $totalItem = 0;

        foreach ($cart as $item) {
            $totalHarga += $item['harga'] * $item['qty'];
            $totalItem += $item['qty'];
        }
        $order = Order::where('phone', $request->phone)->where('payment_status', 'unpaid')->first();

        if ($order) {
            return redirect(route('history.order'))->with('error', 'Anda sudah memiliki pesanan yang belum dibayar');
        }

         // simpan order ke database
         $order = Order::create([
             'order_id'       => 'ORD-' . Str::uuid(),
             'nama'           => $request->nama,
             'phone'          => $request->phone,
             'email'          => $request->email,
             'meja_id'        => 1,
             'waktu_pesan'    => now(),
             'payment_status' => 'unpaid',
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
                'harga'         => $item['harga'],
                'catatan_menu'       => $item['catatan'],
                'status'        => 'Proses'
            ]);
        }

        $transaction = (new XenditService())->createQrisTransaction($order);
        return redirect($transaction->invoice_url);
    }

    public function historyOrder()
    {
        $phone = session('phone');
        $orders = Order::with('transaction')->where('phone', $phone)->get();
        return view('frondsite.order-history', [
            'title' => 'Order History',
            'orders' => $orders
        ]);
    }

    public function success(Request $request)
    {

        return redirect(route('history.order'))->with('success', 'Payment success');
    }

    public function failed(Request $request)
    {
        return redirect(route('history.order'))->with('error', 'Payment failed');
    }
    
}