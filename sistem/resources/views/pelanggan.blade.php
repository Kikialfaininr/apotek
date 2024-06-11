@extends('layouts.app')
@extends('layouts.alert')

@section('content')
@if(auth()->check() && (auth()->user()->level == 'pelanggan'))
<div class="container">
    @foreach($pelanggan as $no => $value)
    <div class="row">
        <div class="col" align="center">
            @if($value->foto)
            <img src="images/fotoprofil/{{$value->foto}}" alt="profil" style="width:100px; height: 100px;"
                class="d-inline-block align-text-center rounded-circle" />
            @else
            <img src="sistem/img/profil.jpg" alt="profil" style="width:100px; height: 100px;"
                class="d-inline-block align-text-center rounded-circle">
            @endif
            <h4>{{$value->name}}</h4>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                data-bs-target="#EditPelanggan{{$value->id}}" title="Edit Profil">
                <i class="fa fa-edit"></i> edit profil
            </button>
        </div>
        <div class="col center-dist">
            <table class="table table-borderless">
                <tbody>
                    <tr>
                        <td>Nama</td>
                        <td>:</td>
                        <td>{{$value->fullname}}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>:</td>
                        <td>{{$value->email}}</td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>:</td>
                        <td>{{$value->alamat}}</td>
                    </tr>
                    <tr>
                        <td>Nomor Telepon</td>
                        <td>:</td>
                        <td>{{$value->nomor_tlp}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    @endforeach
    <hr>

    <div class="row justify-content-center mt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button style="color: #34455B; font-weight: bold;" class="nav-link active" id="diproses-tab"
                                data-bs-toggle="tab" data-bs-target="#diproses" type="button" role="tab"
                                aria-controls="diproses" aria-selected="true">Diproses</button>
                            <button style="color: #34455B; font-weight: bold;" class="nav-link" id="siap-tab"
                                data-bs-toggle="tab" data-bs-target="#siap" type="button" role="tab"
                                aria-controls="siap" aria-selected="true">Siap</button>
                            <button style="color: #34455B; font-weight: bold;" class="nav-link" id="siap-tab"
                                data-bs-toggle="tab" data-bs-target="#dikirim" type="button" role="tab"
                                aria-controls="siap" aria-selected="true">Dikirim</button>
                            <button style="color: #34455B; font-weight: bold;" class="nav-link" id="selesai-tab"
                                data-bs-toggle="tab" data-bs-target="#selesai" type="button" role="tab"
                                aria-controls="selesai" aria-selected="false">Selesai</button>
                            <button style="color: #34455B; font-weight: bold;" class="nav-link" id="batal-tab"
                                data-bs-toggle="tab" data-bs-target="#batal" type="button" role="tab"
                                aria-controls="batal" aria-selected="false">Dibatalkan</button>
                        </div>
                    </nav>
                    <div style="margin-top: 20px;">
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
                    </div>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="diproses" role="tabpanel"
                            aria-labelledby="diproses-tab" tabindex="0">
                            <h3 style="color: #34495e; margin-top: 30px; font-weight: bold; text-align: center;">
                                Pesanan Diproses</h3>
                            <div class="table-responsive" style="margin-top: 20px;">
                                <table id="example1"
                                    class="table table-responsive table-striped table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Waktu</th>
                                            <th class="text-center">No Order</th>
                                            <th class="text-center">Total</th>
                                            <th class="text-center">Pengiriman</th>
                                            <th class="text-center">Pembayaran</th>
                                            <th class="text-center">Detail</th>
                                            <th class="text-center"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $no = 0;
                                        @endphp
                                        @forelse($pesanan as $value)
                                        @if(is_null($value->status))
                                        @php
                                        $no++;
                                        @endphp
                                        <tr>
                                            <td align="center">{{$no+1}}</td>
                                            <td align="center">{{$value->updated_at}}</td>
                                            <td align="center">{{$value->no_order}}</td>
                                            <td align="center">Rp. {{ number_format($value->grand_total) }}</td>
                                            <td align="center">{{ $value->metode_pengiriman }} </td>
                                            <td align="center">{{ $value->metode_pembayaran }} </td>
                                            <td align="center">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#detail{{$value->id_pesanan}}"
                                                    title="Detail Pesanan">
                                                    Detail
                                                </button>
                                                <a href="{{url($value->id_pesanan.'/invoice-pesananonline')}}"
                                                    target="_blank">
                                                    <button class="btn btn-danger btn-sm">
                                                        <i class="fas fa-file-invoice"></i>
                                                    </button>
                                                </a>
                                            </td>
                                            <td align="center" style="max-width: 200px;">
                                                @if ($value->metode_pembayaran != "QRIS")
                                                <form id="cancelForm" action="{{ url('update-status') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="pesanan_id"
                                                        value="{{ $value->id_pesanan }}">
                                                    <input type="hidden" name="status" value="Dibatalkan">
                                                    <button type="button" class="btn btn-danger"
                                                        onclick="confirmCancel()">Batalkan Pesanan</button>
                                                </form>
                                                @else
                                                <p style="font-style: italic; color: #E72929;">Tidak dapat membatalkan
                                                    pembayaran QRIS</p>
                                                @endif
                                            </td>

                                            <script>
                                            function confirmCancel() {
                                                if (confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')) {
                                                    document.getElementById('cancelForm').submit();
                                                }
                                            }
                                            </script>

                                        </tr>
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="siap" role="tabpanel" aria-labelledby="siap-tab" tabindex="0">
                            <h3 style="color: #34495e; margin-top: 30px; font-weight: bold; text-align: center;">
                                Pesanan Siap</h3>
                            <p style="color: #B4B4B8; text-align: center;">Pesanan siap diambil di Apotek Dua Farma</p>
                            <div class="table-responsive">
                                <table id="example2"
                                    class="table table-responsive table-striped table-hover table-bordered"
                                    style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Waktu</th>
                                            <th class="text-center">No Order</th>
                                            <th class="text-center">Total</th>
                                            <th class="text-center">Pengiriman</th>
                                            <th class="text-center">Pembayaran</th>
                                            <th class="text-center">Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no = 0 @endphp
                                        @foreach($pesanan as $value)
                                        @if ($value->status == 'Siap')
                                        <tr>
                                            <td align="center">{{ ++$no }}</td>
                                            <td align="center">{{ $value->updated_at }}</td>
                                            <td align="center">{{ $value->no_order }}</td>
                                            <td align="center">Rp. {{ number_format($value->grand_total) }}</td>
                                            <td align="center">{{ $value->metode_pengiriman }} </td>
                                            <td align="center">{{ $value->metode_pembayaran }} </td>
                                            <td align="center">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#detail{{$value->id_pesanan}}"
                                                    title="Detail Pesanan">
                                                    Detail
                                                </button>
                                                <a href="{{url($value->id_pesanan.'/invoice-pesananonline')}}"
                                                    target="_blank">
                                                    <button class="btn btn-danger btn-sm">
                                                        <i class="fas fa-file-invoice"></i>
                                                    </button>
                                                </a>
                                            </td>
                                        </tr>
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="dikirim" role="tabpanel" aria-labelledby="dikirim-tab"
                            tabindex="0">
                            <h3 style="color: #34495e; margin-top: 30px; font-weight: bold; text-align: center;">
                                Pesanan Siap</h3>
                            <p style="color: #B4B4B8; text-align: center;">Pesanan anda sedang dikirim, silahkan tunggu!
                            </p>
                            <div class="table-responsive">
                                <table id="example3"
                                    class="table table-responsive table-striped table-hover table-bordered"
                                    style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Waktu</th>
                                            <th class="text-center">No Order</th>
                                            <th class="text-center">Total</th>
                                            <th class="text-center">Pengiriman</th>
                                            <th class="text-center">Pembayaran</th>
                                            <th class="text-center">Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no = 0 @endphp
                                        @foreach($pesanan as $value)
                                        @if ($value->status == 'Dikirim')
                                        <tr>
                                            <td align="center">{{ ++$no }}</td>
                                            <td align="center">{{ $value->updated_at }}</td>
                                            <td align="center">{{ $value->no_order }}</td>
                                            <td align="center">Rp. {{ number_format($value->grand_total) }}</td>
                                            <td align="center">{{ $value->metode_pengiriman }} </td>
                                            <td align="center">{{ $value->metode_pembayaran }} </td>
                                            <td align="center">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#detail{{$value->id_pesanan}}"
                                                    title="Detail Pesanan">
                                                    Detail
                                                </button>
                                                <a href="{{url($value->id_pesanan.'/invoice-pesananonline')}}"
                                                    target="_blank">
                                                    <button class="btn btn-danger btn-sm">
                                                        <i class="fas fa-file-invoice"></i>
                                                    </button>
                                                </a>
                                            </td>
                                        </tr>
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="selesai" role="tabpanel" aria-labelledby="selesai-tab"
                            tabindex="0">
                            <h3 style="color: #34495e; margin-top: 30px; font-weight: bold; text-align: center;">
                                Pesanan Online Selesai</h3>
                            <div class="table-responsive">
                                <table id="example4"
                                    class="table table-responsive table-striped table-hover table-bordered"
                                    style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Waktu</th>
                                            <th class="text-center">No Order</th>
                                            <th class="text-center">Total</th>
                                            <th class="text-center">Pengiriman</th>
                                            <th class="text-center">Pembayaran</th>
                                            <th class="text-center">Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no = 0 @endphp
                                        @foreach($pesanan as $value)
                                        @if ($value->status == 'Selesai')
                                        <tr>
                                            <td align="center">{{ ++$no }}</td>
                                            <td align="center">{{ $value->updated_at }}</td>
                                            <td align="center">{{ $value->no_order }}</td>
                                            <td align="center">Rp. {{ number_format($value->grand_total) }}</td>
                                            <td align="center">{{ $value->metode_pengiriman }} </td>
                                            <td align="center">{{ $value->metode_pembayaran }} </td>
                                            <td align="center">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#detail{{$value->id_pesanan}}"
                                                    title="Detail Pesanan">
                                                    Detail
                                                </button>
                                                <a href="{{url($value->id_pesanan.'/invoice-pesananonline')}}"
                                                    target="_blank">
                                                    <button class="btn btn-danger btn-sm">
                                                        <i class="fas fa-file-invoice"></i>
                                                    </button>
                                                </a>
                                            </td>
                                        </tr>
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="batal" role="tabpanel" aria-labelledby="batal-tab" tabindex="0">
                            <h3 style="color: #34495e; margin-top: 30px; font-weight: bold; text-align: center;">
                                Pesanan Dibatalkan</h3>
                            @if(isset($tanggal))
                            <p style="color: #B4B4B8; text-align: center;">Tanggal: {{ $tanggal }}</p>
                            @endif
                            <div class="table-responsive" style="margin-top: 20px;">
                                <table id="example5"
                                    class="table table-responsive table-striped table-hover table-bordered"
                                    style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Waktu</th>
                                            <th class="text-center">No Order</th>
                                            <th class="text-center">Total</th>
                                            <th class="text-center">Pengiriman</th>
                                            <th class="text-center">Pembayaran</th>
                                            <th class="text-center">Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no = 0 @endphp
                                        @foreach($pesanan as $value)
                                        @if ($value->status == 'Ditolak' || $value->status == 'Dibatalkan')
                                        <tr>
                                            <td align="center">{{ ++$no }}</td>
                                            <td align="center">{{ $value->updated_at }}</td>
                                            <td align="center">{{ $value->no_order }}</td>
                                            <td align="center">Rp. {{ number_format($value->grand_total) }}</td>
                                            <td align="center">{{ $value->metode_pengiriman }} </td>
                                            <td align="center">{{ $value->metode_pembayaran }} </td>
                                            <td align="center">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#detail{{$value->id_pesanan}}"
                                                    title="Detail Pesanan">
                                                    Detail
                                                </button>
                                            </td>
                                        </tr>
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@foreach($pesanan as $no => $value)
<div class="modal" id="detail{{$value->id_pesanan}}" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detail Pesanan</h4>
            </div>
            <div class="modal-body">
                <table class="table table-responsive table-striped table-hover table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Produk</th>
                            <th class="text-center">Harga</th>
                            <th class="text-center">QTY</th>
                            <th class="text-center">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $counter = 0;
                        $last_order_id = null;
                        @endphp

                        @foreach($pesananDetail as $no => $detail)
                        @if($detail->id_pesanan != $last_order_id)
                        @php
                        $counter = 1;
                        $last_order_id = $detail->id_pesanan;
                        @endphp
                        @endif

                        @if($detail->id_pesanan == $value->id_pesanan)
                        <tr>
                            <td align="center">{{$counter}}</td>
                            <td align="center">{{$detail->produk->nama}}</td>
                            <td align="center">Rp. {{ number_format($detail->produk->harga_jual) }}</td>
                            <td align="center">{{$detail->qty}}</td>
                            <td align="center">Rp. {{ number_format($detail->total) }}</td>
                        </tr>
                        @php $counter++; @endphp
                        @endif
                        @endforeach
                    </tbody>
                </table>
                <table class="table table-responsive table-bordered">
                    <tbody>
                        <tr>
                            <td colspan="2" style="background-color: #EEEEEE"><strong>Pengiriman</strong></td>
                            <td style="background-color: #EEEEEE"><strong>{{ $value->metode_pengiriman }}</strong>
                            </td>
                        </tr>
                        @foreach($pengiriman as $no => $kirim)
                        @if($kirim->id_pesanan == $value->id_pesanan)
                        <tr>
                            <td colspan="2">Alamat</td>
                            <td>{{ $kirim->alamat }} </td>
                        </tr>
                        <tr>
                            <td colspan="2">Wilayah</td>
                            <td>{{ $kirim->wilayah }}</td>
                        </tr>
                        <tr>
                            <td colspan="2">Ongkir</td>
                            <td>{{ $kirim->ongkir }} </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
                <table class="table table-responsive table-bordered">
                    <tbody>
                        <tr>
                            <td colspan="2" style="background-color: #EEEEEE"><strong>Pembayaran</strong></td>
                            <td style="background-color: #EEEEEE"><strong>{{ $value->metode_pembayaran }}</strong>
                            </td>
                        </tr>
                        @php $bukti_pembayaran_ada = false; @endphp
                        @foreach($buktiPembayaran as $no => $bukti)
                        @if($bukti->id_pesanan == $value->id_pesanan)
                        @php $bukti_pembayaran_ada = true; @endphp
                        <tr>
                            <td colspan="2">Bukti Pembayaran</td>
                            <td><a href="images/buktipembayaran/{{$bukti->foto}}" target="_blank"><img
                                        src="images/buktipembayaran/{{$bukti->foto}}" width="100px"></a></td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td>
                                @if ($bukti->konfirmasi == 'Terkonfirmasi')
                                <strong><i class="fa fa-check"></i> Terkonfirmasi</strong>
                                @elseif ($bukti->konfirmasi == 'Ditolak')
                                @if ($value->status == 'Ditolak')
                                <strong><i class="fa fa-times"></i> Bukti Pembayaran Ditolak</strong><br>
                                <p style="font-style: italic; color: #E72929;">Pesanan telah dibatalkan pihak apotek
                                    karena bukti pembayaran tidak sesuai.</p>
                                @else
                                <strong><i class="fa fa-times"></i> Bukti Pembayaran Ditolak</strong><br>
                                <p style="font-style: italic; color: #E72929;">Pesanan akan segera dibatalkan oleh pihak
                                    apotek.</p>
                                @endif
                                @else
                                <strong><i class="fa fa-clock"></i> Belum Terkonfirmasi</strong>
                                @endif
                            </td>
                        </tr>
                        @endif
                        @endforeach

                        @if (!$bukti_pembayaran_ada && $value->metode_pembayaran == 'QRIS')
                        <tr>
                            <td colspan="3" style="font-style: italic; color: #E72929;">Anda belum mengupload bukti
                                pembayaran, <a href="toko-checkout/{{$value->id_pesanan}}">upload sekarang!</a></td>
                        </tr>
                        @endif

                    </tbody>
                </table>
                <table class="table table-responsive table-bordered">
                    <tbody>
                        @foreach($pengiriman as $no => $kirim)
                        @if($kirim->id_pesanan == $value->id_pesanan)
                        <tr>
                            <td colspan="2" style="background-color: #EEEEEE"><strong>Total Pembayaran</strong></td>
                            <td style="background-color: #EEEEEE"><strong>Rp
                                    {{ number_format($kirim->ongkir + $value->grand_total) }}</strong>
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
                @foreach($buktiPenerimaan as $no => $penerimaan)
                @if($penerimaan->id_pesanan == $value->id_pesanan)
                <table class="table table-responsive table-bordered">
                    <tbody>
                        <tr>
                            <td colspan="3" style="background-color: #EEEEEE;">
                                <strong>Bukti Penerimaan Pelanggan</strong>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">Bukti Penerimaan</td>
                            <td><a href="images/buktipenerimaan/{{$penerimaan->foto}}" target="_blank">
                                    <img src="images/buktipenerimaan/{{$penerimaan->foto}}" width="100px"></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                @endif
                @endforeach
                @if($value->status == "Dikirim")
                <div class="modal-footer">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <table class="table table-responsive table-borderless">
                                <tr>
                                    <td colspan="2">
                                        <p style="font-style: italic; color: #E72929;">Jika tidak melakukan konfirmasi
                                            penyelesaian pesanan lebih dari 3 hari, maka pesanan akan otomatis
                                            terselesaikan.</p>
                                    </td>
                                    <td>
                                        <form action="{{ url('update-status') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="pesanan_id" value="{{ $value->id_pesanan }}">
                                            <input type="hidden" name="status" value="Selesai">
                                            <button type="submit" class="btn btn-success">Selesai</button>
                                        </form>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endforeach

@foreach($pelanggan as $no => $value)
<div class="modal" id="EditPelanggan{{$value->id}}" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Profil</h4>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{url('update-pelanggan/'.$value->id)}}" enctype="multipart/form-data">
                    @csrf
                    <div align="center" style="margin-bottom: 20px;">
                        @if($value->foto)
                        <img id="preview" src="{{ asset('images/fotoprofil/'.$value->foto) }}" alt="profil"
                            style="width:100px; height: 100px;"
                            class="d-inline-block align-text-center rounded-circle" />
                        @else
                        <img id="preview" src="{{ asset('sistem/img/profil.jpg') }}" alt="profil"
                            style="width:100px; height: 100px;" class="d-inline-block align-text-center rounded-circle">
                        @endif
                        <input style="width: 14%; margin-top: 5px;" id="foto" onchange="readFoto(event)" type="file"
                            class="form-control @error('foto') is-invalid @enderror" name="foto"
                            value="{{ old('foto') }}" autofocus>
                        @error('foto')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <table>
                        <tbody>
                            <tr>
                                <td width="30%"><label for="name">{{ __('Username') }}</label></td>
                                <td>:</td>
                                <td></td>
                                <td width="100%">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ $value->name }}" required autofocus>
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </td>
                            </tr>
                            <tr>
                                <td><label for="fullname">{{ __('Nama Lengkap') }}</label></td>
                                <td>:</td>
                                <td></td>
                                <td width="100%">
                                    <input id="fullname" type="text"
                                        class="form-control @error('fullname') is-invalid @enderror" name="fullname"
                                        value="{{ $value->fullname }}" required autofocus>
                                    @error('fullname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </td>
                            </tr>
                            <tr>
                                <td><label for="email">{{ __('Email') }}</label></td>
                                <td>:</td>
                                <td></td>
                                <td width="100%">
                                    <input id="email" type="text"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ $value->email }}" required autofocus>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </td>
                            </tr>
                            <tr>
                                <td><label for="alamat">{{ __('Alamat') }}</label></td>
                                <td>:</td>
                                <td></td>
                                <td width="100%">
                                    <input id="alamat" type="text"
                                        class="form-control @error('alamat') is-invalid @enderror" name="alamat"
                                        value="{{ $value->alamat }}" required autofocus>
                                    @error('alamat')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </td>
                            </tr>
                            <tr>
                                <td><label for="nomor_tlp">{{ __('Nomor Telepon') }}</label></td>
                                <td>:</td>
                                <td></td>
                                <td width="100%">
                                    <input id="nomor_tlp" type="text"
                                        class="form-control @error('nomor_tlp') is-invalid @enderror" name="nomor_tlp"
                                        value="{{ $value->nomor_tlp }}" required autofocus>
                                    @error('nomor_tlp')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </td>
                            </tr>
                            <tr>
                                <td><label for="password">{{ __('Password') }}</label></td>
                                <td>:</td>
                                <td></td>
                                <td width="100%">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        placeholder="Masukkan password baru jika ingin mengubah" autofocus>
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="form-group row">
                        <label class="col-form-label text-md-end"></label>
                        <div class="col-md-12">
                            <button class="btn btn-success" style="width: 100%;">Simpan</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endforeach

@push('scripts')
<script>
new DataTable('#example1', {
    responsive: true,
    rowReorder: {
        selector: 'td:nth-child(2)'
    }
});
</script>
<script>
new DataTable('#example2', {
    responsive: true,
    rowReorder: {
        selector: 'td:nth-child(2)'
    }
});
</script>
<script>
new DataTable('#example3', {
    responsive: true,
    rowReorder: {
        selector: 'td:nth-child(2)'
    }
});
</script>
<script>
new DataTable('#example4', {
    responsive: true,
    rowReorder: {
        selector: 'td:nth-child(2)'
    }
});
</script>
<script>
new DataTable('#example5', {
    responsive: true,
    rowReorder: {
        selector: 'td:nth-child(2)'
    }
});
</script>
@endpush

<script>
function readFoto(event) {
    var input = event.target;
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview').setAttribute('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

<script>
window.onload = function() {
    if (!window.location.hash) {
        window.location = window.location + '#loaded';
        setTimeout(function() {
            window.location.reload();
        }, 5000);
    }
}
</script>

@else
<?php abort(403, 'Unauthorized action.'); ?>
@endif

@endsection