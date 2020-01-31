<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogsActivityInterface;
use Spatie\Activitylog\LogsActivity;

class Alamat extends Model implements LogsActivityInterface
{
    use LogsActivity;

    protected $table = 'alamat';
    protected  $fillable = ['id','alamat'];

    public function getActivityDescriptionForEvent($eventName)
    {
        if ($eventName == 'created')
        {
            return 'alamat "' . $this->alamat . '" was created';
        }

        if ($eventName == 'updated')
        {
            return 'alamat "' . $this->alamat . '" was updated';
        }

        if ($eventName == 'deleted')
        {
            return 'alamat "' . $this->alamat . '" was deleted';
        }

        return '';
    }
}
