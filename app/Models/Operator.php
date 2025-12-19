<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Operator extends Authenticatable
{
    protected $table = 'operator';
    protected $primaryKey = 'id_operator';
    public $timestamps = false;

    protected $hidden = ['password'];

    protected $fillable = [
        'username',
        'password',
        'nama',
        'nama_operator',
        'role',
    ];

    public function setPasswordAttribute($value)
    {
        // jika sudah bcrypt → simpan langsung
        if (Str::startsWith($value, '$2y$')) {
            $this->attributes['password'] = $value;
            return;
        }

        // jika SHA1 lama → upgrade ke bcrypt
        if (strlen($value) === 40 && ctype_xdigit($value)) {
            $this->attributes['password'] = Hash::make($value);
            return;
        }

        // selain itu → plaintext → bcrypt
        $this->attributes['password'] = Hash::make($value);
    }
}