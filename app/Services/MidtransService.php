<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class MidtransService
{
    protected $serverKey;
    protected $isProduction;

    public function __construct()
    {
        $this->serverKey = config('services.midtrans.server_key');
        $this->isProduction = config('services.midtrans.is_production');
    }

    /**
     * Buat transaksi QRIS
     */
    public function createQrisTransaction(Order $order, $acquirer = 'gopay', $expiryMinutes = null)
    {
        $orderId = 'INV-' . Str::uuid(); 
        // add ppn 4000 per order
        $grossAmount = $order->total_harga + 4000;
        $payload = [
            'payment_type' => 'gopay',
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $grossAmount,
            ],
            'item_details' => array_merge(
                $order->items->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'price' => $item->sub_total / $item->qty,
                        'quantity' => $item->qty,
                        'name' => $item->nama_menu,
                    ];
                })->toArray(),
                [
                    [
                        'id' => 'tax',
                        'price' => 4000,
                        'quantity' => 1,
                        'name' => 'PPN',
                    ],
                ]
            ),
            'customer_details' => [
                'name' => $order->nama,
                'email' => $order->email,
                'phone' => $order->phone,
            ], 
            'qris' => [ 'acquirer' => $acquirer ]
        ];

        // dd($payload);
        if ($expiryMinutes) {
            // Setting custom expiry sesuai batas maksimal per acquirer
            $payload['custom_expiry'] = [
                'expiry_duration' => $expiryMinutes,
                'unit' => 'minutes',
            ];
        }

        // Hit ke Midtrans API
        $url = $this->isProduction
            ? 'https://api.midtrans.com/v2/charge'
            : 'https://api.sandbox.midtrans.com/v2/charge';

        $response = Http::withBasicAuth($this->serverKey, '')
            ->post($url, $payload);

        if ($response->failed()) {
            throw new \Exception('Midtrans API error: ' . $response->body());
        }

        $result = $response->json();
        dd($result);
        $transaction = Transaction::create([
            'order_id' => $order->id,
            'midtrans_order_id' => $result['order_id'],
            'midtrans_transaction_id' => $result['transaction_id'] ?? null,
            'payment_type' => $result['payment_type'] ?? 'qris',
            'transaction_status' => $result['transaction_status'] ?? 'pending',
            'gross_amount' => $grossAmount,
            'qr_string' => $result['qr_string'] ?? null,
            'payment_url' => $result['actions'][0]['url'] ?? null,
            'expiry_time' => $result['expiry_time'] ?? null,
            'transaction_time' => $result['transaction_time'] ?? now(),
            'fraud_status' => $result['fraud_status'] ?? null,
            'signature_key' => $result['signature_key'] ?? null,
            'acquirer' => $acquirer ?? null,
        ]);

        return $transaction;
    }
}