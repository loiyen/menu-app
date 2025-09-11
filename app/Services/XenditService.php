<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class XenditService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.xendit.api_key');
    }

    /**
     * Buat QRIS Transaction
     */
    public function createQrisTransaction(Order $order)
    {
        $externalId = 'ORD-' . $order->id . '-' . Str::uuid();
        $grossAmount = $order->total_harga + 4000;
        $payload = [
            'external_id' => $externalId,
            'amount' => $grossAmount,
            'description' => 'Pembayaran Order #' . $externalId,
            'currency' => 'IDR',
            'invoice_duration' => 600,
            'customer' => [
                'given_names' => $order->nama ?? 'Customer',
                'email' => $order->email ?? 'customer@example.com',
                'mobile_number' => $order->phone ?? '08123456789',
            ],
            'customer_notification_preference' => [
                'invoice_created' => ['email'],
                'invoice_reminder' => ['email'],
                'invoice_paid' => ['email'],
                'invoice_expired' => ['email'],
            ],
            'success_redirect_url' => url('/payment-success'),
            'failure_redirect_url' => url('/payment-failure'),
            'items' => 
                $order->items->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'price' => $item->sub_total / $item->qty,
                        'quantity' => $item->qty,
                        'name' => $item->nama_menu,
                    ];
                })->toArray(),
            'fees' => [
                [
                    'type' => 'PPN',
                    'value' => 4000,
                ],
            ],
            'payment_methods' => ['QRIS'],
            'metadata' => [
                'order_id' => $order->id,
            ],
        ];
        $headers = [
            'api-version' => "2022-07-31" ,
            'Content-Type' => 'application/json',
        ];

        $response = Http::withBasicAuth($this->apiKey, '')
            ->withHeaders($headers)
            ->post('https://api.xendit.co/v2/invoices', $payload);
        if ($response->failed()) {
            throw new \Exception('Xendit API error: ' . $response->body());
        }
        $result = $response->json();
        Log::info('Xendit Response:', $result);
        $expiry = null;
        if (!empty($result['expiry_date'])) {
            $expiry = \Carbon\Carbon::parse($result['expiry_date'])
                ->setTimezone('Asia/Jakarta')
                ->format('Y-m-d H:i:s');
        }

        return Transaction::create([
            'order_id' => $order->id,
            'xendit_external_id' => $externalId, 
            'payment_type' => 'qris',
            'transaction_status' => 'PENDING',
            'gross_amount' => $grossAmount,
            'invoice_url' => $result['invoice_url'] ?? null,
            'expiry_time' => $expiry
        ]);
    }
}