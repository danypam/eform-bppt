<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{

    protected $table = 'jabatan';
    protected  $fillable = ['id','nama_jabatan','eselon','created_at','updated_at'];

//    public static $edit_validation_rules=[
//        'nama_jabatan'=>'required|exists:jabatan|regex:/^[A-Z\s]+$/',
//        'eselon'=>'required|min:1|regex:\^[A-Z]+\.[a-z]+$/'
//    ];
}
