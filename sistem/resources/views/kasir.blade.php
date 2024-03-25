@extends('layouts.app-kasir')
@extends('layouts.alert')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-group row pb-5">
                        <form method="POST" action="{{url('tambah-transaksi')}}" class="row g-3 mt-3">
                            @csrf
                            <label for="produk" class="col-sm-2 col-form-label">Produk</label>
                            <div class="col-sm-8">
                                <select class="form-control select2 @error('id_produk') is-invalid @enderror"
                                    name="id_produk" required>
                                    <option>-- Pilih Produk --</option>
                                    @foreach ($produk as $produk)
                                    <option value="{{ $produk->id_produk }}">{{ $produk->nama }}</option>
                                    @endforeach
                                </select>

                                @error('id_produk')
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror

                                <script>
                                $(document).ready(function() {
                                    $('.select2').select2();
                                });
                                </script>

                                @error('id_produk')
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="col-sm-2">
                                <button type="submit" class="btn btn-success w-100">Tambah</button>
                            </div>
                        </form>
                    </div>

                    @if (session()->has('message'))
                    @php
                    $alertClass = session('alert_class', 'success');
                    @endphp

                    <div class="alert alert-{{ $alertClass }}">
                        {{ session('message') }}
                    </div>
                    @endif

                    @if (session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif

                    <div class="card-body border-top pb-5 p-0 mt-3">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">QTY</th>
                                    <th scope="col">Harga/QTY</th>
                                    <th scope="col" style="width: 200px;">Total</th>
                                    <th scope="col" style="width: 10px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kasir as $no => $value)
                                <tr>
                                    <td align="center">{{$no+1}}</td>
                                    <td>{{$value->produk->nama}}</td>
                                    <td>
                                        <div class="d-flex">
                                            @if ($value->qty > 1)
                                            <a href="{{ url('/change-quantity?id_produk=' . $value->id_produk . '&act=minus') }}"
                                                class="btn btn-primary"><i class="fas fa-minus"></i></a>
                                            @endif
                                            <input type="number" value="{{ $value->qty }}" class="form-control"
                                                name="qty" id="qty-{{ $value->id_produk }}" readonly
                                                style="text-align: center;">
                                            <a href="{{ url('/change-quantity?id_produk=' . $value->id_produk . '&act=plus') }}"
                                                class="btn btn-primary"><i class="fas fa-plus"></i></a>
                                        </div>
                                    </td>
                                    <td>Rp. {{ number_format($value->produk->harga_jual) }}</td>
                                    <td>Rp. {{ number_format($value->produk->harga_jual*$value->qty) }}</td>
                                    <td>
                                        <a href="{{url($value->id_kasir.'/hapus-kasir')}}">
                                            <button title="Hapus Data" class="btn btn-danger btn-sm"><i
                                                    class="fas fa-trash"></i></button>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <form method="POST" action="{{ url('simpan-transaksi') }}" target="_blank">
                                @csrf
                                <tfoot>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td style="text-align:right;">Total Pembelian</td>
                                    <td>
                                        Rp {{ number_format($kasir->sum('total')) }}
                                    </td>
                                    <tr>
                                        <td style="border:none;"></td>
                                        <td style="border:none;"></td>
                                        <td style="border:none;"></td>
                                        <td style="text-align:right;">Pembayaran</td>
                                        <td style="text-align:right;">
                                            <input type="number" id="pembayaran" class="form-control" name="pembayaran"
                                                oninput="hitungKembalian()">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border:none;"></td>
                                        <td style="border:none;"></td>
                                        <td style="border:none;"></td>
                                        <td style="text-align:right;">Kembalian</td>
                                        <td id="kembalian" style="text-align:left;">Rp </td>
                                    </tr>
                                    <tr>
                                        <td style="border:none;"></td>
                                        <td style="border:none;"></td>
                                        <td style="border:none;"></td>
                                        <td style="text-align:right;">Metode Pembayaran</td>
                                        <td style="text-align:center;">
                                            <label><input type="radio" name="metode_pembayaran" value="Tunai" checked>
                                                Tunai</label>
                                            <label><input type="radio" name="metode_pembayaran" value="QRIS">
                                                QRIS</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border:none;"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" style="border:none;">
                                            <button type="submit" class="btn btn-success btn-sm float-right"
                                                style="width: 100%;">Simpan</button>
                                        </td>
                                    </tr>
                                </tfoot>
                            </form>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function hitungKembalian() {
    var pembayaran = parseInt(document.getElementById('pembayaran').value);
    console.log('Nilai Pembayaran:', pembayaran);

    var totalPembelian = parseInt(<?php echo $kasir->sum('total'); ?>);

    console.log('Total Pembelian:', totalPembelian);

    var kembalian = pembayaran - totalPembelian;
    console.log('Kembalian:', kembalian);

    document.getElementById('kembalian').innerHTML = 'Rp ' + kembalian.toLocaleString('id-ID');
}
</script>

@endsection