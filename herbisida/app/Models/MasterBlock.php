<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterBlock extends Model
{
    protected $fillable = [
        'block_code',
        'luas_tanam',
        'tahun_tanam',
        'jumlah_pokok',
        'topografi',
        'umur_tanam',
        'kategori_umur',
    ];
}
