<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    protected $table = 'berita';

    // pimary key
    protected $primaryKey = 'id_berita';

    protected $fillable = [
        'judul',
        'ringkasan',
        'isi',
        'penulis',
        'tanggal_waktu',
    ];

    public $timestamps = false;
}
