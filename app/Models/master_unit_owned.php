<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class master_unit_owned extends Model
{
    protected $table = 'master_unit_owneds';
    protected $fillable = [
        'data_id',
        'vin2',
        'driver_name2',
        'driver_dob2',
        'driver_license2',
        'driver_license_state2',
        'vehicle_year2',
        'vehicle_make2',
        'stated_value2',
        'vin3',
        'driver_name3',
        'driver_dob3',
        'driver_license3',
        'driver_license_state3',
        'vehicle_year3',
        'vehicle_make3',
        'stated_value3',
        'vin4',
        'driver_name4',
        'driver_dob4',
        'driver_license4',
        'driver_license_state4',
        'vehicle_year4',
        'vehicle_make4',
        'stated_value4',
        'vin5',
        'driver_name5',
        'driver_dob5',
        'driver_license5',
        'driver_license_state5',
        'vehicle_year5',
        'vehicle_make5',
        'stated_value5',
    ];
    use HasFactory;
}
