<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuktiPembayaran extends Model
{
    use HasFactory;
    protected $table = 'buktipembayaran';
    protected $filled = ['*'];
    protected $primaryKey = 'id_bukti';
    public $timestamps = false;

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan'); 
    }
}
