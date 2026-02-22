<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BayiImunisasi extends Model
{
    protected $table = 'bayi_imun';
    protected $primaryKey = 'id_bayi_imun';
    public $timestamps = false;

    protected $guarded = [];
}