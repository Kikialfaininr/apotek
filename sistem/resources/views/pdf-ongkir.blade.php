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
        <h3 class="text-center"><u>DATA ONGKOS KIRIM</u></h3>
    </div>
</div>
<table id="kategori" class="table table-responsive table-bordered table-hover table-striped" style="width: 100%;">
    <thead>
        <tr>
            <th class="text-center">No</th>
            <th class="text-center">Wilayah</th>
            <th class="text-center">Ongkir</th>
        </tr>
    </thead>
    <tbody>
        @foreach($ongkir as $no => $value)
        <tr>
            <td align="center">{{$no+1}}</td>
            <td align="center">{{$value->wilayah}}</td>
            <td align="center">Rp {{ number_format($value->ongkir) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>
<div style="margin-left: 550px;">
    <p>Cilacap, ____________</p>
    <p>Penanggung Jawab</p>
    <br><br><br>
    <p>(___________________)</p>
</div>