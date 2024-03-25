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

class AdminStokController extends Controller
{
    public function index(Request $request)
    {
        $kategori = Kategori::all();
        $query = Produk::query();

        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('nama', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('bentuk_sediaan', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('satuan', 'LIKE', '%' . $searchTerm . '%')
                ->orWhereHas('kategori', function ($q) use ($searchTerm) {
                        $q->where('nama_kategori', 'LIKE', '%' . $searchTerm . '%');
                });
            });
        }

        $produk = $query->with('kategori')->orderBy('created_at', 'DESC')->paginate(10);
        
        return view('admin-stok', compact('produk', 'kategori', 'request'));
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
