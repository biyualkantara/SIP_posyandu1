<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WuspusKontrasepsi extends Model
{
    protected $table = 'wuspus_kontrasepsi';
    protected $primaryKey = 'id_wuspus_kontrasepsi';
    public $timestamps = false;

    protected $fillable = [
        'id_wuspus',
        'jns_kontrasepsi',
        'tgl_ganti',
        'kontrasepsi_baru',
        'ket',
    ];

    protected $casts = [
        'id_wuspus' => 'integer',
        'tgl_ganti' => 'date:Y-m-d',
    ];
}