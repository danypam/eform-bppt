<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogsActivityInterface;
use Spatie\Activitylog\LogsActivity;

class UnitJabatan extends Model implements LogsActivityInterface
{
    use LogsActivity;
    protected $primaryKey='id_unit_jabatan';

    protected $table = 'unit_jabatan';
    protected  $fillable = ['kategori','id_unit_jabatan','unit','kode_unitatas1','kode_unitatas2','singkat','is_unit','is_deputi','is_kabppt'];

    public function getActivityDescriptionForEvent($eventName)
    {
        if ($eventName == 'created')
        {
            return 'Unit Jabatan "' . $this->unit . '" was created';
        }

        if ($eventName == 'updated')
        {
            return 'Unit Jabatan "' . $this->unit . '" was updated';
        }

        if ($eventName == 'deleted')
        {
            return 'Unit Jabatan "' . $this->unit . '" was deleted';
        }

        return '';
    }
}
