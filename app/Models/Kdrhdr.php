<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kdrhdr extends Model
{
    protected $table = 'kdrhdr';
    protected $primaryKey = 'id_kdrhdr';
    public $timestamps = false;

    protected $fillable = [
        'id_posyandu',
        'pkk',
        'plkb',
        'medis',
    ];
}