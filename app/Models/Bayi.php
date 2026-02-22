<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bayi extends Model
{
    protected $table = 'bayi';
    protected $primaryKey = 'id_bayi';
    public $timestamps = false;

    protected $fillable = [
        'id_wuspus',
        'tgl_daftar',
        'nama_bayi',
        'jk',
        'tgl_lhr',
        'bb',
        'ket'
    ];

    // Relasi ke WUS/PUS (IBU)
    public function wuspus()
    {
        return $this->belongsTo(Wuspus::class, 'id_wuspus', 'id_wuspus');
    }

    // Relasi ke penimbangan
    public function penimbangan()
    {
        return $this->hasMany(BayiPnb::class, 'id_bayi', 'id_bayi');
    }

    // Relasi ke imunisasi
    public function imunisasi()
    {
        return $this->hasMany(BayiImun::class, 'id_bayi', 'id_bayi');
    }

    // Relasi ke kematian
    public function wafat()
    {
        return $this->hasOne(BayiWafat::class, 'id_bayi', 'id_bayi');
    }
}