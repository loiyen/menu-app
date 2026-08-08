<?php

namespace App\Http\Controllers\backsite_admin;

use App\Http\Controllers\Controller;
use App\Models\OrderItems;
use App\Models\Orders;
use App\Models\Transaction;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'dari' => [
                'nullable',
                'date',
            ],
            'sampai' => [
                'nullable',
                'date',
                'after_or_equal:dari',
            ],
            'payment_status' => [
                'nullable',
                'in:all,paid,unpaid',
            ],
            'status_order' => [
                'nullable',
                'in:all,proses,selesai',
            ],
        ]);

        $user = Auth::user();

        $dari = $request->filled('dari')
            ? Carbon::parse($request->dari)->startOfDay()
            : now()->startOfMonth()->startOfDay();

        $sampai = $request->filled('sampai')
            ? Carbon::parse($request->sampai)->endOfDay()
            : now()->endOfDay();

        $paymentStatus = $request->get(
            'payment_status',
            'all'
        );

        $statusOrder = $request->get(
            'status_order',
            'all'
        );

        $orderQuery = Orders::query()
            ->whereBetween(
                'waktu_pesan',
                [$dari, $sampai]
            );

        if ($paymentStatus !== 'all') {
            $orderQuery->where(
                'payment_status',
                $paymentStatus
            );
        }

        if ($statusOrder !== 'all') {
            $orderQuery->where(
                'status_order',
                $statusOrder
            );
        }


        $totalOrders = (clone $orderQuery)
            ->count();

        $totalNilaiPesanan = (clone $orderQuery)
            ->sum('total_harga');

        $totalPaid = (clone $orderQuery)
            ->whereRaw(
                'LOWER(payment_status) = ?',
                ['paid']
            )
            ->count();

        $totalUnpaid = (clone $orderQuery)
            ->whereRaw(
                'LOWER(payment_status) = ?',
                ['unpaid']
            )
            ->count();

        $totalOrderProses = (clone $orderQuery)
            ->where(
                'status_order',
                'proses'
            )
            ->count();

        $totalOrderSelesai = (clone $orderQuery)
            ->where(
                'status_order',
                'selesai'
            )
            ->count();


        $transactionQuery = Transaction::query()
            ->join(
                'orders',
                'orders.id',
                '=',
                'transactions.order_id'
            )
            ->whereBetween(
                'orders.waktu_pesan',
                [$dari, $sampai]
            );

        if ($paymentStatus !== 'all') {
            $transactionQuery->where(
                'orders.payment_status',
                $paymentStatus
            );
        }

        if ($statusOrder !== 'all') {
            $transactionQuery->where(
                'orders.status_order',
                $statusOrder
            );
        }

     
        $successfulStatuses = [
            'PAID',
            'SETTLED',
            'SETTLEMENT',
            'SUCCESS',
        ];

        $totalPendapatan = (clone $transactionQuery)
            ->whereIn(
                DB::raw(
                    'UPPER(transactions.transaction_status)'
                ),
                $successfulStatuses
            )
            ->sum('transactions.gross_amount');


        $orderItemQuery = OrderItems::query()
            ->join(
                'orders',
                'orders.id',
                '=',
                'order_items.order_id'
            )
            ->whereBetween(
                'orders.waktu_pesan',
                [$dari, $sampai]
            );

        if ($paymentStatus !== 'all') {
            $orderItemQuery->where(
                'orders.payment_status',
                $paymentStatus
            );
        }

        if ($statusOrder !== 'all') {
            $orderItemQuery->where(
                'orders.status_order',
                $statusOrder
            );
        }

        $totalItemTerjual = (clone $orderItemQuery)
            ->sum('order_items.qty');

      

        $persentasePaid = $totalOrders > 0
            ? round(
                ($totalPaid / $totalOrders) * 100,
                1
            )
            : 0;

        $persentaseSelesai = $totalOrders > 0
            ? round(
                ($totalOrderSelesai / $totalOrders) * 100,
                1
            )
            : 0;

        $paymentSummary = (clone $transactionQuery)
            ->whereIn(
                DB::raw(
                    'UPPER(transactions.transaction_status)'
                ),
                $successfulStatuses
            )
            ->selectRaw(
                '
                    LOWER(transactions.payment_type)
                    AS payment_type
                '
            )
            ->selectRaw(
                '
                    COUNT(transactions.id)
                    AS total_transactions
                '
            )
            ->selectRaw(
                '
                    SUM(transactions.gross_amount)
                    AS total_amount
                '
            )
            ->groupBy(
                DB::raw(
                    'LOWER(transactions.payment_type)'
                )
            )
            ->orderByDesc('total_amount')
            ->get();

    
        $topMenus = (clone $orderItemQuery)
            ->select([
                'order_items.menu_id',
                'order_items.nama_menu',
            ])
            ->selectRaw(
                '
                    SUM(order_items.qty)
                    AS total_qty
                '
            )
            ->selectRaw(
                '
                    SUM(order_items.sub_total)
                    AS total_omzet
                '
            )
            ->groupBy([
                'order_items.menu_id',
                'order_items.nama_menu',
            ])
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();


        $groupByMonth = $dari->diffInDays($sampai) > 62;

        $orderDateExpression = $groupByMonth
            ? "DATE_FORMAT(waktu_pesan, '%Y-%m')"
            : 'DATE(waktu_pesan)';

        $transactionDateExpression = $groupByMonth
            ? "DATE_FORMAT(orders.waktu_pesan, '%Y-%m')"
            : 'DATE(orders.waktu_pesan)';

        $orderTrend = (clone $orderQuery)
            ->selectRaw(
                "{$orderDateExpression} AS periode"
            )
            ->selectRaw(
                'COUNT(*) AS total_order'
            )
            ->groupBy('periode')
            ->orderBy('periode')
            ->get()
            ->keyBy('periode');

        $revenueTrend = (clone $transactionQuery)
            ->whereIn(
                DB::raw(
                    'UPPER(transactions.transaction_status)'
                ),
                $successfulStatuses
            )
            ->selectRaw(
                "{$transactionDateExpression} AS periode"
            )
            ->selectRaw(
                '
                    SUM(transactions.gross_amount)
                    AS total_pendapatan
                '
            )
            ->groupBy('periode')
            ->orderBy('periode')
            ->get()
            ->keyBy('periode');

        $chartLabels = [];
        $chartOrders = [];
        $chartRevenue = [];

        if ($groupByMonth) {
            $cursor = $dari
                ->copy()
                ->startOfMonth();

            $lastMonth = $sampai
                ->copy()
                ->startOfMonth();

            while ($cursor->lte($lastMonth)) {
                $key = $cursor->format('Y-m');

                $chartLabels[] = $cursor->format('M Y');

                $chartOrders[] = (int) (
                    $orderTrend->get($key)?->total_order
                    ?? 0
                );

                $chartRevenue[] = (float) (
                    $revenueTrend
                        ->get($key)
                        ?->total_pendapatan
                    ?? 0
                );

                $cursor->addMonth();
            }
        } else {
            foreach (
                CarbonPeriod::create(
                    $dari->copy()->startOfDay(),
                    $sampai->copy()->startOfDay()
                ) as $date
            ) {
                $key = $date->format('Y-m-d');

                $chartLabels[] = $date->format('d M');

                $chartOrders[] = (int) (
                    $orderTrend->get($key)?->total_order
                    ?? 0
                );

                $chartRevenue[] = (float) (
                    $revenueTrend
                        ->get($key)
                        ?->total_pendapatan
                    ?? 0
                );
            }
        }

        $orders = (clone $orderQuery)
            ->with([
                'meja',
                'transaction',
                'items',
            ])
            ->latest('waktu_pesan')
            ->paginate(10)
            ->withQueryString();

        return view(
            'backsite.laporan.halamanlaporan',
            [
                'title' => 'Laporan',
                'user' => $user,

                'dari' => $dari,
                'sampai' => $sampai,

                'totalOrders' => $totalOrders,
                'totalNilaiPesanan' => $totalNilaiPesanan,
                'totalPendapatan' => $totalPendapatan,
                'totalPaid' => $totalPaid,
                'totalUnpaid' => $totalUnpaid,
                'totalOrderProses' => $totalOrderProses,
                'totalOrderSelesai' => $totalOrderSelesai,
                'totalItemTerjual' => $totalItemTerjual,

                'persentasePaid' => $persentasePaid,
                'persentaseSelesai' => $persentaseSelesai,

                'paymentSummary' => $paymentSummary,
                'topMenus' => $topMenus,
                'orders' => $orders,

                'chartLabels' => $chartLabels,
                'chartOrders' => $chartOrders,
                'chartRevenue' => $chartRevenue,
            ]
        );
    }
}