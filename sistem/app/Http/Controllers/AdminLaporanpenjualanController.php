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
use Carbon\Carbon;
use Redirect;
use Session;
use PDF;
use Image;

class AdminLaporanpenjualanController extends Controller
{

    public function index(Request $request)
    {
        $tanggal = $request->input('tanggal');
        $bulanTerpilih = $request->input('bulan');
        $penjualanDetailQuery = PenjualanDetail::query();
        $pesananDetailQuery = PesananDetail::query();

        // Filter berdasarkan tanggal atau bulan yang dipilih
        if ($tanggal) {
            $penjualanDetailQuery->whereDate('updated_at', $tanggal);
            $pesananDetailQuery->whereDate('updated_at', $tanggal);
        } elseif ($bulanTerpilih) {
            $penjualanDetailQuery->whereMonth('updated_at', $bulanTerpilih);
            $pesananDetailQuery->whereMonth('updated_at', $bulanTerpilih);
        }

        // Mengambil hasil query
        $penjualanDetail = $penjualanDetailQuery->get();

        // Menambahkan kriteria status 'Selesai' pada pesananDetail
        $pesananDetail = $pesananDetailQuery->whereHas('pesanan', function($query) {
            $query->where('status', 'Selesai');
        })->get();

        // Menggabungkan dua kumpulan data menggunakan concat
        $mergedDetail = $penjualanDetail->concat($pesananDetail);

        // Mengurutkan hasil berdasarkan updated_at
        $mergedDetail = $mergedDetail->sortBy(function($detail) {
            return $detail->updated_at;
        })->values(); // Memastikan koleksi diindeks ulang

        // Mendapatkan daftar bulan
        $bulanList = $this->getMonthList();

        return view('admin-laporanpenjualan', compact('mergedDetail', 'tanggal', 'bulanList', 'bulanTerpilih'));
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

    public function downloadlaporanpenjualan()
    {
        $penjualanDetail = PenjualanDetail::query();
        $pesananDetail = PesananDetail::query();

        $penjualanDetail = $penjualanDetail->get();
        
        $pesananDetail = $pesananDetail->whereHas('pesanan', function($query){
            $query->where('status', 'Selesai');
        })->get();

        // Menggabungkan dua kumpulan data menggunakan merge
        $mergedDetail = $penjualanDetail->concat($pesananDetail);

        // Mengurutkan hasil berdasarkan updated_at
        $mergedDetail = $mergedDetail->sortBy(function($detail) {
            return $detail->updated_at;
        })->values(); // Memastikan koleksi diindeks ulang

        $pdf = PDF::loadview('pdf-laporanpenjualan', compact('mergedDetail'));
        $pdf->setPaper('F4', 'landscape');
        return $pdf->stream('data-laporanpenjualan.pdf');
    }

    public function laporanpenjualanbulanan(Request $request)
    {
        $bulan = $request->input('bulan');

        $penjualanDetail = PenjualanDetail::query();
        $pesananDetail = PesananDetail::query();

        $penjualanDetail = $penjualanDetail->whereMonth('updated_at', $bulan)->get();
        
        $pesananDetail = $pesananDetail->whereHas('pesanan', function($query) use ($bulan){
            $query->where('status', 'Selesai')->whereMonth('updated_at', $bulan);
        })->get();

        // Menggabungkan dua kumpulan data menggunakan merge
        $mergedDetail = $penjualanDetail->concat($pesananDetail);

        // Mengurutkan hasil berdasarkan updated_at
        $mergedDetail = $mergedDetail->sortBy(function($detail) {
            return $detail->updated_at;
        })->values(); // Memastikan koleksi diindeks ulang

        $namaBulan = \Carbon\Carbon::createFromFormat('m', $bulan)->format('F');
        $namaFile = 'data-laporanpenjualan_' . $namaBulan . '.pdf';

        $pdf = PDF::loadview('pdf-laporanbulananpenjualan', compact('mergedDetail', 'bulan'));
        $pdf->setPaper('F4', 'landscape');
        return $pdf->stream($namaFile);
    }
}