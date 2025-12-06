<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barang';

    protected $fillable = ['kode', 'namaBarang', 'ukuran', 'gambar', 'jumlahBarang'];

    public function size()
    {
        return $this->hasMany(Size::class);
    }

    public function getTotalStokAttribute()
    {
        return $this->size->sum('jumlah');
    }
}
