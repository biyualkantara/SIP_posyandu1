<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    use HasFactory;

    protected $table = 'kcmtn';
    protected $primaryKey = 'id_kec';
    public $timestamps = false;

    protected $fillable = [
        'nama_kec',
    ];

    public function kelurahan()
    {
        return $this->hasMany(Kelurahan::class, 'id_kec', 'id_kec');
    }
}