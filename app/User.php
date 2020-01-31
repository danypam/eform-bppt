<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Activitylog\LogsActivityInterface;
use Spatie\Activitylog\LogsActivity;

class User extends Authenticatable implements LogsActivityInterface
{
    use LogsActivity;
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function pegawai(){
        return $this->hasOne(Pegawai::class);
    }
    protected $fillable = [
        'name', 'email', 'password','status',
    ];

    public function getActivityDescriptionForEvent($eventName)
    {
        if ($eventName == 'created')
        {
            return 'User "' . $this->name . '" was created';
        }

//        if ($eventName == 'updated')
//        {
//            return 'User "' . $this->name . '" was updated';
//        }

        if ($eventName == 'deleted')
        {
            return 'User "' . $this->name . '" was deleted';
        }

        return '';
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
