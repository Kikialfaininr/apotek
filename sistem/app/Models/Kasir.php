<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kasir extends Model
{
    use HasFactory;
    protected $table = 'kasir';
    protected $filled = ['*'];
    protected $primaryKey = 'id_kasir';
    public $timestamps = false;

    public function produk()
    {
        return $this->belongsTo('App\Models\Produk', 'id_produk');
    }
}
