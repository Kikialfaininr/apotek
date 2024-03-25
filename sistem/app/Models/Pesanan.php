<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;
    protected $table = 'pesanan';
    protected $filled = ['*'];
    protected $primaryKey = 'id_pesanan';
    public $timestamps = false;

    public function pesananDetail()
    {
        return $this->hasMany(pesananDetail::class, 'id_pesanan');
    }

    public function pengiriman()
    {
        return $this->belongsTo(Pengiriman::class, 'id_pesanan');
    }  

    public function buktipembayaran()
    {
        return $this->belongsTo(BuktiPembayaran::class, 'id_pesanan'); 
    }
}
