<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterGulma extends Model
{
    protected $fillable = [
        'sampel',
        'nama_gulma',
        'jumlah',
        'foto',
    ];
}
