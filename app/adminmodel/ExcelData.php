<?php

namespace App\adminmodel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\adminmodel\Users_detailsModal;
use App\Models\unitOwned;

class ExcelData extends Model
{
    protected $table = 'excel_data';
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
        'rel_id',
        'click_id',
        'mail_status',
        'reminder',
        'comment',
        'commodities',
        'Liability',
        'MTC',
        'interchange',
        'batch_name',
        'file1',
        'file2',
        'file3',
        'file4',
        'file5',
        'file6',
        'date',
    ];

    use HasFactory;
    
    public function userDetail()
    {
        return $this->belongsTo(Users_detailsModal::class, 'click_id', 'ajent_id');
    }
    public function unitOwned()
    {
        return $this->belongsTo(unitOwned::class, 'id', 'data_id');
    }
}
