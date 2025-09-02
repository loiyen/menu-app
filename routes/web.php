<?php

use App\Models\kategoris;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\frondsite\SearchController;
use App\Http\Controllers\frondsite\CheckoutController;
use App\Http\Controllers\backsite_admin\AkunController;
use App\Http\Controllers\backsite_admin\MejasController;
use App\Http\Controllers\backsite_admin\MenusController;
use App\Http\Controllers\backsite_admin\OrdersController;
use App\Http\Controllers\backsite_admin\QrcodeController;
use App\Http\Controllers\frondsite\halamanHomeController;

use App\Http\Controllers\backsite_admin\KategorisController;
use App\Http\Controllers\backsite_admin\PembayaransController;
use App\Http\Controllers\backsite_kasir\RiwayatKasirController;
use App\Http\Controllers\backsite_barista\RiwayatPesanController;
use App\Http\Controllers\backsite_kasir\DashboardKasirController;
use App\Http\Controllers\backsite_admin\halamanDashboardController;
use App\Http\Controllers\backsite_barista\DashboardBaristaController;
use App\Http\Controllers\frondsite\RiwayatTransController;

//scan 

Route::get('/pesan/meja/{nomor_meja}', [halamanDashboardController::class, 'scan_qr']);

Route::get('/', [halamanHomeController::class, 'index']);

//info
Route::get('/info-jam', [halamanHomeController::class, 'info_jam_kafe']);

//detail menu
Route::get('/detail/{id}', [halamanHomeController::class, 'detail_itemMenu'])->name('detail.menu');

//pencarian
Route::get('/menu/search-live', [SearchController::class, 'searchLive1']);
Route::get('/menu1/search-live', [SearchController::class, 'searchLive2']);

//cart
Route::post('/add-cart', [halamanHomeController::class, 'add_cart'])->name('cart.add');
Route::post('/hapus', [halamanHomeController::class, 'delate_cart'])->name('hapus.cart');
Route::get('/hapus-cart/{id}', [halamanHomeController::class, 'delate_cartitem'])->name('hapus.cartitem');

//checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/update/item', [CheckoutController::class, 'update_qty'])->name('add.item');
Route::post('/update/catatan', [CheckoutController::class, 'update_catatan'])->name('update.catatan');
Route::post('/updatecatatanopsi', [CheckoutController::class, 'update_CatatandanOpsi'])->name('update.catatanopsi');
Route::get('/hapuscartcheckout/{id}', [CheckoutController::class, 'delate_cartitem'])->name('hapus.cartitemcekout');
Route::post('/hapus/keranjang/', [CheckoutController::class, 'cart_destroy'])->name('hapus.keranjang');

//pembayaran
Route::get('/pembayaran-pesanan', [CheckoutController::class, 'pembayaran']);


Route::post('/generate-snap-token', [CheckoutController::class, 'show_snap'])->name('snapToken.create');

//pembayaran
Route::post('/order/process', [CheckoutController::class, 'proses'])->name('checkout.proses');
Route::post('/midtrans/callback', [CheckoutController::class, 'receive']);

//detail pemesanan 
Route::get('/detailpemesanan/{order_id}', [CheckoutController::class, 'get_pesanan_detail'])->name('detail.pemesananuser');
Route::get('/pesananselesai', [CheckoutController::class, 'pesanan_selesai'])->name('pesanan.selesai');

//riwayat pesanan
Route::get('/riwayat-pesanan', [RiwayatTransController::class, 'index'])->name('riwayat.pesananuser');
Route::get('/detail-riwayat', [RiwayatTransController::class, 'detail_riwayat_pemesanan']);


//barista
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboardbarista', [DashboardBaristaController::class, 'index'])->name('barista.dashboard');
    // Route::post('/logout', [DashboardBaristaController::class, 'logout'])->name('logout');
    Route::get('/order_today/search', [DashboardBaristaController::class, 'searchLive_barista_today']);
    Route::get('/print/order/{id}', [DashboardBaristaController::class, 'print_order'])->name('print.pemesanan');

    //detail
    Route::get('/detail/pemesanan/{id}', [DashboardBaristaController::class, 'detail_order_customer'])->name('detail.pemesanan');
    Route::post('/item/proses/{id}', [DashboardBaristaController::class, 'proses']);
    Route::post('/order/selesai/{id}', [DashboardBaristaController::class, 'selesai']);

    //riwayat
    Route::get('/riwayat', [RiwayatPesanController::class, 'index'])->name('orderbarista.index');
    Route::get('/riwayat/{id}', [RiwayatPesanController::class, 'detail_order_customer'])->name('riwayat.detail');
    Route::get('/orderbarista/search-live', [RiwayatPesanController::class, 'searchLive_barista']);
});

