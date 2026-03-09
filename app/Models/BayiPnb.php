<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BayiPnb extends Model
{
    protected $table = "bayi_pnb";
    protected $primaryKey = "id_bayi_pnb";

    protected $fillable = [
        'id_bayi',
        'tgl_pnb',
        'berat',
        'hasil',
        'pmt',
        'keterangan',
    ];

    public $timestamps = false;

    public function dataBayi() {
        return $this->belongsTo(DataBayi::class,"id_bayi","id_bayi");
    }
}