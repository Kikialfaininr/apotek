<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengiriman extends Model
{
    use HasFactory;
    protected $table = 'pengiriman';
    protected $primaryKey = 'id_pengiriman';
    protected $filled = ['*'];
    public $timestamps = false;

    public function ongkir()
    {
        return $this->belongsTo(Ongkir::class, 'id_ongkir');
    }

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan'); 
    }    
}
