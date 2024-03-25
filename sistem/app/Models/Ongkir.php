<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ongkir extends Model
{
    use HasFactory;
    protected $table = 'ongkir';
    protected $filled = ['*'];
    protected $primaryKey = 'id_ongkir';
    public $timestamps = false;

    public function pengiriman()
    {
        return $this->hasMany(Pengiriman::class, 'id_ongkir');
    }
}
