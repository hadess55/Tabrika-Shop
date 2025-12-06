<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Size extends Model
{
    use HasFactory;

    protected $table = 'size';

    protected $fillable = [
        'barang_id',
        'ukuran',
        'jumlah',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
