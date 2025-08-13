<?php

namespace App\Http\Controllers\backsite_admin;

use App\Models\pembayarans;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AkunController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $pembayaran = pembayarans::sum('jumlah_bayar');

        return view('backsite.akun.halamanAkun', [
            'title'             => 'Akun || Coffe',
            'user'              => $user,
            'pembayaran'        => $pembayaran,
        ]);
    }
}
