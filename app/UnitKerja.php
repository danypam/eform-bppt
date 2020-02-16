<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnitKerja extends Model
{
    protected $table = 'unit_kerja';
    protected $fillable = ['id','kode_unit','jabatan_id','alamat_id','nama_unit','singkatan_unit','akun_kepala','created_at','updated_at'];
}
