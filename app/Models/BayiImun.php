<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BayiImun extends Model
{
    protected $table = "bayi_imun";
    protected $primaryKey = "id_bayi_imun";

    protected $fillable = [
        'id_bayi',
        'id_imun',
        'tgl_imun',
        'ket',
    ];

    public $timestamps = false;
}