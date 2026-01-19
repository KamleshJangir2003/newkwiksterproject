<?php

namespace App\Imports;


use App\Models\ExcelData;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Carbon\Carbon;




class ExcelImportClass implements ToCollection
{
    private $batchName;

    protected $rowCount = 0;
    protected $skippedCount = 0;
    protected $invalidCount = 0;

    // Excel-level duplicate company tracker
    protected $excelCompanyUnique = [];

    public function setBatchName($batchName)
    {
        $this->batchName = $batchName;
    }

    public function collection(Collection $rows)
    {
        if ($rows->count() === 0) {
            throw new \Exception('Excel file is empty.');
        }

        // First row = headers
        $columnNames = $rows->shift()->toArray();

        $requiredColumns = [
            'COMPANY_NAME',
            'PHONE_NUMBER',
            'ADDRESS',
            'CITY',
            'STATE',
            'ZIP_CODE'
        ];

        foreach ($requiredColumns as $column) {
            if (!in_array($column, $columnNames)) {
                throw new \Exception("Invalid Excel format. Missing column: {$column}");
            }
        }

        foreach ($rows as $row) {

            // Skip blank rows
            if ($row->filter(fn($v) => $v !== null && $v !== '')->count() === 0) {
                continue;
            }

            $data = array_combine($columnNames, $row->toArray());

            $companyName = trim($data['COMPANY_NAME'] ?? '');
            $phone       = trim((string) ($data['PHONE_NUMBER'] ?? ''));

            if ($companyName === '' || $phone === '') {
                $this->invalidCount++;
                continue;
            }

            // Excel-level duplicate
            $companyKey = strtolower($companyName);
            if (isset($this->excelCompanyUnique[$companyKey])) {
                $this->skippedCount++;
                continue;
            }
            // 🔴 DND CHECK (ADD ONLY THIS)
// 🔴 DND CHECK (same excel_data table)
$isDnd = ExcelData::where('phone', $phone)
            ->where('form_status', 'DND')
            ->exists();

if ($isDnd) {
    $this->skippedCount++;
    continue; // 🚫 already DND → insert nahi hoga
}


// 🟡 INTERESTED / PIPELINE TIME RULE CHECK (NEW LOGIC)
$existingLead = ExcelData::where('phone', $phone)
    ->orderBy('updated_at', 'desc')
    ->first();

if ($existingLead) {

    $status = $existingLead->form_status;
    $lastUpdated = Carbon::parse($existingLead->updated_at);
    $daysPassed = $lastUpdated->diffInDays(now());

    // 🔒 INTERESTED → 80 days
    if ($status === 'Interested' && $daysPassed < 80) {
        $this->skippedCount++;
        continue;
    }

    // 🔒 PIPELINE → 7 days
    if ($status === 'Pipeline' && $daysPassed < 7) {
        $this->skippedCount++;
        continue;
    }
}



            // DB-level duplicate
            $exists = ExcelData::whereRaw(
                'LOWER(company_name) = ?',
                [$companyKey]
            )->exists();

            if ($exists) {
                $this->skippedCount++;
                continue;
            }

            $this->excelCompanyUnique[$companyKey] = true;

            // INSERT DATA
            ExcelData::create([
                'dot'               => $data['DOT'] ?? null,
                'mc_docket'         => $data['MC_DOCKET'] ?? null,
                'company_name'      => $companyName,
                'company_rep1'      => $data['CUSTOMER_REP'] ?? null,
                'phone'             => $phone,
                'business_address'  => $data['ADDRESS'] ?? null,
                'business_city'     => $data['CITY'] ?? null,
                'business_state'    => $data['STATE'] ?? null,
                'business_zip'      => $data['ZIP_CODE'] ?? null,
                'email'             => $data['EMAIL'] ?? null,
                'rel_id'            => session('admin_id'),
                'batch_name'        => $this->batchName,

                // 🔒 FORCE DEFAULT STATUS
               
                'form_status'       => 'NEW',
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

    public function getInvalidCount()
    {
        return $this->invalidCount;
    }
}
