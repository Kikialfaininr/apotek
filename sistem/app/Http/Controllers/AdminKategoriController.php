<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Kategori;
use Redirect;
use Session;
use PDF;

class AdminKategoriController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('search')) {
            $kategori = Kategori::where('nama_kategori', 'LIKE', '%' . $request->search . '%')->paginate(10);
        } else {
            $kategori = Kategori::orderBy('created_at', 'DESC')->paginate(10);
        }
        return view('admin-kategori', compact('kategori', 'request'));
    }

    public function simpan(Request $request)
    {
        $this->validate($request, [
            'nama_kategori' => 'unique:kategori',
        ], [
            Session::flash('gagal', 'Gagal menyimpan data karena data sudah ada.'),
        ]);

        $kategori = new kategori();
            $kategori->nama_kategori = $request->nama_kategori;
        $kategori->save();
        Session::flash('sukses','Data berhasil ditambah');
        return Redirect('/admin-kategori');      
    }

    public function edit(Request $request, $id)
    {
        $kategori = kategori::where('id_kategori',$id)->first();
        return view('kategori-edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $kategori = kategori::where('id_kategori', $id)->first();
        $kategori->nama_kategori = $request->nama_kategori;
        $kategori->save();
        Session::flash('sukses', 'Data berhasil diubah');
        return Redirect('/admin-kategori');
    }

    public function hapus(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);
        $produkCount = $kategori->produk()->count();

        if ($produkCount > 0) {
            Session::flash('gagal', 'Data tidak dapat dihapus karena masih terdapat produk yang terkait dengan kategori ini.');
            return redirect('/admin-kategori');
        }

        $kategori->delete();
        
        Session::flash('sukses','Data berhasil dihapus');
        return redirect('/admin-kategori');
    }

    public function downloadpdf()
    {
        $kategori = kategori::get();
        $pdf = PDF::loadview('pdf-kategori', compact('kategori'));
        $pdf->setPaper('F4', 'potrait');
        return $pdf->stream('datakategori.pdf');
    }
}
