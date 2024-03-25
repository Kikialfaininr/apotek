<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

/*------------------------------ Admin ------------------------------ */
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/admin-datauser', [App\Http\Controllers\AdminUserController::class, 'index']);

// kategori
Route::get('/admin-kategori', [App\Http\Controllers\AdminKategoriController::class, 'index']);
Route::post('/simpan-data-kategori', [App\Http\Controllers\AdminKategoriController::class, 'simpan']);
Route::get('{id}/edit-kategori', [App\Http\Controllers\AdminKategoriController::class, 'edit']);
Route::post('/update-kategori/{id}', [App\Http\Controllers\AdminKategoriController::class, 'update']);
Route::get('{id}/hapus-kategori', [App\Http\Controllers\AdminKategoriController::class, 'hapus']);
Route::get('/downloadpdf-kategori', [App\Http\Controllers\AdminKategoriController::class, 'downloadpdf']);

// produk
Route::post('/tambah', [App\Http\Controllers\AdminProdukController::class, 'tambah' ]);
Route::get('/admin-produk', [App\Http\Controllers\AdminProdukController::class, 'index']);
Route::post('/simpan-data-produk', [App\Http\Controllers\AdminProdukController::class, 'simpan']);
Route::get('{id}/edit-produk', [App\Http\Controllers\AdminProdukController::class, 'edit']);
Route::post('/update-produk/{id}', [App\Http\Controllers\AdminProdukController::class, 'update']);
Route::get('{id}/hapus-produk', [App\Http\Controllers\AdminProdukController::class, 'hapus']);
Route::get('/downloadpdf-produk', [App\Http\Controllers\AdminProdukController::class, 'downloadpdf']);

// kontrol stok
Route::get('/admin-stok', [App\Http\Controllers\AdminStokController::class, 'index']);
Route::get('/downloadstokhabis', [App\Http\Controllers\AdminStokController::class, 'downloadstokhabis']);
Route::get('/downloadstokmenipis', [App\Http\Controllers\AdminStokController::class, 'downloadstokmenipis']);

// penjualan
Route::get('/admin-penjualan', [App\Http\Controllers\AdminPenjualanController::class, 'index']);
Route::get('/downloadprodukterjual', [App\Http\Controllers\AdminPenjualanController::class, 'downloadprodukterjual']);
Route::get('/downloadinvoice', [App\Http\Controllers\AdminPenjualanController::class, 'downloadinvoice']);

// pesanan online masuk
Route::get('/admin-pesananmasuk', [App\Http\Controllers\AdminPesananmasukController::class, 'index']);

// pesanan online selesai
Route::get('/admin-pesananselesai', [App\Http\Controllers\AdminPesananselesaiController::class, 'index']);
Route::get('/downloadpesanan', [App\Http\Controllers\AdminPesananselesaiController::class, 'downloadpesanan']);
Route::get('/downloadpesanandetail', [App\Http\Controllers\AdminPesananselesaiController::class, 'downloadpesanandetail']);
Route::get('{id}/invoice-pesananonline', [App\Http\Controllers\AdminPesananselesaiController::class, 'invoice']);

// pesanan online batal
Route::get('/admin-pesananbatal', [App\Http\Controllers\AdminPesananbatalController::class, 'index']);

// laporan penjualan
Route::get('/admin-laporanpenjualan', [App\Http\Controllers\AdminLaporanpenjualanController::class, 'index']);
Route::get('/download-laporanpenjualan', [App\Http\Controllers\AdminLaporanpenjualanController::class, 'downloadlaporanpenjualan']);

// laporan penjualan
Route::get('/admin-laporankeuangan', [App\Http\Controllers\AdminLaporankeuanganController::class, 'index']);
Route::get('/download-laporankeuangan', [App\Http\Controllers\AdminLaporankeuanganController::class, 'downloadlaporankeuangan']);

/*------------------------------ Kasir ------------------------------ */
// kasir
Route::get('/kasir', [App\Http\Controllers\KasirController::class, 'index']);
Route::post('/tambah-transaksi', [App\Http\Controllers\KasirController::class, 'submit']);
Route::get('/change-quantity', [App\Http\Controllers\KasirController::class, 'changeQuantity']);
Route::get('{id}/hapus-kasir', [App\Http\Controllers\KasirController::class, 'hapus']);

