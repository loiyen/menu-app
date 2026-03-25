<?php

namespace App\Http\Controllers\backsite_admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayarans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AkunController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $pembayaran = Pembayarans::sum('jumlah_bayar');

        return view('backsite.akun.halamanAkun', [
            'title'             => 'Akun || Coffe',
            'user'              => $user,
            'pembayaran'        => $pembayaran,
        ]);
    }
}
