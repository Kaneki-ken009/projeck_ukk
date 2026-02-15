<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Feedback extends Model
{
    protected $table = 'feedback';

    public const UPDATED_AT = null;

    protected $fillable = [
        'id_aspirasi',
        'nisn',
        'isi_feedback',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function aspirasi(): BelongsTo
    {
        return $this->belongsTo(
            InputAspirasi::class, 
            'id_aspirasi', 
            'id_inputaspirasi'
        );
    }
}
