<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Block extends Model
{
    protected $fillable = [
        'block_code', 'afdeling', 'luas', 'gulma', 'gulma_foto',
        'gulma_ai_raw', 'kerapatan', 'herbisida', 'dosis',
        'rekomendasi', 'aktual', 'status',
    ];

    protected $casts = [
        'luas' => 'decimal:2',
        'dosis' => 'decimal:2',
        'gulma_ai_raw' => 'array',
    ];

    public function pemakaians(): HasMany
    {
        return $this->hasMany(Pemakaian::class)->orderBy('waktu');
    }

    public function evaluasi(): HasOne
    {
        return $this->hasOne(Evaluasi::class);
    }

    public function getSelisihAttribute(): int
    {
        return $this->aktual - $this->rekomendasi;
    }

    public function getPersenSelisihAttribute(): string
    {
        if ($this->rekomendasi == 0) return '0.0';
        return number_format(($this->selisih / $this->rekomendasi) * 100, 1);
    }
}
