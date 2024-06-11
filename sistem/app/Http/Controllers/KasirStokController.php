<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Produk;
use App\Models\Kategori;
use Redirect;
use Session;
use PDF;
use Image;

class KasirStokController extends Controller
{
    public function index(Request $request)
    {
        $kategori = Kategori::all();
        $produk = Produk::with('kategori')->orderBy('updated_at', 'DESC')->get();
        
        return view('kasir-stokproduk', compact('produk', 'kategori'));
    }

    public function downloadpdf()
    {
        $produk = produk::get();
        $pdf = PDF::loadview('pdf-produk', compact('produk'));
        $pdf->setPaper('F4', 'landscape');
        return $pdf->stream('dataproduk.pdf');
    }
}
