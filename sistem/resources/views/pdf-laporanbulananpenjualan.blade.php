<style>
table,
th,
td {
    border: 1px solid black;
    border-collapse: collapse;
    padding: 10px;
}

.text-kop {
    text-align: center;
    line-height: 0.3;
}
</style>
<div class="container" align="center">
    <div class="row">
        <h4 class="text-center text-kop">APOTEK DUA FARMA</h4>
        <h5 class="text-center text-kop">Jalan Jendral Sudirman No. 6A RT 01 RW 09 Planjan, Kecamatan Kesugihan, 53274
        </h5>
        <h4 class="text-center text-kop">CILACAP</h4>
        <hr><br>
        <h3 class="text-center">LAPORAN PENJUALAN <br> <u style="text-decoration: none; border-bottom: 2px solid black;">PERIODE {{ strtoupper(\Carbon\Carbon::createFromFormat('mY', $bulan . date('Y'))->translatedFormat('F Y')) }}</u></h3>
    </div>
</div>
<table id="kategori" class="table table-responsive table-bordered table-hover table-striped" style="width: 100%;">
    <thead>
        <tr>
            <th class="text-center">No</th>
            <th class="text-center">Waktu</th>
            <th class="text-center">No Order</th>
            <th class="text-center">Produk</th>
            <th class="text-center">Harga</th>
            <th class="text-center">QTY</th>
            <th class="text-center">Total</th>
        </tr>
    </thead>
    <tbody>
        @if(isset($mergedDetail) && count($mergedDetail) > 0)
        @foreach($mergedDetail as $no => $detail)
        <tr>
            <td align="center">{{$no+1}}</td>
            <td align="center">{{$detail->updated_at}}</td>
            @if($detail instanceof App\Models\PenjualanDetail)
            <td align="center">{{$detail->penjualan->no_order}}</td>
            <td align="center">{{$detail->produk->nama}}</td>
            <td align="center">Rp. {{ number_format($detail->produk->harga_jual) }}</td>
            <td align="center">{{$detail->qty}}</td>
            <td align="center">Rp. {{ number_format($detail->total) }}</td>
            @elseif($detail instanceof App\Models\PesananDetail)
            <td align="center">{{$detail->pesanan->no_order}}</td>
            <td align="center">{{$detail->produk->nama}}</td>
            <td align="center">Rp. {{ number_format($detail->produk->harga_jual) }}</td>
            <td align="center">{{$detail->qty}}</td>
            <td align="center">Rp. {{ number_format($detail->total) }}</td>
            @endif
        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="7" align="center">Data tidak ditemukan</td>
        </tr>
        @endif
    </tbody>
</table>
</div>
<div style="margin-left: 800px;">
    <p>Cilacap, ____________</p>
    <p>Penanggung Jawab</p>
    <br><br><br>
    <p>(___________________)</p>
</div>