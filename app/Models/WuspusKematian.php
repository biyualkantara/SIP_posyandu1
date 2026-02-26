<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WuspusKematian extends Model
{
    use HasFactory;

    protected $table = 'wuspus_kematians';

    protected $fillable = [
        'id_wuspus',
        'tgl_wafat',
        'penyebab',
        'ket',
    ];
}