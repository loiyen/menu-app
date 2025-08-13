<?php

namespace App\Services;


use App\Models\orders;
use Exception;
use Midtrans\Config;
use Midtrans\Notification;
use Midtrans\Snap;

class MidtransService
{
    protected string $serverKey;
    protected string $isProduction;
    protected string $isSanitized;
    protected string $is3ds;

    /**
     * MidtransService constructor.
     *
     * Menyiapkan konfigurasi Midtrans berdasarkan pengaturan yang ada di file konfigurasi.
     */
    public function __construct()
    {
        // Konfigurasi server key, environment, dan lainnya
        $this->serverKey = config('midtrans.server_key');
        $this->isProduction = config('midtrans.is_production');
        $this->isSanitized = config('midtrans.sanitized');
        $this->is3ds = config('midtrans.3ds');

        // Mengatur konfigurasi global Midtrans
        Config::$serverKey = $this->serverKey;
        Config::$isProduction = $this->isProduction;
        Config::$isSanitized = $this->isSanitized;
        Config::$is3ds = $this->is3ds;
    }

    /**
     * Membuat snap token untuk transaksi berdasarkan data order.
     *
     * @param Order $order Objek order yang berisi informasi transaksi.
     *
     * @return string Snap token yang dapat digunakan di front-end untuk proses pembayaran.
     * @throws Exception Jika terjadi kesalahan saat menghasilkan snap token.
     */
    public function createSnapToken(array $params): string
    {
        return Snap::getSnapToken($params);
    }

    //modif
    public function getSnapToken(array $params)
    {
        try {
            // Tambahkan default config jika diperlukan
            $params = array_merge([
                'currency' => 'IDR',
                'expiry' => [
                    'unit' => 'hours',
                    'duration' => 24
                ]
            ], $params);

            return Snap::getSnapToken($params);
            
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }


    /**
     * Memvalidasi apakah signature key yang diterima dari Midtrans sesuai dengan signature key yang dihitung di server.
     *
     * @return bool Status apakah signature key valid atau tidak.
     */
    public function isSignatureKeyVerified(): bool
    {
        $notification = new Notification();

        // Membuat signature key lokal dari data notifikasi
        $localSignatureKey = hash(
            'sha512',
            $notification->order_id . $notification->status_code .
            $notification->gross_amount . $this->serverKey
        );

        // Memeriksa apakah signature key valid
        return $localSignatureKey === $notification->signature_key;
    }

    /**
     * Mendapatkan data order berdasarkan order_id yang ada di notifikasi Midtrans.
     *
     * @return Order Objek order yang sesuai dengan order_id yang diterima.
     */
    public function getOrder(): orders
    {
        $notification = new Notification();

        // Mengambil data order dari database berdasarkan order_id
        return orders::where('order_id', $notification->order_id)->first();
    }

    /**
     * Mendapatkan status transaksi berdasarkan status yang diterima dari notifikasi Midtrans.
     *
     * @return string Status transaksi ('success', 'pending', 'expire', 'cancel', 'failed').
     */
    public function getStatus(): string
    {
        $notification = new Notification();
        $transactionStatus = $notification->transaction_status;
        $fraudStatus = $notification->fraud_status;

        return match ($transactionStatus) {
            'capture' => ($fraudStatus == 'accept') ? 'success' : 'pending',
            'settlement' => 'success',
            'deny' => 'failed',
            'cancel' => 'cancel',
            'expire' => 'expire',
            'pending' => 'pending',
            default => 'unknown',
        };
    }

    /**
     * Memetakan item dalam order menjadi format yang dibutuhkan oleh Midtrans.
     *
     * @param Order $order Objek order yang berisi daftar item.
     * @return array Daftar item yang dipetakan dalam format yang sesuai.
     */
    protected function mapItemsToDetails(orders $order): array
    {
        return $order->items()->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'price' => $item->price,
                'quantity' => $item->quantity,
                'name' => $item->product_name,
            ];
        })->toArray();
    }

    /**
     * Mendapatkan informasi customer dari order.
     * Data ini dapat diambil dari relasi dengan tabel lain seperti users atau tabel khusus customer.
     *
     * @param Order $order Objek order yang berisi informasi tentang customer.
     * @return array Data customer yang akan dikirim ke Midtrans.
     */
    protected function getCustomerDetails(orders $order): array
    {
        // Sesuaikan data customer dengan informasi yang dimiliki oleh aplikasi Anda
        return [
            'first_name' => 'Nama Customer', // Ganti dengan data nyata
            'email' => 'Email@email.com', // Ganti dengan data nyata
            'phone' => '081234567890', // Ganti dengan data nyata
        ];
    }
}
