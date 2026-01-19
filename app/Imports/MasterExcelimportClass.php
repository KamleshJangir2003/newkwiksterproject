<?php

namespace App\Imports;

use App\Models\MasterExcelData;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class MasterExcelimportClass implements ToCollection
{
    private $batchName;
    protected $rowCount = 0;
    protected $skippedCount = 0;

    public function setBatchName($batchName)
    {
        $this->batchName = $batchName;
    }

    public function collection(Collection $rows)
    {
        // First row = headings
        $columnNames = $rows->shift()->toArray();

        foreach ($rows as $row) {

            // 🔹 Skip blank rows
            if ($row->filter(fn($v) => $v !== null && $v !== '')->count() === 0) {
                continue;
            }

            $data = array_combine($columnNames, $row->toArray());

            $companyName = trim($data['Legal_Name'] ?? '');
            $phone       = trim(strval($data['Phone'] ?? ''));

            // 🔴 Mandatory fields
            if ($companyName === '' || $phone === '') {
                $this->skippedCount++;
                continue;
            }

            // 🔥 Duplicate check
            $exists = MasterExcelData::where('company_name', $companyName)
                        ->where('phone', $phone)
                        ->exists();

            if ($exists) {
                $this->skippedCount++;
                continue;
            }

            // ✅ Insert unique row
            MasterExcelData::create([
                'company_name'       => $companyName,
                'phone'              => $phone,
                'company_rep1'       => $data['Company_Rep1'] ?? null,
                'business_address'   => $data['Business_Address'] ?? null,
                'business_city'      => $data['Business_City'] ?? null,
                'business_state'     => $data['Business_State'] ?? null,
                'business_zip'       => $data['Business_ZIP'] ?? null,
                'dot'                => $data['DOT'] ?? null,
                'mc_docket'          => $data['Docket'] ?? null,
                'email'              => $data['Email'] ?? null,
                'batch_name'         => $this->batchName,
            ]);

            $this->rowCount++;
        }
    }

    public function getRowCount()
    {
        return $this->rowCount;
    }

    public function getSkippedCount()
    {
        return $this->skippedCount;
    }
}
