<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;

class XenditCallbackController extends Controller
{
   
    public function __invoke(Request $request)
    {
        Log::info('Xendit Callback Received', $request->all());

        $callbackToken = $request->header('x-callback-token');

        if ($callbackToken !== config('services.xendit.callback_token')) {
            Log::warning('Invalid Xendit Callback Token');

            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $externalId = $request->external_id;
        $status = strtoupper($request->status ?? '');

        if (!$externalId) {
            return response()->json(['message' => 'Invalid callback'], 400);
        }

        if (!in_array($status, ['PAID', 'EXPIRED', 'FAILED'])) {
            return response()->json(['message' => 'Invalid status'], 400);
        }

        try {
            DB::beginTransaction();

            $transaction = Transaction::where('xendit_external_id', $externalId)
                ->lockForUpdate()
                ->first();

            if (!$transaction) {
                Log::warning('Xendit Transaction Not Found', [
                    'external_id' => $externalId,
                ]);

                DB::commit();

                return response()->json(['message' => 'OK']);
            }

            $order = $transaction->order;

            if (!$order) {
                Log::warning('Transaction Has No Order', [
                    'transaction_id' => $transaction->id,
                ]);

                DB::commit();

                return response()->json(['message' => 'OK']);
            }

            if ($transaction->transaction_status === 'PAID') {
                DB::commit();

                return response()->json(['message' => 'Already processed']);
            }

            if ($status === 'PAID') {
                if ((int) $request->amount !== (int) $order->total_harga) {
                    DB::rollBack();

                    Log::warning('Xendit Amount Mismatch', [
                        'external_id' => $externalId,
                        'request_amount' => $request->amount,
                        'order_amount' => $order->total_harga,
                    ]);

                    return response()->json(['message' => 'Amount mismatch'], 400);
                }

                $transaction->transaction_status = 'PAID';
                $transaction->transaction_time = now();

                $order->payment_status = 'PAID';
                
            }

            if ($status === 'EXPIRED') {
                $transaction->transaction_status = 'EXPIRED';
                $transaction->transaction_time = now();

                $order->payment_status = 'EXPIRED';
            }

            if ($status === 'FAILED') {
                $transaction->transaction_status = 'FAILED';
                $transaction->transaction_time = now();

                $order->payment_status = 'FAILED';
            }

            $order->save();
            $transaction->save();

            DB::commit();

            Log::info('Xendit Callback Processed', [
                'external_id' => $externalId,
                'status' => $status,
            ]);

            return response()->json(['message' => 'OK']);
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Xendit Callback Error', [
                'error' => $e->getMessage(),
                'external_id' => $externalId,
            ]);

            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }
}
