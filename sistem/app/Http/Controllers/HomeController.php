<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\Pesanan;
use App\Models\PenjualanDetail;
use App\Models\PesananDetail;
use App\Models\Produk;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        // 1. Jumlah "Pesanan online masuk" dengan total data tabel "Pesanan" dimana status = NULL
        $pesananMasukCount = Pesanan::whereNull('status')->count();
     
        // 2. Jumlah "Pesanan Online" dengan total data tabel "Pesanan" dimana status = Selesai
        $pesananSelesaiCount = Pesanan::where('status', 'Selesai')->count();
     
        // 3. Jumlah "Penjualan Langsung" dengan data tabel "Penjualan"
        $penjualanLangsungCount = Penjualan::count();
     
        // 4. Jumlah "Total Pendapatan" dengan data total "grand_total" pada tabel "Penjualan" dan pada tabel "Pesanan" dimana jika dalam pesanan hanya hitung yang statusnya = "Selesai"
        $totalPendapatan = Penjualan::sum('grand_total') + Pesanan::where('status', 'Selesai')->sum('grand_total');
     
        // 5. Mengambil data pendapatan per hari untuk bulan yang sedang berlangsung
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
     
        // Pendapatan dari Penjualan
        $revenuesPenjualan = Penjualan::whereMonth('updated_at', $currentMonth)
                                       ->whereYear('updated_at', $currentYear)
                                       ->selectRaw('DATE(updated_at) as date, SUM(grand_total) as total')
                                       ->groupBy('date')
                                       ->get();
     
        // Pendapatan dari Pesanan dengan status "Selesai"
        $revenuesPesanan = Pesanan::whereMonth('updated_at', $currentMonth)
                                   ->whereYear('updated_at', $currentYear)
                                   ->where('status', 'Selesai')
                                   ->selectRaw('DATE(updated_at) as date, SUM(grand_total) as total')
                                   ->groupBy('date')
                                   ->get();
     
        // Menggabungkan data pendapatan dari Penjualan dan Pesanan
        $datesCurrentMonth = [];
        $revenuesCurrentMonthPenjualan = [];
        $revenuesCurrentMonthPesanan = [];
     
        foreach ($revenuesPenjualan as $revenue) {
            $datesCurrentMonth[] = $revenue->date;
            $revenuesCurrentMonthPenjualan[] = $revenue->total; 
        }
     
        foreach ($revenuesPesanan as $revenue) {
            $revenuesCurrentMonthPesanan[] = $revenue->total;
        }
     
        return view('home', [
            'pesananMasukCount' => $pesananMasukCount,
            'pesananSelesaiCount' => $pesananSelesaiCount,
            'penjualanLangsungCount' => $penjualanLangsungCount,
            'totalPendapatan' => $totalPendapatan,
            'datesCurrentMonth' => $datesCurrentMonth,
            'revenuesCurrentMonthPenjualan' => $revenuesCurrentMonthPenjualan,
            'revenuesCurrentMonthPesanan' => $revenuesCurrentMonthPesanan
        ]);
    }
}