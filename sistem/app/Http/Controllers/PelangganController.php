<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Pelanggan;
use App\Models\Pesanan;
use App\Models\PesananDetail;
use App\Models\Produk;
use App\Models\Pengiriman;
use App\Models\BuktiPembayaran;
use App\Models\BuktiPenerimaan;
use Hash;
use Redirect;
use Session;
use PDF;
use Image;

class PelangganController extends Controller
{
    public function index(Request $request)
    {
        $pelanggan = Pelanggan::where('id', auth()->user()->id)->get();
        $tanggal = $request->input('tanggal');
        $pesananOnline = Pesanan::where('id', auth()->user()->id);

        if ($tanggal) {
            $pesananOnline->whereDate('updated_at', $tanggal);
        }

        $pesanan = $pesananOnline->orderBy('updated_at', 'desc')->get();

        $pesananDetail = PesananDetail::whereIn('id_pesanan', $pesanan->pluck('id_pesanan'))->get();
        $pengiriman = Pengiriman::whereIn('id_pesanan', $pesanan->pluck('id_pesanan'))->get();
        $buktiPembayaran = BuktiPembayaran::whereIn('id_pesanan', $pesanan->pluck('id_pesanan'))->get();
        $buktiPenerimaan = BuktiPenerimaan::whereIn('id_pesanan', $pesanan->pluck('id_pesanan'))->get();

        return view('/pelanggan', compact('pelanggan', 'pesanan', 'pesananDetail', 'pengiriman', 'buktiPembayaran', 'buktiPenerimaan', 'tanggal'));
    }

    public function edit(Request $request, $id)
    {
        $pelanggan = pelanggan::where('id', $id)->first();
        return view('pelanggan-edit', compact('pelanggan'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:users,name,'.$id,
            'foto' => 'sometimes|mimes:jpg,jpeg,png|max:2048',
        ], [
            'name.unique' => 'Username sudah ada',
        ]);

        if ($validator->fails()) {
            $request->session()->flash('gagal', $validator->errors()->first());
            return Redirect::back()->withInput();
        }

        $pelanggan = Pelanggan::find($id);
        $pelanggan->name = $request->name;
        $pelanggan->fullname = $request->fullname;
        $pelanggan->email = $request->email;
        $pelanggan->alamat = $request->alamat;
        $pelanggan->nomor_tlp = $request->nomor_tlp;

        if ($request->filled('password')) {
            $pelanggan->password = Hash::make($request->password);
        }

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            if ($file) {
                $name = 'Profil'.date('Ymdhis').'.'.$file->getClientOriginalExtension();

                $resize_foto = Image::make($file->getRealPath());
                $resize_foto->resize(200, 200, function($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('images/fotoprofil/'.$name));

                $pelanggan->foto = $name;
            }
        }

        $pelanggan->save();

        Session::flash('sukses', 'Data berhasil diubah');
        return Redirect('/pelanggan');
    }
}