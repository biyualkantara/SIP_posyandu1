<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KaderPosyandu extends Model
{
    protected $table = 'kader_posyandu';

    protected $fillable = [
        'duspy_id',
        'nama',
        'umur',
        'jabatan',
        'no_hp',
        'alamat',
        'status',
        'foto',
    ];

    public function duspy(): BelongsTo
    {
        return $this->belongsTo(Duspy::class, 'duspy_id');
    }
}
