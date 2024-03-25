@extends('layouts.app-admin')

@section('content')
<div class="dashboard">
    <div class="card card-dashboard text-white bg-danger">
        <div class="card-body">
            <h2 class="card-title" id="onlineOrders">0</h2>
            <p class="card-text">Pesanan Online Masuk</p>
            <i class="fa fa-bell" aria-hidden="true"></i>
        </div>
        <div class="card-footer text-muted">
            <a href="#">Info lebih lanjut <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
        </div>
    </div>
    <div class="card card-dashboard text-white bg-success">
        <div class="card-body">
            <h2 class="card-title" id="totalOnlineOrders">0</h2>
            <p class="card-text">Pesanan Online</p>
            <i class="fa fa-shopping-cart"></i>
        </div>
        <div class="card-footer text-muted">
            <a href="#">Info lebih lanjut <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
        </div>
    </div>
    <div class="card card-dashboard text-white bg-primary">
        <div class="card-body">
            <h2 class="card-title" id="directSales">0</h2>
            <p class="card-text">Penjualan Langsung</p>
            <i class="fas fa-cash-register"></i>
        </div>
        <div class="card-footer text-muted">
            <a href="#">Info lebih lanjut <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
        </div>
    </div>
    <div class="card card-dashboard text-white bg-warning">
        <div class="card-body">
            <h2 class="card-title" id="totalRevenue">0</h2>
            <p class="card-text">Total Pendapatan</p>
            <i class="fa fa-dollar-sign"></i>
        </div>
        <div class="card-footer">
            <a href="#">Info lebih lanjut <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
        </div>
    </div>

    <div class="chart text-center">
        <h2>Penjualan Langsung Per Hari</h2>
        <canvas id="directSalesChart"></canvas>
    </div>
    <div class="chart text-center">
        <h2>Pemesanan Online per Hari</h2>
        <canvas id="onlineOrdersChart"></canvas>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="sistem/script.js"></script>
@endsection