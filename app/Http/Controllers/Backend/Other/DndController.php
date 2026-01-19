<?php

namespace App\Http\Controllers\Backend\Other;

use App\Http\Controllers\Controller;
use App\Models\ExcelData;
use App\Models\master_unit_owned;
use App\Models\MasterExcelData;
use App\Models\DndData;
use App\Models\unitOwned;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class DndController extends Controller
{
    
    public function deleteDndData()
    {
        set_time_limit(300);
        // Get records where 'phone' is NULL
        $data = DndData::where('phone', '!=' ,'')->get();
        if ($data->isNotEmpty()) {
            $dndIds = [];
            foreach ($data as $record) {
                $dndIds[] = $record->phone;
            }
            $masterData = MasterExcelData::whereIn('phone', $dndIds)->get();
            if ($masterData->isNotEmpty()) {
                $deletedCount = $masterData->count();
                $deleteIds = [];
                foreach ($masterData as $record) {
                    $deleteIds[] = $record->id;
                }
                MasterExcelData::whereIn('id', $deleteIds)->delete();
            }else{
                $deletedCount = 0;
            }
            return redirect()->back()->with('success', "$deletedCount DND data successfully removed.");
        } else {
            return redirect()->back()->with('success', "No DND data found to delete.");
        }
    }

    // Mark DND
    public function markDndMasterData($id)
    {
        if ($id == '') {
            return redirect()->back()->with('error', 'Invalid request id!');
		}else {
            $data = MasterExcelData::where('id',$id)->first();
            if($data){
                $master_id = $id;
                $dnd_exist = DndData::where('phone', $data->phone)->first();
                if(!$dnd_exist){
                    DndData::create([
                        'company_name' => $data->company_name, 
                        'phone' => $data->phone, 
                        'email' => $data->email, 
                        'company_rep1' => $data->company_rep1, 
                        'business_address' => $data->business_address, 
                        'business_city' => $data->business_city, 
                        'business_state' => $data->business_state, 
                        'business_zip' => $data->business_zip, 
                        'dot' => $data->dot, 
                        'mc_docket' => $data->mc_docket, 
                        'vin' => $data->vin, 
                        'driver_name' => $data->driver_name, 
                        'driver_dob' => $data->driver_dob, 
                        'driver_license' => $data->driver_license, 
                        'driver_license_state' => $data->driver_license_state, 
                        'unit_owned' => $data->unit_owned, 
                        'vehicle_year' => $data->vehicle_year, 
                        'vehicle_make' => $data->vehicle_make, 
                        'stated_value' => $data->stated_value, 
                        'status' => $data->status, 
                        'form_status' => $data->form_status, 
                        'insured_date' => $data->insured_date, 
                        'form_status_value' => $data->form_status_value, 
                        'click_id' => $data->click_id, 
                        'reminder' => $data->reminder, 
                        'comment' => $data->comment
                    ]);
                }
                MasterExcelData::where('id', $master_id)->delete();
                return redirect()->back()->with('success', 'Successfully marked as DND and removed from master!');
            }else{
                return redirect()->back()->with('error', 'Something went wrong. Please try again!');
            }
        }
        return redirect()->back();
    }


}
