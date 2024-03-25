<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice Pesanan Online</title>
    <style>
    .container {
        width: 300px;
    }

    .header {
        margin: 0;
        text-align: center;
    }

    h2,
    p {
        margin: 0;
    }

    .flex-container-1 {
        display: flex;
        margin-top: 10px;
    }

    .flex-container-1>div {
        text-align: left;
    }

    .flex-container-1 .right {
        text-align: right;
        width: 200px;
    }

    .flex-container-1 .left {
        width: 100px;
    }

    .flex-container {
        width: 300px;
        display: flex;
    }

    .flex-container>div {
        -ms-flex: 1;
        /* IE 10 */
        flex: 1;
    }

    ul {
        display: contents;
    }

    ul li {
        display: block;
    }

    hr {
        border-style: dashed;
    }

    a {
        text-decoration: none;
        text-align: center;
        padding: 10px;
        background: #00e676;
        border-radius: 5px;
        color: white;
        font-weight: bold;
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="header" style="margin-bottom: 30px;">
            <h2>Apotek Dua Farma</h2>
            <small>Jalan Jendral Sudirman No. 6A RT 01 RW 09 Planjan, Kecamatan Kesugihan, Kab. Cilacap, Provinsi Jawa
                Tengah
            </small>
        </div>
        <hr>
        <div class="flex-container-1">
            <div class="left">
                <ul>
                    <li>No Order</li>
                    <li>Tanggal</li>
                    <li>Status</li>
                </ul>
            </div>
            <div class="right">
                <ul>
                    <li> {{ $pesanan->no_order }} </li>
                    <li> {{ date('Y-m-d : H:i:s', strtotime($pesanan->created_at)) }} </li>
                    <li>
                        @if ($pesanan->status)
                        {{ $pesanan->status }}
                        @else
                        Belum Diproses
                        @endif
                    </li>
                </ul>
            </div>
        </div>
        <hr>
        <div class="flex-container" style="margin-bottom: 10px; text-align:right;">
            <div style="text-align: left;">Nama Produk</div>
            <div>Harga/Qty</div>
            <div>Total</div>
        </div>
        @foreach ($pesanan->PesananDetail as $value)
        <div class="flex-container" style="text-align: right;">
            @php
            if(!empty($value->Produk->nama)) {
            $arr_name = explode(' ', $value->Produk->nama);
            $name = $arr_name[0];
            } elseif ($value->Produk->nama != '') {
            $name = $value->Produk->nama;
            } else {
            $name = 'there';
            }
            @endphp
            <div style="text-align: left;"> {{ $value->qty }}x {{ $name }} </div>
            <div>Rp {{ number_format($value->Produk->harga_jual) }} </div>
            <div>Rp {{ number_format($value->total) }} </div>
        </div>
        @endforeach
        <hr>
        <div class="flex-container" style="text-align: right; margin-top: 10px;">
            <div></div>
            <div>
                <ul>
                    <li>Total</li>
                </ul>
            </div>
            <div style="text-align: right;">
                <ul>
                    <li>Rp {{ number_format($pesanan->grand_total) }} </li>
                </ul>
            </div>
        </div>
        <hr>
        <div class="flex-container" style="margin-top: 10px;">
            <div>
                <ul>
                    <li>Pengiriman</li>
                </ul>
            </div>
            <div style="text-align: right;">
                <ul>
                    <li>{{ $pesanan->metode_pengiriman }} </li>
                </ul>
            </div>
        </div>
        @foreach($pengiriman as $no => $kirim)
        @if($kirim->id_pesanan == $value->id_pesanan)
        <div class="flex-container" style="text-align: right;">
            <div>
                <ul>
                    <li>Alamat</li>
                    <li>Jarak</li>
                    <li>Ongkir</li>
                </ul>
            </div>
            <div style="text-align: right;">
                <ul>
                    <li>{{ $kirim->alamat }} </li>
                    <li>{{ $kirim->jarak }} KM</li>
                    <li>Rp {{ number_format($kirim->ongkir) }} </li>
                </ul>
            </div>
        </div>
        @endif
        @endforeach
        <hr>
        <div class="flex-container" style="margin-top: 10px;">
            <div>
                <ul>
                    <li>Pembayaran</li>
                </ul>
            </div>
            <div style="text-align: right;">
                <ul>
                    <li>{{ $pesanan->metode_pembayaran }} </li>
                </ul>
            </div>
        </div>
        <div class="flex-container" style="text-align: right;">
            <div>
                <ul>
                    <li></li>
                </ul>
            </div>
            @foreach($buktiPembayaran as $no => $bukti)
            @if($bukti->id_pesanan == $value->id_pesanan)
            <div style="text-align: right;">
                <ul>
                    <li>{{ $bukti->konfirmasi }}</li>
                </ul>
            </div>
            @endif
            @endforeach
        </div>
        <hr>
        <div class="flex-container" style="text-align: right; margin-top: 10px;">
            <div></div>
            <div>
                <ul>
                    <li><strong>Total Bayar</strong></li>
                </ul>
            </div>
            @php
            $ongkir_tersedia = false;
            @endphp

            @foreach($pengiriman as $no => $kirim)
            @if($kirim->id_pesanan == $value->id_pesanan)
            @php
            $ongkir_tersedia = true;
            @endphp
            <div style="text-align: right;">
                <ul>
                    <li><strong>Rp {{ number_format($kirim->ongkir + $pesanan->grand_total) }} </strong></li>
                </ul>
            </div>
            @break
            @endif
            @endforeach

            @if (!$ongkir_tersedia)
            <div style="text-align: right;">
                <ul>
                    <li><strong>Rp {{ number_format($pesanan->grand_total) }} </strong></li>
                </ul>
            </div>
            @endif

        </div>
        <hr>
        <div class="header" style="margin-top: 20px;">
            <h3>Terimakasih</h3>
            <p>Silahkan melakukan pemesanan online kembali</p>
        </div>
    </div>
</body>

</html>