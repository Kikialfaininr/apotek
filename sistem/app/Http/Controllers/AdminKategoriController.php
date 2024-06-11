<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use App\Models\Kategori;
use Redirect;
use Session;
use PDF;

class AdminKategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::orderBy('updated_at', 'DESC')->get();
        
        return view('admin-kategori', compact('kategori'));
    }

    
    public function simpan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'unique:kategori',
        ], [
            'nama_kategori.unique' => 'Gagal menyimpan data karena data sudah ada.',
        ]);

        if ($validator->fails()) {
            return redirect('/admin-kategori')->with([
                'message' => $validator->errors()->first(),
                'alert_class' => 'danger'
            ]);
        }

        $kategori = new kategori();
            $kategori->nama_kategori = $request->nama_kategori;
        $kategori->save();
        return redirect('/admin-kategori')->with('message', 'Data berhasil ditambah')->with('alert_class', 'success');      
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
        return redirect('/admin-kategori')->with('message', 'Data berhasil diubah')->with('alert_class', 'success');
    }

    public function hapus(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);
        $produkCount = $kategori->produk()->count();

        if ($produkCount > 0) {
            return redirect('/admin-kategori')->with('error', 'Data tidak dapat dihapus karena masih terdapat produk yang terkait dengan kategori ini.');
        }

        $kategori->delete();
        return redirect('/admin-kategori')->with('message', 'Data berhasil dihapus')->with('alert_class', 'success');
    }

    public function downloadpdf()
    {
        $kategori = kategori::get();
        $pdf = PDF::loadview('pdf-kategori', compact('kategori'));
        $pdf->setPaper('F4', 'potrait');
        return $pdf->stream('datakategori.pdf');
    }
}
