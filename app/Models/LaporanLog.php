<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class LaporanLog extends Model
{
    protected $table = 'laporan_log';

    protected $fillable = [
        'admin_id',
        'admin_username',
        'file_type',
        'period_type',
        'period_start',
        'period_end',
        'file_path',
        'note',
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
