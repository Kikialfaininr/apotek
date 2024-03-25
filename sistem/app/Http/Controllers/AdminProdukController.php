<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\PenjualanDetail;
use App\Models\Kasir;
use Redirect;
use Session;
use PDF;
use Image;

class AdminProdukController extends Controller
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
        
        return view('admin-produk', compact('produk', 'kategori', 'request'));
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
            $request->session()->flash('gagal', $validator->errors()->first());
            return Redirect::back()->withInput();
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
        Session::flash('sukses','Data berhasil ditambah');
        return Redirect('/admin-produk');      
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
            $request->session()->flash('gagal', $validator->errors()->first());
            return Redirect::back()->withInput();
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
        Session::flash('sukses', 'Data berhasil diubah');
        return Redirect('/admin-produk');
    }

    public function hapus(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);
        $kasirCount = $produk->kasir()->count();
        $penjualanDetailCount = $produk->penjualandetail()->count();

        if ($kasirCount > 0 || $penjualanDetailCount > 0) {
            Session::flash('gagal', 'Data tidak dapat dihapus karena masih terdapat transaksi yang terkait.');
            return redirect('/admin-produk');
        }

        $produk->delete();
        Session::flash('sukses','Data berhasil dihapus');
        return redirect('/admin-produk');
    }

    public function downloadpdf()
    {
        $produk = produk::get();
        $pdf = PDF::loadview('pdf-produk', compact('produk'));
        $pdf->setPaper('F4', 'landscape');
        return $pdf->stream('dataproduk.pdf');
    }
}
