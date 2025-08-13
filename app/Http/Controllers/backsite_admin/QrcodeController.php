<?php

namespace App\Http\Controllers\backsite_admin;

use App\Http\Controllers\Controller;
use App\Models\mejas;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrcodeController extends Controller
{

    public function printAllQr(){
        $meja       = mejas::all();
        
        return view('backsite.Qrcode.halamanAllPrintQrcode', compact('meja'));

    }

    public function printQr($nomor)
    {
        $meja = mejas::where('nomor_meja', $nomor)->firstOrFail();
       
        $url = url('/pesan/meja/' . $meja->nomor_meja);
        $qr  = QrCode::size(200)->generate($url);

        return view('backsite.Qrcode.halamanPrintQrcodeMeja', compact('meja', 'qr', 'url'));
    }
}
