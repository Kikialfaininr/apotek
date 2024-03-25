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
        $penjualanDetail = PenjualanDetail::query();
        $pesananDetail = PesananDetail::query();

        if ($tanggal) {
            $penjualanDetail = $penjualanDetail->whereDate('created_at', $tanggal);
            $pesananDetail = $pesananDetail->whereDate('created_at', $tanggal);
        } elseif ($bulanTerpilih) {
            $penjualanDetail = $penjualanDetail->whereMonth('created_at', $bulanTerpilih);
            $pesananDetail = $pesananDetail->whereMonth('created_at', $bulanTerpilih);
        }

        $penjualanDetail = $penjualanDetail->get();
        
        // Menambahkan kriteria status 'Selesai' pada pesananDetail
        $pesananDetail = $pesananDetail->whereHas('pesanan', function($query){
            $query->where('status', 'Selesai');
        })->get();

        // Menggabungkan dua kumpulan data menggunakan merge
        $mergedDetail = $penjualanDetail->merge($pesananDetail);

        // Menggunakan Collection untuk mengurutkan hasil berdasarkan waktu
        $mergedDetail = $mergedDetail->sortBy('created_at');

        // Jika ingin menggunakan paginasi, bisa menggunakan paginate() setelah merge
        $perPage = 10;
        $currentPage = \Illuminate\Pagination\Paginator::resolveCurrentPage();
        $currentPageItems = $mergedDetail->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $mergedDetail = new LengthAwarePaginator($currentPageItems, count($mergedDetail), $perPage, $currentPage, ['path' => LengthAwarePaginator::resolveCurrentPath()]);

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
        $mergedDetail = $penjualanDetail->merge($pesananDetail);

        // Menggunakan Collection untuk mengurutkan hasil berdasarkan waktu
        $mergedDetail = $mergedDetail->sortBy('created_at');

        $pdf = PDF::loadview('pdf-laporanpenjualan', compact('mergedDetail'));
        $pdf->setPaper('F4', 'landscape');
        return $pdf->stream('data-laporanpenjualan.pdf');
    }
}