<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class interested_leads implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct(Collection $data)
    {
        $this->data = $data;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->data->map(function ($item) {
            return [
                'Date' => $item->date,
                'MC' => $item->mc_docket,
                'Company Name' => $item->company_name,
                'Address' => $item->business_address,
                'City' => $item->business_city,
                'State' => $item->business_state,
                'Zip' => $item->business_zip,
                'Phone Number' => $item->phone,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Date',
            'MC',
            'Company Name',
            'Address',
            'City',
            'State',
            'Zip',
            'Phone Number',
        ];
    }
}
