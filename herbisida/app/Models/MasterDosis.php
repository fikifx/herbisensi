<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterDosis extends Model
{
    protected $fillable = [
        'item_pekerjaan', 'jenis_gulma',
        'material_1', 'material_2', 'material_3',
        'dosis_1', 'dosis_2', 'dosis_3',
        'volume_1', 'volume_2', 'volume_3',
        'kapasitas_intersprayer', 'jumlah_intersprayer',
        'herb_kap_1', 'herb_kap_2', 'herb_kap_3',
        'herb_ltr_1', 'herb_ltr_2', 'herb_ltr_3',
    ];
}
