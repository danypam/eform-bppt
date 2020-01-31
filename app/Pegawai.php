<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogsActivityInterface;
use Spatie\Activitylog\LogsActivity;

class Pegawai extends Model implements LogsActivityInterface
{
    use LogsActivity;

    protected $table = 'pegawai';
    protected $fillable = ['nip','nip18','nama_lengkap','no_hp','email','foto','unit_id','unit_jabatan_id','jabatan_id','user_id','nip_atas','status','role','created_at','updated_at'];

    public function getFoto()
    {
        if (!$this->foto){
            return asset('images/user.png');
        }
        return asset('images/'.$this->foto);
    }

    public function getActivityDescriptionForEvent($eventName)
    {
        if ($eventName == 'created')
        {
            return 'Pegawai "' . $this->nama_lengkap . '" was created';
        }

        if ($eventName == 'updated')
        {
            return 'Pegawai "' . $this->nama_lengkap . '" was updated';
        }

        if ($eventName == 'deleted')
        {
            return 'Pegawai "' . $this->nama_lengkap . '" was deleted';
        }

        return '';
    }
}
