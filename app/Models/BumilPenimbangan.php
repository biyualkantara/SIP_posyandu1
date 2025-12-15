<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BumilPenimbangan extends Model
{
    protected $table = 'bumil_pnb';
    protected $primaryKey = 'id_bumil_pnb';
    public $timestamps = false;

    protected $fillable = [
        'id_wuspus',
        'bln_hamil',
        'tgl_pnb',
        'berat',
        'hasil',
        'ket',
    ];
}