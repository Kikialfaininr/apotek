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
        <h3 class="text-center"><u>DATA STOK OPNAME</u></h3>
    </div>
</div>
<table id="kategori" class="table table-responsive table-bordered table-hover table-striped" style="width: 100%;">
    <thead>
        <tr>
            <th class="text-center">No</th>
            <th class="text-center">Nama Produk</th>
            <th class="text-center">Bentuk Sediaan</th>
            <th class="text-center">Satuan</th>
            <th class="text-center">Stok</th>
            <th class="text-center">Harga Beli</th>
            <th class="text-center">Kategori</th>
        </tr>
    </thead>
    <tbody>
        @php
        $counter = 0;
        @endphp
        @if(isset($produk) && count($produk) > 0)
        @foreach($produk as $no => $value)
        @php $counter++; @endphp
        <tr>
            <td align="center">{{$counter}}</td>
            <td>{{$value->nama}}</td>
            <td>{{$value->bentuk_sediaan}}</td>
            <td>{{$value->satuan}}</td>
            <td align="center">{{$value->stok}}</td>
            <td align="center">Rp {{ number_format($value->harga_beli) }}</td>
            <td>{{$value->kategori->nama_kategori}}</td>
        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="8" align="center">Data tidak ditemukan</td>
        </tr>
        @endif
    </tbody>
</table>
</div>
<div style="margin-left: 770px;">
    <p>Cilacap, ____________</p>
    <p>Penanggung Jawab</p>
    <br><br><br>
    <p>(___________________)</p>
</div>