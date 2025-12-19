<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WuspusImunisasi extends Model
{
    protected $table = 'wuspus_imun';
    protected $primaryKey = 'id_wuspus_imun';
    public $timestamps = false;

    protected $fillable = [
        'id_wuspus',
        'id_imun',
        'tgl_imun',
        'ket',
    ];

    protected $casts = [
        'id_wuspus' => 'integer',
        'id_imun' => 'integer',
        'tgl_imun' => 'date:Y-m-d',
    ];
}