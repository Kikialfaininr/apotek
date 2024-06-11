<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;
    protected $table = 'users';
    protected $filled = ['*'];
    protected $fillable = ['name','username', 'email', 'password', 'alamat', 'nomor_tlp', 'foto_profil', 'level'];
    protected $primaryKey = 'id';

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'id');
    }
}