// pesanan online
Route::get('/kasir-pesananonline', [App\Http\Controllers\KasirPesananonlineController::class, 'index']);
Route::post('/konfirmasi-pembayaran', [App\Http\Controllers\KasirPesananonlineController::class, 'konfirmasiPembayaran']);
Route::post('/update-status', [App\Http\Controllers\KasirPesananonlineController::class, 'updateStatus']);
Route::get('/download-pesananonline', [App\Http\Controllers\KasirPesananonlineController::class, 'downloadpesanan']);
Route::get('/download-detailonline', [App\Http\Controllers\KasirPesananonlineController::class, 'downloadpesanandetail']);

// invoice
Route::post('/simpan-transaksi', [App\Http\Controllers\KasirController::class, 'simpan']);
Route::get('/kasir-invoice/{id}', [App\Http\Controllers\KasirController::class, 'invoice']);

// stok produk
Route::get('/kasir-stokproduk', [App\Http\Controllers\KasirStokController::class, 'index']);

// riwayat penjualan
Route::get('/kasir-riwayatpenjualan', [App\Http\Controllers\KasirRiwayatpenjualanController::class, 'index']);
Route::get('/downloadprodukterjual', [App\Http\Controllers\KasirRiwayatpenjualanController::class, 'downloadprodukterjual']);
Route::get('/downloadinvoice-penjualan', [App\Http\Controllers\KasirRiwayatpenjualanController::class, 'downloadinvoice']);

// riwayat pesanan
Route::get('/kasir-riwayatpesananonline', [App\Http\Controllers\KasirRiwayatpesananController::class, 'index']);
Route::get('/download-riwayatpesanan', [App\Http\Controllers\KasirRiwayatpesananController::class, 'downloadpesanan']);
Route::get('/download-riwayatdetail', [App\Http\Controllers\KasirRiwayatpesananController::class, 'downloadpesanandetail']);

/*------------------------------ Toko Online  ------------------------------ */
// all produk
Route::get('/toko-allproduk', [App\Http\Controllers\TokoAllprodukController::class, 'index']);
Route::post('/keranjang', [App\Http\Controllers\TokoAllprodukController::class, 'submit']);
Route::get('/ubah-quantity', [App\Http\Controllers\TokoAllprodukController::class, 'changeQuantity']);
Route::get('{id}/hapus-keranjang', [App\Http\Controllers\TokoAllprodukController::class, 'hapus']);
Route::post('/simpan-pesanan', [App\Http\Controllers\TokoAllprodukController::class, 'simpan']);

// obat bebas terbatas
Route::get('/toko-obt', [App\Http\Controllers\TokoOBTController::class, 'index']);
Route::post('/keranjang-obt', [App\Http\Controllers\TokoOBTController::class, 'submit']);
Route::get('/ubah-quantity-obt', [App\Http\Controllers\TokoOBTController::class, 'changeQuantity']);
Route::get('{id}/hapus-keranjang-obt', [App\Http\Controllers\TokoOBTController::class, 'hapus']);
Route::post('/simpan-pesanan-obt', [App\Http\Controllers\TokoOBTController::class, 'simpan']);

// obat bebas
Route::get('/toko-obatbebas', [App\Http\Controllers\TokoObatbebasController::class, 'index']);
Route::post('/keranjang-obatbebas', [App\Http\Controllers\TokoObatbebasController::class, 'submit']);
Route::get('/ubah-quantity-obatbebas', [App\Http\Controllers\TokoObatbebasController::class, 'changeQuantity']);
Route::get('{id}/hapus-keranjang-obatbebas', [App\Http\Controllers\TokoObatbebasController::class, 'hapus']);
Route::post('/simpan-pesanan-obatbebas', [App\Http\Controllers\TokoObatbebasController::class, 'simpan']);

// vitamin
Route::get('/toko-vitamin', [App\Http\Controllers\TokoVitaminController::class, 'index']);
Route::post('/keranjang-vitamin', [App\Http\Controllers\TokoVitaminController::class, 'submit']);
Route::get('/ubah-quantity-vitamin', [App\Http\Controllers\TokoVitaminController::class, 'changeQuantity']);
Route::get('{id}/hapus-keranjang-vitamin', [App\Http\Controllers\TokoVitaminController::class, 'hapus']);
Route::post('/simpan-pesanan-vitamin', [App\Http\Controllers\TokoVitaminController::class, 'simpan']);

// checkout
Route::get('/toko-checkout/{id}', [App\Http\Controllers\CheckoutController::class, 'checkout']);
Route::post('/simpan-pengiriman', [App\Http\Controllers\CheckoutController::class, 'pengiriman']);
Route::post('/simpan-bukti', [App\Http\Controllers\CheckoutController::class, 'bukti']);