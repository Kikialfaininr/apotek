<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\Models\Penjualan;
use App\Models\Pesanan;
use App\Models\PenjualanDetail;
use App\Models\PesananDetail;
use App\Models\Produk;
use Redirect;
use Session;
use PDF;
use Image;

class AdminLaporankeuanganController extends Controller
{
    public function index(Request $request)
    {
        $tanggal = $request->input('tanggal');
        $bulanTerpilih = $request->input('bulan');
        $penjualanDetail = PenjualanDetail::query();
        $pesananDetail = PesananDetail::query();
 
        if ($tanggal) {
            $penjualanDetail = $penjualanDetail->whereDate('updated_at', $tanggal);
            $pesananDetail = $pesananDetail->whereDate('updated_at', $tanggal);
        } elseif ($bulanTerpilih) {
            $penjualanDetail = $penjualanDetail->whereMonth('updated_at', $bulanTerpilih);
            $pesananDetail = $pesananDetail->whereMonth('updated_at', $bulanTerpilih);
        }

        $penjualanDetail = $penjualanDetail->get();
        
        // Menambahkan kriteria status 'Selesai' pada pesananDetail
        $pesananDetail = $pesananDetail->whereHas('pesanan', function($query){
            $query->where('status', 'Selesai');
        })->get();

        // Menggabungkan dua kumpulan data menggunakan merge
        $mergedDetail = $penjualanDetail->merge($pesananDetail);

        // Menggunakan Collection untuk mengurutkan hasil berdasarkan waktu
        $mergedDetail = $mergedDetail->sortBy('updated_at');

        // Mendapatkan daftar bulan
        $bulanList = $this->getMonthList();

        return view('admin-laporankeuangan', compact('mergedDetail', 'tanggal', 'bulanList', 'bulanTerpilih'));
    }

    private function getMonthList()
    {
        return [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        ];
    }

    public function downloadlaporankeuangan()
    {
        $penjualanDetail = PenjualanDetail::query();
        $pesananDetail = PesananDetail::query();

        $penjualanDetail = $penjualanDetail->get();
        
        $pesananDetail = $pesananDetail->whereHas('pesanan', function($query){
            $query->where('status', 'Selesai');
        })->get();

        // Menggabungkan dua kumpulan data menggunakan merge
        $mergedDetail = $penjualanDetail->merge($pesananDetail);

        // Menggunakan Collection untuk mengurutkan hasil berdasarkan waktu
        $mergedDetail = $mergedDetail->sortBy('updated_at');

        $pdf = PDF::loadview('pdf-laporankeuangan', compact('mergedDetail'));
        $pdf->setPaper('F4', 'landscape');
        return $pdf->stream('data-laporankeuangan.pdf');
    }

    public function laporankeuanganbulanan(Request $request)
    {
        $bulan = $request->input('bulan');

        $penjualanDetail = PenjualanDetail::query();
        $pesananDetail = PesananDetail::query();

        $penjualanDetail = $penjualanDetail->whereMonth('updated_at', $bulan)->get();
        
        $pesananDetail = $pesananDetail->whereHas('pesanan', function($query) use ($bulan){
            $query->where('status', 'Selesai')->whereMonth('updated_at', $bulan);
        })->get();

        // Menggabungkan dua kumpulan data menggunakan merge
        $mergedDetail = $penjualanDetail->merge($pesananDetail);

        // Menggunakan Collection untuk mengurutkan hasil berdasarkan waktu
        $mergedDetail = $mergedDetail->sortBy('updated_at');

        $namaBulan = \Carbon\Carbon::createFromFormat('m', $bulan)->format('F');
        $namaFile = 'data-laporankeuangan_' . $namaBulan . '.pdf';

        $pdf = PDF::loadview('pdf-laporanbulanankeuangan', compact('mergedDetail', 'bulan'));
        $pdf->setPaper('F4', 'landscape');
        return $pdf->stream($namaFile);
    }
}

