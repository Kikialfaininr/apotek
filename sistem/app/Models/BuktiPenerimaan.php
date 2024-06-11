<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuktiPenerimaan extends Model
{
    use HasFactory;
    protected $table = 'buktipenerimaan';
    protected $filled = ['*'];
    protected $primaryKey = 'id_penerimaan';
    public $timestamps = false;

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan'); 
    }
}
