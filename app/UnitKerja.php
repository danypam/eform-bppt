<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogsActivityInterface;
use Spatie\Activitylog\LogsActivity;

class UnitKerja extends Model implements LogsActivityInterface
{
    use LogsActivity;
    protected $table = 'unit_kerja';
    protected $fillable = ['id','kode_unit','jabatan_id','alamat_id','nama_unit','singkatan_unit','akun_kepala','created_at','updated_at'];

    public function getActivityDescriptionForEvent($eventName)
    {
        if ($eventName == 'created')
        {
            return 'Unit "' . $this->nama_unit . '" was created';
        }

        if ($eventName == 'updated')
        {
            return 'Unit "' . $this->nama_unit . '" was updated';
        }

        if ($eventName == 'deleted')
        {
            return 'Unit "' . $this->nama_unit . '" was deleted';
        }

        return '';
    }
}
