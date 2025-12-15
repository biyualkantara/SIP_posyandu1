<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wuspus extends Model
{
    protected $table = 'wuspus';
    protected $primaryKey = 'id_wuspus';
    public $timestamps = false;

    protected $fillable = [
        'id_posyandu',
        'nik_wuspus',
        'nama_wuspus',
        'umur',
        'tinggi_ibu',
        'nama_suami',
        'tinggi_ayah',
        'thpn_ks',
        'klmpk_dasawisma',
        'jml_anak_hdp',
        'jml_anak_meninggal',
        'tgl_daftar',
        'status',
        'ket',
    ];

    protected $casts = [
        'id_posyandu' => 'integer',
        'umur' => 'integer',
        'tinggi_ibu' => 'integer',
        'tinggi_ayah' => 'integer',
        'jml_anak_hdp' => 'integer',
        'jml_anak_meninggal' => 'integer',
        'tgl_daftar' => 'date:Y-m-d',
    ];
}