<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KaderKehadiran extends Model
{
    protected $table = 'kdrhdr';
    protected $primaryKey = 'id_kdrhdr';
    public $timestamps = false;

    protected $fillable = [
        'id_posyandu',
        'bulan/tahun',
        'pkk',
        'plkb',
        'medis',
    ];

    protected $casts = [
        'pkk' => 'integer',
        'plkb' => 'integer',
        'medis' => 'integer',
        'bulan/tahun' => 'date:Y-m-d',
    ];

    public function posyandu(): BelongsTo
    {
        return $this->belongsTo(Duspy::class, 'id_posyandu', 'id_posyandu');
    }

    // Helper biar Vue enak: ambil YYYY-MM dari `bulan/tahun`
    public function getBulanTahunYmAttribute(): ?string
    {
        $v = $this->{'bulan/tahun'};
        if (!$v) return null;
        return \Illuminate\Support\Carbon::parse($v)->format('Y-m');
    }
}