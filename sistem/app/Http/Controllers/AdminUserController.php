<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggan;
use Redirect;
use Session;
use Hash;
use DB;
use PDF;

class AdminUserController extends Controller
{
    public function index()
    {
        $pelanggan = Pelanggan::orderBy('updated_at', 'DESC')->get();
        
        return view('admin-datauser', compact('pelanggan'));
    }

    public function downloadpdf()
    {
        $pelanggan = Pelanggan::get();
        $pdf = PDF::loadview('pdf-datapelanggan', compact('pelanggan'));
        $pdf->setPaper('F4', 'landscape');
        return $pdf->stream('Data pelanggan online.pdf');
    }
}