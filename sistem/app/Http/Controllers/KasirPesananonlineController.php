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

class KasirPesananonlineController extends Controller
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

        return view('/kasir-pesananonline', compact('pesanan', 'pesananDetail', 'pengiriman', 'buktiPembayaran', 'tanggal'));
    }


    public function konfirmasiPembayaran(Request $request)
    {
        $buktiPembayaranId = $request->input('bukti_pembayaran_id');

        BuktiPembayaran::where('id_bukti', $buktiPembayaranId)->update(['konfirmasi' => 'Terkonfirmasi']);

        return redirect()->back()->with('success', 'Pembayaran telah dikonfirmasi.');
    }

    public function updateStatus(Request $request)
    {
        $pesananId = $request->input('pesanan_id');
        $status = $request->input('status');

        Pesanan::where('id_pesanan', $pesananId)->update(['status' => $status]);

        return redirect()->back()->with('success', 'Status pesanan telah diperbarui.');
    }

    public function downloadpesanan()
    {
        $pesanan = Pesanan::get();
        $pengiriman = Pengiriman::whereIn('id_pesanan', $pesanan->pluck('id_pesanan'))->get();
        
        $pdf = PDF::loadview('pdf-pesanan', compact('pesanan', 'pengiriman'));
        $pdf->setPaper('F4', 'landscape');
        return $pdf->stream('data-invoicepesanan.pdf');
    }

    public function downloadpesanandetail()
    {
        $pesananDetail = PesananDetail::get();
        $pdf = PDF::loadview('pdf-pesanandetail', compact('pesananDetail'));
        $pdf->setPaper('F4', 'landscape');
        return $pdf->stream('data-produkonlineterjual.pdf');
    }
}