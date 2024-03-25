<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Produk;
use Redirect;
use Session;
use PDF;
use Image;

class AdminPenjualanController extends Controller
{
    public function index(Request $request)
    {
        $tanggal = $request->input('tanggal');
        $penjualan = Penjualan::query();
        $penjualanDetail = PenjualanDetail::query();

        if ($tanggal) {
            $penjualan = $penjualan->whereDate('created_at', $tanggal);
            $penjualanDetail = $penjualanDetail->whereDate('created_at', $tanggal);
        }

        $penjualan = $penjualan->paginate(10);
        $penjualanDetail = $penjualanDetail->paginate(10);

        return view('/admin-penjualan', compact('penjualan', 'penjualanDetail', 'tanggal'));
    }

    public function downloadinvoice()
    {
        $penjualan = Penjualan::get();
        $pdf = PDF::loadview('pdf-invoicepenjualan', compact('penjualan'));
        $pdf->setPaper('F4', 'landscape');
        return $pdf->stream('data-invoicepenjualan.pdf');
    }

    public function downloadprodukterjual()
    {
        $penjualanDetail = PenjualanDetail::get();
        $pdf = PDF::loadview('pdf-produkterjual', compact('penjualanDetail'));
        $pdf->setPaper('F4', 'landscape');
        return $pdf->stream('data-produkterjual.pdf');
    }
}
