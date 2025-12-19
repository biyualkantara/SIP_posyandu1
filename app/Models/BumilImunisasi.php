<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BumilImunisasi extends Model
{
    protected $table = 'bumil_imun';
    protected $primaryKey = 'id_bumil_imun';
    public $timestamps = false;

    protected $fillable = [
        'id_wuspus',
        'id_imun',
        'tgl_imun',
        'ket',
    ];
}