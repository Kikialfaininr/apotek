<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk; 
use App\Models\Kasir; 
use App\Models\Penjualan; 
use App\Models\PenjualanDetail; 
use Redirect;
use Session;
use PDF;

class KasirController extends Controller
{
    public function index(Request $request) 
    {
        $produk = Produk::orderBY('nama', 'asc')->get();
        $kasir = Kasir::all();

        return view('kasir', compact('produk', 'kasir'));
    }

    public function submit(Request $request)
    {
        $id_produk = $request->id_produk;

        // Mencari informasi produk
        $produk = Produk::find($id_produk);

        // Memastikan stok produk mencukupi sebelum menambahkan ke keranjang belanja
        if ($produk->stok < 1) {
            return redirect('/kasir')->with('error', 'Stok produk tidak mencukupi');
        }

        // Mencari apakah produk dengan id_produk yang sama sudah ada dalam tabel kasir
        $existing_kasir = Kasir::where('id_produk', $id_produk)->first();

        if ($existing_kasir) {
            // Jika produk sudah ada, tambahkan qty
            $existing_kasir->qty += 1;
            $existing_kasir->save();
            Session()->flash('message', 'Kuantitas produk berhasil ditambahkan');
            Session()->flash('alert_class', 'warning');
        } else {
            // Jika produk belum ada, buat yang baru
            $kasir = new Kasir();
                $kasir->id_produk = $id_produk;
                $kasir->qty = 1;
                $kasir->total = $produk->harga_jual;
            $kasir->save();
            Session()->flash('message', 'Transaksi berhasil ditambah');
            Session()->flash('alert_class', 'success');
        }

        return Redirect('/kasir'); 
    }
 

    public function changeQuantity(Request $request)
    {
        $id_produk = $request->input('id_produk');
        $action = $request->input('act');

        // Mencari produk dalam keranjang belanja
        $kasir = Kasir::where('id_produk', $id_produk)->first();

        if (!$kasir) {
            // Jika produk tidak ditemukan dalam keranjang belanja
            return redirect('/kasir')->with('error', 'Produk tidak ditemukan dalam keranjang belanja');
        }

        // Mengambil informasi stok produk
        $produk = Produk::find($id_produk);

        // Mengubah kuantitas berdasarkan aksi yang diberikan
        if ($action === 'minus' && $kasir->qty > 1) {
            // Memastikan stok mencukupi sebelum mengurangi kuantitas
            if ($produk->stok >= 1) {
                $kasir->qty -= 1;
                $produk->stok += 1; // Mengembalikan satu item ke stok
            } else {
                return redirect('/kasir')->with('error', 'Stok produk tidak mencukupi');
            }
        } elseif ($action === 'plus') {
            // Memastikan stok mencukupi sebelum menambah kuantitas
            if ($produk->stok > $kasir->qty) {
                $kasir->qty += 1;
                $produk->stok -= 1; // Mengurangi satu item dari stok
            } else {
                return redirect('/kasir')->with('error', 'Stok produk tidak mencukupi');
            }
        }

        // Mengupdate total berdasarkan kuantitas yang baru
        $kasir->total = $kasir->qty * $kasir->produk->harga_jual;
        $kasir->save();
        $produk->save();

        if ($action === 'minus') {
            Session::flash('message', 'Kuantitas produk berhasil dikurangi');
        } elseif ($action === 'plus') {
            Session::flash('message', 'Kuantitas produk berhasil ditambahkan');
        }
        Session::flash('alert_class', 'success');

        // Redirect kembali ke halaman kasir
        return redirect('/kasir');
    }


    public function hapus(Request $request, $id)
    {
        $kasir = Kasir::where('id_kasir',$id);
        $kasir->delete();
        Session()->flash('message', 'Transaksi berhasil dihapus');
        Session()->flash('alert_class', 'success');
        return Redirect('/kasir');
    }

    public function simpan(Request $request)
    {
        // Hitung total kasir
        $total_kasir = Kasir::sum('total');

        // Buat pesanan baru
        $penjualan = new Penjualan();
        $penjualan->no_order = 'OD-' . date('Ymd') . rand(1111, 9999);
        $penjualan->nama_kasir = 'Kasir 1';
        $penjualan->grand_total = $total_kasir; 
        $penjualan->pembayaran = $request->input('pembayaran'); 
        $penjualan->kembalian = $penjualan->pembayaran - $total_kasir;
        $penjualan->metode_pembayaran = $request->input('metode_pembayaran'); 
        $penjualan->save();
        
        // Dapatkan item kasir
        $kasir = Kasir::get();

        foreach ($kasir as $key => $value) {
            // Buat entri produk pesanan
            $produk = [
                'id_penjualan' => $penjualan->id_penjualan,
                'id_produk' => $value->id_produk,
                'qty' => $value->qty,
                'total' => $value->total,
                'created_at' => now(),
                'updated_at' => now()
            ];

            PenjualanDetail::insert($produk);

            // Perbarui stok produk
            $produk = Produk::find($value->id_produk);
            $produk->stok -= $value->qty;
            $produk->save();

            // Hapus entri kasir
            $deleteKasir = Kasir::where('id_kasir', $value->id_kasir)->delete();
        }

        // Tampilkan pesan sukses
        Session()->flash('message', 'Transaksi berhasil disimpan');
        Session()->flash('alert_class', 'success');

        $request->session()->forget('kasir');

        return redirect('/kasir-invoice/' . $penjualan->id_penjualan);
        return redirect('/kasir');
    }

    public function invoice(Request $request, $id)
    {
        $invoice = Penjualan::with('PenjualanDetail')->where('id_penjualan', $id)->first();

        return view ('kasir-invoice', compact('invoice'));
    }

}
