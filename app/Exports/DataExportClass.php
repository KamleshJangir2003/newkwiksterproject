<?php

namespace App\Exports;

use App\Models\ExcelData; // Replace with your actual model
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DataExportClass implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
       return $this->data->map(function ($item) {
        return [
            'company_name'=>$item->company_name,
        'phone'=>$item->phone,
        'email'=>$item->email,
        'company_rep1'=>$item->company_rep1,
        'company_rep2'=>$item->company_rep2,
        'business_address'=>$item->business_address,
        'business_city'=>$item->business_city,
        'business_state'=>$item->business_state,
        'business_zip'=>$item->business_zip,
        'dot'=>$item->dot,
        'mc_docket'=>$item->mc_docket,
        'vin'=>$item->vin,
        'driver_name'=>$item->driver_name,
        'driver_dob'=>$item->driver_dob,
        'driver_license'=>$item->driver_license,
        'driver_license_state'=>$item->driver_license_state,
        'unit_owned'=>$item->unit_owned,
        'vehicle_year'=>$item->vehicle_year,
        'vehicle_make'=>$item->vehicle_make,
        'stated_value'=>$item->stated_value,
        'status'=>$item->status,
        'form_status'=>$item->form_status,
        'insured_date'=>$item->insured_date,
        'form_status_value'=>$item->form_status_value,
        'reminder'=>$item->reminder,
        'comment'=>$item->comment,
        'commodities'=>$item->commodities,
        'batch_name'=>$item->batch_name,
        'created_at'=>$item->created_at,
        ];
    });
    }

    public function headings(): array
    {
        // Define your column headings
       return [
        'company_name',
        'phone',
        'email',
        'company_rep1',
        'company_rep2',
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
        'reminder',
        'comment',
        'commodities',
        'batch_name',
        'created_at',
        // ... add more columns as needed
    ];
    }
}
