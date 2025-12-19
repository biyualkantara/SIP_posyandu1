<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BayiWafat extends Model
{
    protected $table = "bayi_wafat";
    protected $primaryKey = "id_wafat";

    protected $fillable = [
        'id_bayi',
        'tgl_kematian',
        'ket',
    ];

    public $timestamps = false;
}  