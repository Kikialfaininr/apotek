@extends('layouts.app-admin')

@section('content')
@if(auth()->check() && (auth()->user()->level == 'admin' || auth()->user()->level == 'owner'))
<div class="dashboard">
    <div class="card card-dashboard text-white bg-danger">
        <div class="card-body">
            <h2 class="card-title" id="onlineOrders">{{ $pesananMasukCount }}</h2>
            <p class="card-text">Pesanan Online Belum Terproses</p>
            <i class="fa fa-bell" aria-hidden="true"></i>
        </div>
        <div class="card-footer text-muted">
            <a href="{{url('/admin-pesanandiproses')}}">Info lebih lanjut <i class="fa fa-arrow-right"
                    aria-hidden="true"></i></a>
        </div>
    </div>
    <div class="card card-dashboard text-white bg-success">
        <div class="card-body">
            <h2 class="card-title" id="totalOnlineOrders">{{ $pesananSelesaiCount }}</h2>
            <p class="card-text">Pesanan Online</p>
            <i class="fa fa-shopping-cart"></i>
        </div>
        <div class="card-footer text-muted">
            <a href="{{url('/admin-pesananselesai')}}">Info lebih lanjut <i class="fa fa-arrow-right"
                    aria-hidden="true"></i></a>
        </div>
    </div>
    <div class="card card-dashboard text-white bg-primary">
        <div class="card-body">
            <h2 class="card-title" id="directSales">{{ $penjualanLangsungCount }}</h2>
            <p class="card-text">Penjualan Langsung</p>
            <i class="fas fa-cash-register"></i>
        </div>
        <div class="card-footer text-muted">
            <a href="{{url('/admin-penjualan')}}">Info lebih lanjut <i class="fa fa-arrow-right"
                    aria-hidden="true"></i></a>
        </div>
    </div>
    <div class="card card-dashboard text-white bg-warning">
        <div class="card-body">
            <h2 class="card-title" id="totalRevenue">Rp {{ number_format($totalPendapatan) }}</h2>
            <p class="card-text">Total Pendapatan</p>
            <i class="fa fa-dollar-sign"></i>
        </div>
        <div class="card-footer">
            <a href="{{url('/admin-laporankeuangan')}}">Info lebih lanjut <i class="fa fa-arrow-right"
                    aria-hidden="true"></i></a>
        </div>
    </div>

    <div class="chart text-center">
    <h2>Pendapatan Harian Bulan {{ \Carbon\Carbon::now()->translatedFormat('F') }}</h2>
    <canvas id="revenueChart"></canvas>
</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Menyiapkan data untuk grafik
    var datesCurrentMonth = @json($datesCurrentMonth);
    var revenuesCurrentMonthPenjualan = @json($revenuesCurrentMonthPenjualan);
    var revenuesCurrentMonthPesanan = @json($revenuesCurrentMonthPesanan);

    // Membuat grafik menggunakan Chart.js
    var ctx = document.getElementById('revenueChart').getContext('2d');
    var revenueChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: datesCurrentMonth,
            datasets: [{
                label: 'Pendapatan Penjualan Langsung',
                data: revenuesCurrentMonthPenjualan,
                borderColor: 'rgba(255, 99, 132, 1)',
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                fill: false
            }, {
                label: 'Pendapatan Pesanan Online',
                data: revenuesCurrentMonthPesanan,
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                fill: false
            }]
        },
        options: {
            scales: {
                xAxes: [{
                    type: 'time',
                    time: {
                        unit: 'day'
                    },
                    distribution: 'linear'
                }],
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script>

@else
<?php abort(403, 'Unauthorized action.'); ?>
@endif

@endsection