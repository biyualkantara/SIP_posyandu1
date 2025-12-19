<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bayi extends Model
{
    protected $table = "bayi";
    protected $primaryKey = "id_bayi";

    protected $fillable = [
        'id_wuspus', 'tgl_daftar', 'nama_bayi', 'jk', 'tgl_lhr', 'bb', 'ket'
    ];

    public $timestamps = false;
}