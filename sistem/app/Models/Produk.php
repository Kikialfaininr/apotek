<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    protected $table = 'produk';
    protected $primaryKey = 'id_produk';
    protected $filled = ['*'];
    public $timestamps = false;

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    public function kasir()
    {
        return $this->hasMany(Kasir::class, 'id_produk'); 
    }

    public function orderProduk()
    {
        return $this->hasMany(OrderProduk::class, 'id_produk');
    }
    
}
