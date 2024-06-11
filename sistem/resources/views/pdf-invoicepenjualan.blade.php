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
        <h3 class="text-center"><u>DATA INVOICE PENJUALAN</u></h3>
    </div>
</div>
<table id="kategori" class="table table-responsive table-bordered table-hover table-striped" style="width: 100%;">
    <thead>
        <tr>
            <th class="text-center">No</th>
            <th class="text-center">Waktu</th>
            <th class="text-center">No Order</th>
            <th class="text-center">Kasir</th>
            <th class="text-center">Total</th>
            <th class="text-center">Pembayaran</th>
            <th class="text-center">Kembalian</th>
            <th class="text-center">Metode Pembayaran</th>
        </tr>
    </thead>
    <tbody>
        @foreach($penjualan as $no => $value)
        <tr>
            <td align="center">{{$no+1}}</td>
            <td align="center">{{$value->updated_at}}</td>
            <td align="center">{{$value->no_order}}</td>
            <td align="center">{{$value->nama_kasir}}</td>
            <td align="center">Rp. {{ number_format($value->grand_total) }}</td>
            <td align="center">Rp. {{ number_format($value->pembayaran) }}</td>
            <td align="center">Rp. {{ number_format($value->kembalian) }}</td>
            <td align="center">{{ $value->metode_pembayaran }} </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>
<div style="margin-left: 780px;">
    <p>Cilacap, ____________</p>
    <p>Penanggung Jawab</p>
    <br><br><br>
    <p>(___________________)</p>
</div>