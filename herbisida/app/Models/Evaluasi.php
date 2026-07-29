<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Evaluasi extends Model
{
    protected $fillable = [
        'block_id', 'efektivitas', 'kategori', 'catatan',
        'foto_sebelum', 'foto_sesudah', 'foto_ai_raw',
    ];

    protected $casts = [
        'foto_ai_raw' => 'array',
    ];

    public function block(): BelongsTo
    {
        return $this->belongsTo(Block::class);
    }
}
