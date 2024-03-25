<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;
    protected $table = 'penjualan';
    protected $filled = ['*'];
    protected $primaryKey = 'id_penjualan';
    public $timestamps = false;

    public function penjualanDetail()
    {
        return $this->hasMany(penjualanDetail::class, 'id_penjualan');
    }
}
