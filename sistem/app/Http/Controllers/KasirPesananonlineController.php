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

class KasirPesananonlineController extends Controller
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

        return view('kasir-pesananonline', compact('pesanan', 'pesananDetail', 'pengiriman', 'buktiPembayaran', 'buktiPenerimaan', 'tanggal'));
    }

    public function konfirmasiPembayaran(Request $request)
    {
        $buktiPembayaranId = $request->input('bukti_pembayaran_id');
        $status = $request->input('status');

        BuktiPembayaran::where('id_bukti', $buktiPembayaranId)->update(['konfirmasi' => $status]);
 
        return redirect()->back()->with('message', 'Status pembayaran telah diperbarui.')->with('alert_class', 'success');
    }

    public function bukti(Request $request)
    {
        $id_pesanan = $request->input('id_pesanan');

        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg',
        ]);

        $file = $request->file('foto');
        $name = 'Bukti_' . date('Ymdhis') . '.' . $request->file('foto')->getClientOriginalExtension();

        $resize_foto = Image::make($file->getRealPath());
        $resize_foto->resize(500, 500, function($constraint){
            $constraint->aspectRatio();
        })->save('images/buktipenerimaan/' . $name);

        $buktiPenerimaan = new BuktiPenerimaan();
        $buktiPenerimaan->id_pesanan = $id_pesanan;
        $buktiPenerimaan->foto = $name;
        $buktiPenerimaan->save();
        return redirect()->back()->with('message', 'Bukti Penerimaan telah disimpan.')->with('alert_class', 'success');
    }

    public function updateStatus(Request $request)
    {
        $pesananId = $request->input('pesanan_id');
        $status = $request->input('status');

        Pesanan::where('id_pesanan', $pesananId)->update(['status' => $status]);

        return redirect()->back()->with('message', 'Status pesanan telah diperbarui.')->with('alert_class', 'success');
    }

    public function downloadPesanan()
    {
        $pesanan = Pesanan::get();
        $pengiriman = Pengiriman::whereIn('id_pesanan', $pesanan->pluck('id_pesanan'))->get();
        
        $pdf = PDF::loadview('pdf-pesanan', compact('pesanan', 'pengiriman'));
        $pdf->setPaper('F4', 'landscape');
        return $pdf->stream('data-invoicepesanan.pdf');
    }

    public function downloadPesananDetail()
    {
        $pesananDetail = PesananDetail::get();
        $pdf = PDF::loadview('pdf-pesanandetail', compact('pesananDetail'));
        $pdf->setPaper('F4', 'landscape');
        return $pdf->stream('data-produkonlineterjual.pdf');
    }
}
