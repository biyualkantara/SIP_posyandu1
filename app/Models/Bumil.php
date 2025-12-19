<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bumil extends Model
{
    protected $table = 'bumil';
    protected $primaryKey = 'id_bumil';
    public $timestamps = false;
    public $incrementing = true;

    protected $fillable = [
        'id_wuspus',
        'tgl_daftar',
        'umur_kehamilan',
        'hamil_ke',
        'pmt_pemulihan',
        'lila',
        'ket',
    ];

    protected $casts = [
        'id_bumil' => 'integer',
        'id_wuspus' => 'integer',
        'tgl_daftar' => 'date',
        'umur_kehamilan' => 'integer',
        'hamil_ke' => 'integer',
        'lila' => 'float',
    ];
}