<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    protected $fillable = [
    'nama','nama_wali','lahir','jk','no_telp','agama','provinsi','kota','hobi','foto'
    ];
}
