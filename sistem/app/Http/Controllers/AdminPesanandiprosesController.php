<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Pesanan;
use App\Models\PesananDetail;
use App\Models\Produk;
use App\Models\Pengiriman;
use App\Models\BuktiPembayaran;
use App\Models\BuktiPenerimaan;
use Redirect;
use Session;
use PDF;
use Image;

class AdminPesanandiprosesController extends Controller
{
    public function index(Request $request)
    {
        $tanggal = $request->input('tanggal');
        $pesanan = Pesanan::query();
 
        if ($tanggal) {
            $pesanan = $pesanan->whereDate('updated_at', $tanggal);
        }

        $pesanan = $pesanan->orderBy('updated_at', 'desc')->get();

        $pesananDetail = PesananDetail::whereIn('id_pesanan', $pesanan->pluck('id_pesanan'))->get();
        $pengiriman = Pengiriman::whereIn('id_pesanan', $pesanan->pluck('id_pesanan'))->get();
        $buktiPembayaran = BuktiPembayaran::whereIn('id_pesanan', $pesanan->pluck('id_pesanan'))->get();
        $buktiPenerimaan = BuktiPenerimaan::whereIn('id_pesanan', $pesanan->pluck('id_pesanan'))->get();

        return view('/admin-pesanandiproses', compact('pesanan', 'pesananDetail', 'pengiriman', 'buktiPembayaran', 'buktiPenerimaan', 'tanggal'));
    }
}