//kasir
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard-kasir', [DashboardKasirController::class, 'index'])->name('dashboard.kasir');

    Route::post('/kasir/add', [DashboardKasirController::class, 'kasir_add'])->name('kasir.add');
    Route::get('/kasir/active-order', [DashboardKasirController::class, 'kasir_active_order']);

    Route::get('/order_today_kasir/search', [DashboardKasirController::class, 'searchLive_kasir']);
    Route::put('/bayar/{id}', [DashboardKasirController::class, 'pembayaran_kasir'])->name('bayar.kasir');

    Route::put('/pembayaran/update/{id}', [DashboardKasirController::class, 'pembayaran_proses'])->name('pembayaran.update');
    Route::get('/pembayaran-nota/{id}', [DashboardKasirController::class, 'nota_pembayaran'])->name('nota.kasir');

    Route::get('/print-kasir-nota/{id}', [DashboardKasirController::class, 'print_nota_kasir'])->name('print.notakasir');
    Route::get('/detail-kasir/{id}', [DashboardKasirController::class, 'detail_kasir'])->name('detail.kasir');

    Route::get('/riwayat-kasir', [RiwayatKasirController::class, 'index'])->name('orderkasir.index');
    Route::get('/filter-by', [RiwayatKasirController::class, 'filter_datakasir'])->name('filter.kasir');
    Route::get('/order_kasir/search', [RiwayatKasirController::class, 'search_by_nama']);
});

//admin
Route::middleware(['auth', 'verified'])->group(function () {
    //dashboard
    Route::get('/dashboard', [halamanDashboardController::class, 'index'])->name('dashboard');

    //menu
    Route::get('/menu', [MenusController::class, 'index'])->name('menu.index');
    Route::post('/simpanmenu', [MenusController::class, 'create'])->name('simpan.menu');
    Route::put('/menu/{id}', [MenusController::class, 'edit'])->name('edit.menu');
    Route::post('/simpanedit/{id}', [MenusController::class, 'update'])->name('simpan.edit');
    Route::delete('/hapus/{id}', [MenusController::class, 'destroy'])->name('hapus.menu');
    Route::get('/menu3/search-live', [MenusController::class, 'searchLive_ds'])->name('menu.searchLive');

    //kategori
    Route::get('/kategori', [KategorisController::class, 'index']);
    Route::post('/simpankategori', [KategorisController::class, 'create'])->name('simpan.kategori');
    Route::delete('/hapuskategori/{id}', [KategorisController::class, 'destroy'])->name('hapus.kategori');

    //meja
    Route::get('/meja', [MejasController::class, 'index']);
    Route::get('/print/{nomor}', [QrcodeController::class, 'printQr'])->name('print.meja');
    Route::get('/printall', [QrcodeController::class, 'printAllQr'])->name('print.all');
    Route::post('/simpanmeja', [MejasController::class, 'create'])->name('simpan.meja');
    Route::delete('/hapusmeja/{id}', [MejasController::class, 'destroy'])->name('hapus.meja');

    //order
    Route::get('/order', [OrdersController::class, 'index'])->name('order.index');
    Route::get('/order/{id}', [OrdersController::class, 'show'])->name('detail.order');
    Route::get('/order/order-id/search-live', [OrdersController::class, 'searchLive'])->name('order.searchLive');
    Route::get('/filterdataorder', [OrdersController::class, 'filter_Data_by_date']);

    //pembayaran 
    Route::get('/pembayaran', [PembayaransController::class, 'index'])->name('pembayaran.index');
    Route::get('/detail/pembayaran/{id}', [PembayaransController::class, 'detail_pembayaran'])->name('detail.pembayaran');
    Route::get('/filterdatapembayaran', [PembayaransController::class, 'filter_Data_by_date']);

    //akun
    Route::get('/akun', [AkunController::class, 'index']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
