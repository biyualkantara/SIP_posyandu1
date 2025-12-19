<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelurahan extends Model
{
    use HasFactory;

    protected $table = 'klrhn';
    protected $primaryKey = 'id_kel';
    public $timestamps = false;

    protected $fillable = [
        'id_kec',
        'nama_kel',
    ];

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'id_kec', 'id_kec');
    }

    public function duspy()
    {
        return $this->hasMany(Duspy::class, 'id_kel', 'id_kel');
    }
}