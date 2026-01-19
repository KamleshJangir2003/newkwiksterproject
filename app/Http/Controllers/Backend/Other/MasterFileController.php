<?php

namespace App\Http\Controllers\Backend\Other;

use App\Http\Controllers\Controller;
use App\Models\ExcelData;
use App\Models\master_unit_owned;
use App\Models\MasterExcelData;
use App\Models\unitOwned;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class MasterFileController extends Controller
{
    // Master FIle
    public function masterFile()
    {
        $userId = auth()->user()->id;

        if (auth()->user()->designation == 'Manager') {
            $datas = ExcelData::where('rel_id', $userId)
                ->orWhere('click_id', $userId)
                ->orderBy('id', 'DESC')
                ->get();
        } else {
            $datas = ExcelData::where('click_id', $userId)
                ->orderBy('id', 'DESC') // Use the same column for ordering
                ->get();
        }

        return view('backend.masterfile.index', compact('datas'));
    }

    public function masterfileIndex()
    {
        $datas = MasterExcelData::orderBy('id', 'DESC')->get();
        return view('backend.masterfile.masterfile', compact('datas'));
    }
    
    public function masterfileExcelView(){
         $excelData = MasterExcelData::all()->groupBy('batch_name');
        return view('backend.masterfile.masterView',compact('excelData'));
    }
    public function deletemasterfilebatch($batchname)
{
    $excelData = MasterExcelData::where('batch_name', $batchname)->where('click_id',NULL)->get();

    if ($excelData->isNotEmpty()) {
        foreach ($excelData as $data) {
            $data->delete();
        }

        return redirect()->back()->with('success', "$batchname Deleted Successfully.");
    } else {
        return redirect()->back()->with('error', "Something went wrong. Please try again later.");
    }
}

public function masterfilebatchview($batchname){
    $datas = MasterExcelData::where('batch_name',$batchname)->get();
    return view('backend.masterfile.batchfile',compact('datas'));
}

    public function getData($id)
    {
        $unitOwned = master_unit_owned::where('data_id', $id)->first();
        if ($unitOwned) {
            $excelData = MasterExcelData::find($id);

            if (!$unitOwned || !$excelData) {
                return response()->json(['error' => 'Data not found'], 404);
            }

            // Concatenate the data into a single array
            $data = array_merge($unitOwned->toArray(), $excelData->toArray());
        } else {
            $data = MasterExcelData::find($id);
        }

        return response()->json($data);
    }

    public function deleteDuplicateData()
    {
        set_time_limit(300);
        $data = MasterExcelData::where('click_id', NULL)->get();
        $uniquePhoneNumbers = new Collection();
        $duplicateIds = [];
        foreach ($data as $record) {
            if (!$uniquePhoneNumbers->contains('phone', $record->phone)) {
                $uniquePhoneNumbers->push(['phone' => $record->phone]);
            } else {
                $duplicateIds[] = $record->id;
            }
        }
        MasterExcelData::whereIn('id', $duplicateIds)->delete();
        $deletedCount = count($duplicateIds);
        return redirect()->back()->with('success', "$deletedCount duplicate phone data deleted successfully.");
    }

    public function deleteAllData()
    {
        // Get records where 'click_id' is NULL
        $data = MasterExcelData::where('click_id', NULL)->get();

        if ($data->isNotEmpty()) {
            $deletedCount = $data->count();

            // Loop through each record and delete it
            foreach ($data as $record) {
                $record->delete();
            }

            return redirect()->back()->with('success', "$deletedCount data deleted successfully.");
        } else {
            return redirect()->back()->with('success', "No data found to delete.");
        }
    }


     // Update Data
     public function updateMasterData(Request $request)
     {
         $validated = $request->validate([
             'company_name' => 'nullable',
             'phone' => 'nullable',
             'email' => 'nullable',
             'company_rep1' => 'nullable',
             'business_address' => 'nullable',
             'business_city' => 'nullable',
             'business_state' => 'nullable',
             'business_zip' => 'nullable',
             'dot' => 'nullable',
             'mc_docket' => 'nullable',
             'vin' => 'nullable',
             'driver_name' => 'nullable',
             'driver_dob' => 'nullable|date',
             'driver_license' => 'nullable',
             'driver_license_state' => 'nullable',
             'unit_owned' => 'nullable',
             'vehicle_year' => 'nullable',
             'vehicle_make' => 'nullable',
             'stated_value' => 'nullable',
             'form_status' => 'nullable',
             'comment' => 'nullable',
             'reminder' => 'nullable',
         ]);
 
         $validated2 = $request->validate([
             'vin2' => 'nullable',
             'driver_name2' => 'nullable',
             'driver_dob2' => 'nullable',
             'driver_license2' => 'nullable',
             'driver_license_state2' => 'nullable',
             'vehicle_year2' => 'nullable',
             'vehicle_make2' => 'nullable',
             'stated_value2' => 'nullable',
             'vin3' => 'nullable',
             'driver_name3' => 'nullable',
             'driver_dob3' => 'nullable',
             'driver_license3' => 'nullable',
             'driver_license_state3' => 'nullable',
             'vehicle_year3' => 'nullable',
             'vehicle_make3' => 'nullable',
             'stated_value3' => 'nullable',
             'vin4' => 'nullable',
             'driver_name4' => 'nullable',
             'driver_dob4' => 'nullable',
             'driver_license4' => 'nullable',
             'driver_license_state4' => 'nullable',
             'vehicle_year4' => 'nullable',
             'vehicle_make4' => 'nullable',
             'stated_value4' => 'nullable',
             'vin5' => 'nullable',
             'driver_name5' => 'nullable',
             'driver_dob5' => 'nullable',
             'driver_license5' => 'nullable',
             'driver_license_state5' => 'nullable',
             'vehicle_year5' => 'nullable',
             'vehicle_make5' => 'nullable',
             'stated_value5' => 'nullable',
         ]);
 
         // Dynamic form_status_value based on form_status
         $validated['form_status_value'] = ($validated['form_status'] == 'Intrested') ? '100' : (($validated['form_status'] == 'Pipeline') ? '50' : null);
 
         $validated['click_id'] = auth()->user()->id;
 
         $dataId = $request->data_id;
         $unitOwned = master_unit_owned::updateOrCreate(
             ['data_id' => $dataId],
             $validated2
         );
         if ($unitOwned) {
             $request->session()->flash('success', 'Unit Owned Data submitted successfully!');
         }
         $data = MasterExcelData::find($request->data_id);
         if ($data) {
             $data->update($validated);
            //  managerfwd::where('data_id', $request->data_id)->delete();
             $request->session()->flash('success', 'Data submitted successfully!');
         } else {
             $request->session()->flash('error', 'Something went wrong. Please try again!');
         }
 
         return redirect()->back();
     }


}
