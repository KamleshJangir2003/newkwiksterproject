<?php

namespace App\Http\Controllers;

use App\Imports\ExcelImportClass;
use App\Imports\MasterExcelimportClass;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\adminmodel\Tab_view_lead;
use App\adminmodel\ExcelData;   // ✅ CORRECT MODEL
use Illuminate\Support\Facades\Log;

class ExcelController extends Controller
{
    /**
     * =======================
     * NORMAL LEADS IMPORT
     * =======================
     */
    public function import(Request $request)
    {
        try {

            // -----------------------
            // BASIC VALIDATION
            // -----------------------
            $request->validate([
                'excel_file' => 'required|mimes:xlsx,xls',
                'batch_name' => 'required',
            ]);

            /**
             * 🔥 IMPORTANT LOGIC
             * New Excel upload se pehle
             * sirf in 3 status ka purana data delete hoga
             */
       // 🔁 RESET OLD ADMIN LEADS ON EVERY EXCEL UPLOAD
// ExcelData::where('status', 'forwarded')
//     ->whereIn('form_status', [
//         'Voice Mail',
//         'Not Connected',
//         'Not Intrested'
//     ])
//     ->update([
//         'form_status' => 'NEW',

//         'date' => now(),   
//     ]);
// 🔢 STEP 1: Count reset leads
// 🔢 STEP 1: Count reset leads
$resetCount = ExcelData::where('status', 'forwarded')
    ->whereIn('form_status', [
        'Voice Mail',
        'Not Connected',
        'Not Intrested'
    ])
    ->count();

// 🔁 STEP 2: Reset leads
ExcelData::where('status', 'forwarded')
    ->whereIn('form_status', [
        'Voice Mail',
        'Not Connected',
        'Not Intrested'
    ])
    ->update([
        'form_status' => 'NEW',
        'date' => now(),
    ]);

// ✅ STEP 3: RESET DATA → TAB VIEW ENTRY (MISSING PART)
if ($resetCount > 0) {

    $resetBatchName = 'RESET_' . now()->format('Ymd_His');

    $tab_view = new Tab_view_lead();
    $tab_view->team_id    = session('admin_id');
    $tab_view->total_data = $resetCount;
    $tab_view->batch      = $resetBatchName;
    $tab_view->save();
}






            // -----------------------
            // UNIQUE BATCH NAME
            // -----------------------
            $uniqueBatchName = $request->batch_name . '_' . now()->format('Ymd_His');

            // -----------------------
            // PREPARE IMPORT
            // -----------------------
            $file = $request->file('excel_file');
            $importClass = new ExcelImportClass();
            $importClass->setBatchName($uniqueBatchName);

            // -----------------------
            // RUN IMPORT
            // -----------------------
            Excel::import($importClass, $file);

            // -----------------------
            // RESULTS
            // -----------------------
            $importedRows = $importClass->getRowCount();
            $skippedRows  = $importClass->getSkippedCount();
            $invalidRows  = $importClass->getInvalidCount();

            // -----------------------
            // SUCCESS CASE
            // -----------------------
            if ($importedRows > 0) {

                $tab_view = new Tab_view_lead();
                $tab_view->team_id    = session('admin_id');
                $tab_view->total_data = $importedRows;
                $tab_view->batch      = $uniqueBatchName;
                $tab_view->save();

                return redirect()->back()->with(
                    'success',
                    "$importedRows rows imported successfully. "
                    . "$skippedRows duplicate rows skipped. "
                    . "$invalidRows invalid rows skipped."
                );
            }

            // -----------------------
            // INVALID DATA ONLY
            // -----------------------
            if ($invalidRows > 0) {
                return redirect()->back()->with(
                    'error',
                    "Invalid data found. $invalidRows rows missing mandatory fields."
                );
            }

            // -----------------------
            // DUPLICATES ONLY
            // -----------------------
            return redirect()->back()->with(
                'error',
                "No new data imported. $skippedRows duplicate rows found."
            );

        } catch (\Exception $e) {

            Log::error('Excel Import Error', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * =======================
     * MASTER LEADS IMPORT
     * =======================
     */
    public function masterimport(Request $request)
    {
        try {

            $request->validate([
                'excel_file' => 'required|mimes:xlsx,xls',
                'batch_name' => 'required',
            ]);

            $file = $request->file('excel_file');
            $importClass = new MasterExcelimportClass();
            $importClass->setBatchName($request->batch_name);

            Excel::import($importClass, $file);

            $importedRows = $importClass->getRowCount();
            $skippedRows  = $importClass->getSkippedCount();

            if ($importedRows > 0) {
                return redirect()->back()->with(
                    'success',
                    "$importedRows rows imported successfully. "
                    . "$skippedRows duplicate rows skipped."
                );
            }

            return redirect()->back()->with(
                'error',
                "No new data imported. $skippedRows duplicate rows found."
            );

        } catch (\Exception $e) {

            Log::error('Master Excel Import Error', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);

            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
