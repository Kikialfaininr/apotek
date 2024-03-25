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
        <h3 class="text-center"><u>LAPORAN KEUANGAN</u></h3>
    </div>
</div>
<table id="kategori" class="table table-responsive table-bordered table-hover table-striped" style="width: 100%;">
    <thead>
        <tr>
            <th class="text-center">No</th>
            <th class="text-center">Waktu</th>
            <th class="text-center">Produk</th>
            <th class="text-center">Harga Beli</th>
            <th class="text-center">Harga Jual</th>
            <th class="text-center">QTY</th>
            <th class="text-center">Laba Kotor</th>
            <th class="text-center">Laba Bersih</th>
        </tr>
    </thead>
    <tbody>
        @if(isset($mergedDetail) && count($mergedDetail) > 0)
        @php
        $totalLabaKotor = 0;
        $totalLabaBersih = 0;
        @endphp
        @foreach($mergedDetail as $no => $detail)
        <tr>
            <td align="center">{{$no+1}}</td>
            <td align="center">{{$detail->created_at}}</td>
            @if($detail instanceof App\Models\PenjualanDetail || $detail instanceof
            App\Models\PesananDetail)
            <td align="center">{{$detail->produk->nama}}</td>
            <td align="center">Rp. {{ number_format($detail->produk->harga_beli) }}</td>
            <td align="center">Rp. {{ number_format($detail->produk->harga_jual) }}</td>
            <td align="center">{{$detail->qty}}</td>
            <td align="center">Rp. {{ number_format($detail->total) }}</td>
            <td align="center">Rp.
                {{ number_format($detail->total - ($detail->produk->harga_beli * $detail->qty)) }}</td>
            @php
            $labaKotor = $detail->total;
            $totalLabaKotor += $labaKotor;
            @endphp
            @php
            $labaBersih = $detail->total - ($detail->produk->harga_beli * $detail->qty);
            $totalLabaBersih += $labaBersih;
            @endphp
            @endif
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="6" align="center"><strong>Total Pendapatan</strong></td>
            <td align="center"><strong><?php echo "Rp." . number_format($totalLabaKotor); ?></strong></td>
            <td align="center"><strong><?php echo "Rp." . number_format($totalLabaBersih); ?></strong></td>
        </tr>
        @else
        <tr>
            <td colspan="7" align="center">Data tidak ditemukan</td>
        </tr>
        @endif
    </tfoot>
</table>
</div>
<div style="margin-left: 800px;">
    <p>Cilacap, ____________</p>
    <p>Penanggung Jawab</p>
    <br><br><br>
    <p>(___________________)</p>
</div>