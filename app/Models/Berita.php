<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;

    protected $table = 'berita';
    protected $primaryKey = 'id_berita';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'judul',
        'ringkasan',
        'isi',
        'penulis',
        'kategori',
        'tanggal_waktu'
    ];

    protected $casts = [
        'tanggal_waktu' => 'datetime',
        'id_berita' => 'integer'
    ];
}