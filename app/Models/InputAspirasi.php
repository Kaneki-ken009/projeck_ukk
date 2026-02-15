<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InputAspirasi extends Model
{
    protected $table = 'inputaspirasi';
    protected $primaryKey = 'id_inputaspirasi';
    public $timestamps = false;

    protected $fillable = [
        'nisn',
        'id_kategori',
        'lokasi',
        'ket',
        'foto',
        'status',
        'tgl_inputaspirasi',
    ];

    protected $casts = [
        'tgl_inputaspirasi' => 'datetime',
    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    public function feedback(): HasMany
    {
        return $this->hasMany(Feedback::class, 'id_aspirasi', 'id_inputaspirasi');
    }
}
