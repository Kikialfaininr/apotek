<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\Models\Produk;
use App\Models\Kategori;
use Redirect;
use Session;
use PDF;
use Image;

class AdminLaporanstokController extends Controller
{
    public function index(Request $request)
    {
        $kategori = Kategori::all();
        $produk = Produk::with('kategori')->orderBy('updated_at', 'DESC')->get();
        
        return view('admin-laporanstok', compact('produk', 'kategori'));
    }

    public function downloadlaporanstok()
    {
        $produk = Produk::get();
        $pdf = PDF::loadview('pdf-stokopname', compact('produk'));
        $pdf->setPaper('F4', 'landscape');
        return $pdf->stream('data-stokopname.pdf');
    }

    public function downloadstokhabis()
    {
        $produk = Produk::get();
        $pdf = PDF::loadview('pdf-stokhabis', compact('produk'));
        $pdf->setPaper('F4', 'landscape');
        return $pdf->stream('data-stokhabis.pdf');
    }

    public function downloadstokmenipis()
    {
        $produk = Produk::get();
        $pdf = PDF::loadview('pdf-stokmenipis', compact('produk'));
        $pdf->setPaper('F4', 'landscape');
        return $pdf->stream('data-stokmenipis.pdf');
    }
}

