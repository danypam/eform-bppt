<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnitJabatan extends Model
{
    protected $primaryKey='id_unit_jabatan';

    protected $table = 'unit_jabatan';
    protected  $fillable = ['kategori','id_unit_jabatan','unit','kode_unitatas1','kode_unitatas2','singkat','is_unit','is_deputi','is_kabppt'];

}
