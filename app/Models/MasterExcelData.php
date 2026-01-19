<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterExcelData extends Model
{
    use HasFactory;
    protected $table = 'master_excel_data';
    protected $fillable = [
        'company_name',
        'phone',
        'email',
        'company_rep1',
        'business_address',
        'business_city',
        'business_state',
        'business_zip',
        'dot',
        'mc_docket',
        'vin',
        'driver_name',
        'driver_dob',
        'driver_license',
        'driver_license_state',
        'unit_owned',
        'vehicle_year',
        'vehicle_make',
        'stated_value',
        'status',
        'form_status',
        'insured_date',
        'form_status_value',
        'click_id',
        'comment',
        'reminder',
        'batch_name',
    ];
    
    public function managerfwd()
    {
        return $this->hasMany(Managerfwd::class, 'data_id', 'id');
    }
    public function managerfwdsingle()
    {
        return $this->hasOne(Managerfwd::class, 'data_id');
    }
    public function adminfwd()
    {
        return $this->hasOne(Adminfwd::class, 'data_id');
    }
    public function agent()
    {
        return $this->belongsTo(User::class, 'click_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'click_id');
    }
}
