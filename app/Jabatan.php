<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogsActivityInterface;
use Spatie\Activitylog\LogsActivity;

class Jabatan extends Model implements LogsActivityInterface
{
    use LogsActivity;

    protected $table = 'jabatan';
    protected  $fillable = ['id','nama_jabatan','eselon','created_at','updated_at'];

    public function getActivityDescriptionForEvent($eventName)
    {
        if ($eventName == 'created')
        {
            return 'Jabatan "' . $this->nama_jabatan . '" was created';
        }

        if ($eventName == 'updated')
        {
            return 'Jabatan "' . $this->nama_jabatan . '" was updated';
        }

        if ($eventName == 'deleted')
        {
            return 'Jabatan "' . $this->nama_jabatan . '" was deleted';
        }

        return '';
    }
//    public static $edit_validation_rules=[
//        'nama_jabatan'=>'required|exists:jabatan|regex:/^[A-Z\s]+$/',
//        'eselon'=>'required|min:1|regex:\^[A-Z]+\.[a-z]+$/'
//    ];
}
