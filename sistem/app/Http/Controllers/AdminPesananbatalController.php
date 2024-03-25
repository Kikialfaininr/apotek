<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Pesanan;
use App\Models\PesananDetail;
use App\Models\Produk;
use App\Models\Pengiriman;
use App\Models\BuktiPembayaran;
use Redirect;
use Session;
use PDF;
use Image;

class AdminPesananbatalController extends Controller
{
    public function index(Request $request)
    {
        $tanggal = $request->input('tanggal');
        $pesanan = Pesanan::query();

        if ($tanggal) {
            $pesanan = $pesanan->whereDate('created_at', $tanggal);
        }

        $pesanan = $pesanan->orderBy('created_at', 'desc')->paginate(10);

        $pesananDetail = PesananDetail::whereIn('id_pesanan', $pesanan->pluck('id_pesanan'))->get();
        $pengiriman = Pengiriman::whereIn('id_pesanan', $pesanan->pluck('id_pesanan'))->get();
        $buktiPembayaran = BuktiPembayaran::whereIn('id_pesanan', $pesanan->pluck('id_pesanan'))->get();

        return view('/admin-pesananbatal', compact('pesanan', 'pesananDetail', 'pengiriman', 'buktiPembayaran', 'tanggal'));
    }
}