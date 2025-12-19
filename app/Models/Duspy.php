<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Duspy extends Model
{
    protected $table = 'duspy';
    protected $primaryKey = 'id_posyandu';
    public $timestamps = false;

    public $incrementing = true;
    protected $fillable = [
        'id_kel',
        'nama_posyandu',
        'strata_psy',
        'alamat_posyandu',
        'pj_umum',
        'pj_operasional',
        'ketuplak',
        'sekretaris',
        'int_paud',
        'int_bkd',
        'int_terpadu',
        'kader_aktif',
        'kader_taktif',
        'ptgs_kb',
        'ptgs_medis',
        'ptgs_bidan',
    ];

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class, 'id_kel');
    }

    protected $casts = [
        'id_posyandu'   => 'integer',
        'id_kel'        => 'integer',
        'int_paud'      => 'integer',
        'int_bkd'       => 'integer',
        'int_terpadu'   => 'integer',
        'kader_aktif'   => 'integer',
        'kader_taktif'  => 'integer',
    ];
}