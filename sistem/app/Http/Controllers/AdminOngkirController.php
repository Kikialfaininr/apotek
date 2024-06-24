<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Ongkir;
use Redirect;
use Session;
use PDF;

class AdminOngkirController extends Controller
{
    public function index()
    {
        $ongkir = Ongkir::orderBy('ongkir')->get();
        
        return view('admin-ongkir', compact('ongkir'));
    }

    public function simpan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'wilayah' => 'unique:ongkir',
        ], [
            'wilayah.unique' => 'Gagal menyimpan data karena data wilayah sudah ada.',
        ]);

        if ($validator->fails()) {
            return redirect('/admin-ongkir')->with([
                'message' => $validator->errors()->first(),
                'alert_class' => 'danger'
            ]);
        }

        $ongkir = new Ongkir();
        $ongkir->wilayah = $request->wilayah;
        $ongkir->ongkir = $request->ongkir;
        $ongkir->save();
        
        return redirect('/admin-ongkir')->with([
            'message' => 'Data berhasil ditambah',
            'alert_class' => 'success'
        ]);      
    }

    public function edit(Request $request, $id)
    {
        $ongkir = Ongkir::where('id_ongkir',$id)->first();
        return view('ongkir-edit', compact('ongkir'));
    }

    public function update(Request $request, $id)
    {
        $ongkir = Ongkir::where('id_ongkir', $id)->first();
            $ongkir->wilayah = $request->wilayah;
            $ongkir->ongkir = $request->ongkir;
        $ongkir->save();
        return redirect('/admin-ongkir')->with('message', 'Data berhasil diubah')->with('alert_class', 'success');
    }

    public function hapus(Request $request, $id)
    {
        $ongkir = Ongkir::findOrFail($id);
        $pengirimanCount = $ongkir->pengiriman()->count();

        if ($pengirimanCount > 0) {
            return redirect('/admin-ongkir')->with('error', 'Data tidak dapat dihapus karena masih terdapat data pengiriman yang terkait dengan ongkir ini.');
        }

        $ongkir->delete();
        
        return redirect('/admin-ongkir')->with('message', 'Data berhasil dihapus')->with('alert_class', 'success');
    }

    public function downloadpdf()
    {
        $ongkir = Ongkir::get();
        $pdf = PDF::loadview('pdf-ongkir', compact('ongkir'));
        $pdf->setPaper('F4', 'potrait');
        return $pdf->stream('dataongkir.pdf');
    }
}
