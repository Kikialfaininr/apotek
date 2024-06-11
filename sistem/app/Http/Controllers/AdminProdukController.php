<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\PenjualanDetail;
use App\Models\PesananDetail;
use App\Models\Kasir;
use Redirect;
use Session;
use PDF;
use Image;

class AdminProdukController extends Controller
{
    public function index()
    {
        $kategori = Kategori::all();
        $produk = Produk::with('kategori')->orderBy('updated_at', 'DESC')->get();
        
        return view('admin-produk', compact('produk', 'kategori'));
    }

    public function tambah()
    {
        $kategori = kategori::all();

        return view('admin-produk', compact('kategori'));
    }

    public function simpan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'unique:produk',
            'id_kategori' => 'required',
            'foto' => 'mimes:jpg,jpeg,png',
            'stok' => 'required|numeric|min:0',
        ], [
            'nama.unique' => 'Gagal menyimpan data karena data sudah ada.',
            'id_kategori.required' => 'Isikan kategori obat!',
            'stok.min' => 'Stok tidak boleh kurang dari 0!',
        ]);
    
        if ($validator->fails()) {
            return redirect('/admin-produk')->with([
                'message' => $validator->errors()->first(),
                'alert_class' => 'danger'
            ]);
        }

        $file = $request->file('foto');
        $name = 'FT'.date('Ymdhis').'.'.$request->file('foto')->getClientOriginalExtension();

        $resize_foto = Image::make($file->getRealPath());
        $resize_foto->resize(200, 200, function($constraint){
            $constraint->aspectRatio();
        })->save('images/fotoproduk/'.$name);

        $produk = new produk();
            $produk->foto = $name;
            $produk->nama = $request->nama;
            $produk->bentuk_sediaan = $request->bentuk_sediaan;
            $produk->satuan = $request->satuan;
            $produk->stok = $request->stok;
            $produk->harga_beli = $request->harga_beli;
            $produk->harga_jual = $request->harga_jual;
            $produk->id_kategori = $request->id_kategori;
        $produk->save();
        return redirect('/admin-produk')->with('message', 'Data berhasil ditambah')->with('alert_class', 'success');      
    }

    public function edit(Request $request, $id)
    {
        $produk = produk::where('id_produk',$id)->first();
        return view('produk-edit', compact('produk'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'id_kategori' => 'required',
            'foto' => 'mimes:jpg,jpeg,png',
            'stok' => 'required|numeric|min:0',
        ], [
            'id_kategori.required' => 'Isikan kategori obat!',
            'stok.min' => 'Stok tidak boleh kurang dari 0!',
        ]);
    
        if ($validator->fails()) {
            return redirect('/admin-produk')->with([
                'message' => $validator->errors()->first(),
                'alert_class' => 'danger'
            ]);
        }

        $file = $request->file('foto');
        $name = 'FT'.date('Ymdhis').'.'.$request->file('foto')->getClientOriginalExtension();

        $resize_foto = Image::make($file->getRealPath());
        $resize_foto->resize(200, 200, function($constraint){
            $constraint->aspectRatio();
        })->save('images/fotoproduk/'.$name);

        $produk = produk::where('id_produk', $id)->first();
            $produk->foto = $name;
            $produk->nama = $request->nama;
            $produk->bentuk_sediaan = $request->bentuk_sediaan;
            $produk->satuan = $request->satuan;
            $produk->stok = $request->stok;
            $produk->harga_beli = $request->harga_beli;
            $produk->harga_jual = $request->harga_jual;
            $produk->id_kategori = $request->id_kategori;
        $produk->save();
        return redirect('/admin-produk')->with('message', 'Data berhasil diubah')->with('alert_class', 'success');
    }

    public function hapus(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);
        $kasirCount = $produk->kasir()->count();
        $penjualanDetailCount = $produk->penjualandetail()->count();
        $pesananDetailCount = $produk->pesanandetail()->count();

        if ($kasirCount > 0 || $penjualanDetailCount > 0 || $pesananDetailCount > 0) {
            return redirect('/admin-produk')->with('error', 'Data tidak dapat dihapus karena masih terdapat transaksi yang terkait.');
        }

        $produk->delete();
        return redirect('/admin-produk')->with('message', 'Data berhasil dihapus')->with('alert_class', 'success');
    }

    public function downloadpdf()
    {
        $produk = produk::get();
        $pdf = PDF::loadview('pdf-produk', compact('produk'));
        $pdf->setPaper('F4', 'landscape');
        return $pdf->stream('dataproduk.pdf');
    }
}
