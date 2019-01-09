<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Board extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mac_address', 'producer', 'startup_period','sub_version','version_id','activated','wibu_serial','request_key',
        'license_code_requested_num','last_license_code_requested','startup_code_requested_num','last_startup_code_requested',
        'master','customer','client','note'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
