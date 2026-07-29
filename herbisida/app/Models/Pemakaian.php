<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pemakaian extends Model
{
    protected $fillable = ['block_id', 'jerigen', 'batch', 'waktu'];

    protected $casts = [
        'waktu' => 'datetime',
    ];

    public function block(): BelongsTo
    {
        return $this->belongsTo(Block::class);
    }
}
