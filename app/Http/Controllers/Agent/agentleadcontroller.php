<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\managerfwd;
use App\Models\ExcelData;
use App\Models\unitOwned;
use App\Models\Notification;
use App\Models\dayendreport;
use App\Mail\Intrested_form;
use App\adminmodel\SalaryModal;
use App\Models\LeadStatusHistory;
use App\adminmodel\Interested_email;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class agentleadcontroller extends Controller
{
	public function agent_incoming_leads(Request $req, $n='')
	{ 
        if(!empty($n)){
            $noti = Notification::where('id',$n)->first();
            $noti->click_id = 2;
            $noti->save();
        }       
        $leads = managerfwd::where('agent_id',session('agent_id'))->latest()->get();

		return view('Agent/leads/incoming',compact('leads'));	
	}
    public function agent_view_data(Request $req, $id)
	{        
        $id = base64_decode($id);
        
        $leads = managerfwd::where('id',$id)->first();
        
        if ($leads) {
            $lead_ids = json_decode($leads->data_id);
            $lead_ids_string = $lead_ids[0]; // Extract the first (and only) element of the array
            $lead_ids_array = explode(',', $lead_ids_string);
        
            if ($lead_ids && is_array($lead_ids)) {
                // Retrieve ExcelData records based on the array of lead IDs
                $datas = ExcelData::whereIn('id', $lead_ids_array)->get();
                return view('Agent/leads/view_data',compact('datas','id'));	
            } else {
                return redirect()->back();
            }
        } else {
            return redirect()->back();
        }		
	}
// 	 public function viewDataTimezone(Request $req, $timezone, $id)
//     {
//         // Decode the base64 ID
//         $id = base64_decode($id);
        
//         // Get the lead based on the ID
//         $leads = managerfwd::where('id', $id)->first();
        
//         if ($leads) {
//             // Extract the lead IDs from the JSON data
//             $lead_ids = json_decode($leads->data_id);
//             $lead_ids_string = $lead_ids[0]; // Extract the first (and only) element of the array
//             $lead_ids_array = explode(',', $lead_ids_string);
    
//             if ($lead_ids && is_array($lead_ids)) {
//                 // Define a mapping of states to their respective main timezones
//                 $stateTimezones = [
//                     // Pacific Time
//                     'CA' => 'Pacific Time',  // California
//                     'OR' => 'Pacific Time',  // Oregon
//                     'WA' => 'Pacific Time',  // Washington
//                     'NV' => 'Pacific Time',  // Nevada
                
//                     // Mountain Time
//                     'MT' => 'Mountain Time', // Montana
//                     'CO' => 'Mountain Time', // Colorado
//                     'NM' => 'Mountain Time', // New Mexico
//                     'UT' => 'Mountain Time', // Utah
//                     'WY' => 'Mountain Time', // Wyoming
//                     'AZ' => 'Mountain Time', // Arizona (except the Navajo Nation, which follows Daylight Saving Time)
//                     'ID' => 'Mountain Time', // Idaho (eastern part)
                
//                     // Central Time
//                     'TX' => 'Central Time',  // Texas (most parts)
//                     'AL' => 'Central Time',  // Alabama
//                     'AR' => 'Central Time',  // Arkansas
//                     'IL' => 'Central Time',  // Illinois
//                     'IA' => 'Central Time',  // Iowa
//                     'KS' => 'Central Time',  // Kansas
//                     'LA' => 'Central Time',  // Louisiana
//                     'MN' => 'Central Time',  // Minnesota
//                     'MS' => 'Central Time',  // Mississippi
//                     'MO' => 'Central Time',  // Missouri
//                     'NE' => 'Central Time',  // Nebraska
//                     'ND' => 'Central Time',  // North Dakota (southern part)
//                     'OK' => 'Central Time',  // Oklahoma
//                     'SD' => 'Central Time',  // South Dakota (eastern part)
//                     'TN' => 'Central Time',  // Tennessee
//                     'WI' => 'Central Time',  // Wisconsin
                
//                     // Eastern Time
//                     'CT' => 'Eastern Time',  // Connecticut
//                     'DE' => 'Eastern Time',  // Delaware
//                     'FL' => 'Eastern Time',  // Florida
//                     'GA' => 'Eastern Time',  // Georgia
//                     'IN' => 'Eastern Time',  // Indiana
//                     'KY' => 'Eastern Time',  // Kentucky
//                     'ME' => 'Eastern Time',  // Maine
//                     'MD' => 'Eastern Time',  // Maryland
//                     'MA' => 'Eastern Time',  // Massachusetts
//                     'MI' => 'Eastern Time',  // Michigan
//                     'NH' => 'Eastern Time',  // New Hampshire
//                     'NJ' => 'Eastern Time',  // New Jersey
//                     'NY' => 'Eastern Time',  // New York
//                     'NC' => 'Eastern Time',  // North Carolina
//                     'OH' => 'Eastern Time',  // Ohio
//                     'PA' => 'Eastern Time',  // Pennsylvania
//                     'RI' => 'Eastern Time',  // Rhode Island
//                     'SC' => 'Eastern Time',  // South Carolina
//                     'VT' => 'Eastern Time',  // Vermont
//                     'VA' => 'Eastern Time',  // Virginia
//                     'WV' => 'Eastern Time',  // West Virginia
//                     'DC' => 'Eastern Time',  // District of Columbia (Washington D.C.)
//                 ];
                
    
//                 // Retrieve ExcelData records based on the array of lead IDs
//                 $datasexcel = ExcelData::whereIn('id', $lead_ids_array)->get();  // Fetch data from DB
    
//                 // Filter the data based on the selected timezone
//                 $datas = $datasexcel->filter(function ($data) use ($timezone, $stateTimezones) {
//                     // Get the state from the business_state field
//                     $state = $data->business_state;
    
//                     // If the state is empty, default to Eastern Time
//                     if (empty($state)) {
//                         $state = 'DC'; // Default state to 'DC' for Eastern Time (Washington D.C.)
//                     }
    
//                     // Check if the state exists in the stateTimezones mapping and if it matches the selected timezone
//                     if (isset($stateTimezones[$state]) && $stateTimezones[$state] === $timezone) {
//                         return true;
//                     }
    
//                     return false;
//                 });
    
//                 // Execute the query and fetch the filtered data
//                 return view('Agent/leads/view_data', compact('datas', 'id', 'timezone'));
//             } else {
//                 return redirect()->back();
//             }
//         } else {
//             return redirect()->back();
//         }
//     }
public function viewDataTimezone(Request $req, $timezone, $id)
{
    // Decode the base64 ID
    $id = base64_decode($id);

    // Get the lead based on the ID
    $leads = managerfwd::where('id', $id)->first();
    
    if (!$leads) {
        return redirect()->back();
    }

    // Extract the lead IDs from the JSON data
    $lead_ids = json_decode($leads->data_id);
    $lead_ids_string = $lead_ids[0] ?? '';
    $lead_ids_array = explode(',', $lead_ids_string);

    if (!$lead_ids || !is_array($lead_ids)) {
        return redirect()->back();
    }

    // Define state-to-timezone mapping
    $stateTimezones = [
        'CA' => 'Pacific Time', 'OR' => 'Pacific Time', 'WA' => 'Pacific Time', 'NV' => 'Pacific Time',
        'MT' => 'Mountain Time', 'CO' => 'Mountain Time', 'NM' => 'Mountain Time', 'UT' => 'Mountain Time',
        'WY' => 'Mountain Time', 'AZ' => 'Mountain Time', 'ID' => 'Mountain Time',
        'TX' => 'Central Time', 'AL' => 'Central Time', 'AR' => 'Central Time', 'IL' => 'Central Time',
        'IA' => 'Central Time', 'KS' => 'Central Time', 'LA' => 'Central Time', 'MN' => 'Central Time',
        'MS' => 'Central Time', 'MO' => 'Central Time', 'NE' => 'Central Time', 'ND' => 'Central Time',
        'OK' => 'Central Time', 'SD' => 'Central Time', 'TN' => 'Central Time', 'WI' => 'Central Time',
        'CT' => 'Eastern Time', 'DE' => 'Eastern Time', 'FL' => 'Eastern Time', 'GA' => 'Eastern Time',
        'IN' => 'Eastern Time', 'KY' => 'Eastern Time', 'ME' => 'Eastern Time', 'MD' => 'Eastern Time',
        'MA' => 'Eastern Time', 'MI' => 'Eastern Time', 'NH' => 'Eastern Time', 'NJ' => 'Eastern Time',
        'NY' => 'Eastern Time', 'NC' => 'Eastern Time', 'OH' => 'Eastern Time', 'PA' => 'Eastern Time',
        'RI' => 'Eastern Time', 'SC' => 'Eastern Time', 'VT' => 'Eastern Time', 'VA' => 'Eastern Time',
        'WV' => 'Eastern Time', 'DC' => 'Eastern Time',
    ];

    // Build query for timezone filtering
    $query = ExcelData::whereIn('id', $lead_ids_array);
    
    // Apply timezone filter
    $query->where(function($q) use ($timezone, $stateTimezones) {
        foreach ($stateTimezones as $state => $tz) {
            if ($tz === $timezone) {
                $q->orWhere('business_state', $state);
            }
        }
        // Handle empty/invalid states as Pacific Time
        if ($timezone === 'Pacific Time') {
            $q->orWhereNull('business_state')
              ->orWhere('business_state', '')
              ->orWhereNotIn('business_state', array_keys($stateTimezones));
        }
    });

    // Add pagination - 25 leads per page
    $datas = $query->paginate(25);

    // Define which agent IDs should use MightyCall view
    $mightyCallUserIds = [1]; // Replace with your specific agent IDs
    $agentId = session('agent_id');

    // Return the appropriate view
    if (in_array($agentId, $mightyCallUserIds)) {
        $secretKey = SalaryModal::where('ajent_id', $agentId)->value('type');
        $apiKey = config('services.mightycall.api_key');
        return view('Agent/leads/view_data_mighty_call', compact('datas', 'id', 'timezone', 'secretKey', 'apiKey'));
    } else {
        return view('Agent/leads/view_data', compact('datas', 'id', 'timezone'));
    }
}



   public function agent_status_update(Request $req)
    {
        DB::transaction(function () use ($req) {
            // Set the time zone and get the current date
            $timeZone = 'America/New_York';
            $currentDate = Carbon::now($timeZone);
            $date = $currentDate->format('Y-m-d');
        
            // Get the lead ID and status from the request
            $id = $req->lead_id;
            $status = $req->status;
        
            // Update the lead's status, click ID, and date
            $lead = ExcelData::where('id', $id)->lockForUpdate()->first(); // Lock the row for update
            if ($lead) {
                $lead->form_status = $status;
                $lead->click_id = session('agent_id');
                $lead->date = $date;
                $lead->save();
            }
        
            // If manager forward ID is provided, update manager forward data
            if (!empty($req->mangerfwd)) {
                $update = managerfwd::where('id', $req->mangerfwd)->lockForUpdate()->first(); // Lock row for update
                if ($update) {
                    $data_id = json_decode($update->data_id, true); // Decode as array
                    if (is_array($data_id) && isset($data_id[0])) {
                        // Decode first element (expecting it to be a comma-separated string)
                        $ids = explode(',', $data_id[0]);
                        $total = count($ids);
        
                        // Find the index of the lead ID in the array and remove it
                        $index = array_search($id, $ids);
                        if ($index !== false) {
                            unset($ids[$index]); // Remove the ID
                            $ids = array_values($ids); // Reindex the array
        
                            // Encode the modified array back to JSON and update the database
                            $updatedJsonData = json_encode([implode(',', $ids)]);
                            $update->data_id = $updatedJsonData;
                            $update->save();
        
                            // If there are no more IDs left, delete the manager forward entry
                            if ($total == 1) {
                                $update->delete();
                            }
        
                            return response()->json([
                                'message' => 'Status updated successfully',
                                'status' => $status
                            ]);
                        } else {
                            // Handle case when the value is not found in the array
                            return response()->json(['error' => 'Value not found in array'], 404);
                        }
                    } else {
                        // Handle case where `data_id` is not an array or not properly formatted
                        return response()->json(['error' => 'Invalid data_id format'], 400);
                    }
                }
            }
        });
         $this->updateLeadStatus($req->lead_id,$req->status);
     if($req->status !== "Restricted")
        {
            $this->add_total_call();
        }
        return response()->json([
            'message' => 'Status updated successfully',
            'status' => $req->status
        ]);
    }
    public function agent_mailstatus_update(Request $req){
         
        $timeZone = 'America/New_York';

        $currentDate = Carbon::now($timeZone);

        $date = $currentDate->format('Y-m-d');


        $id = $req->lead_id;
        $status = $req->status;
    $lead = ExcelData::where('id', $id)->first();
    if (!empty($lead->mail_status)) {
        if ((string)$lead->mail_status !== $req->status) {  // Cast to string for comparison
            if ($lead->mail_status !== "2") {
                $status = 2;
            } else {
                if ($req->status == "Mail") {
                    $status = "Message"; 
                } else {
                    $status = "Mail"; 
                }
            }
        } else {
            if ($lead->mail_status == 2) {
                if ($req->status == "Mail") {
                    $status = "Message"; 
                } else {
                    $status = "Mail"; 
                }
            } else {
                $status = null;
            }
        }
    } else {
        $status = $req->status;
    }
    $lead->mail_status = $status;
    $lead->click_id = session('agent_id');
    $lead->date = $date;
    $lead->save();
  return response()->json([
    'message' => 'Status updated successfully',
    'status' => $req->status // Include the updated status in the response
   ]);
    
    
    }
   public function updateData(Request $request)
    {
        // 🔒 80-day duplicate block ONLY if lead already INTERESTED
$existingLead = ExcelData::where('dot', $request->dot)
    ->where('phone', $request->phone)
    ->where('form_status', 'Intrested')
    ->first();

if ($existingLead) {
    $daysPassed = Carbon::parse($existingLead->created_at)->diffInDays(now());

    // dob change होने पर भी 80 दिन से पहले upload block
    if ($daysPassed < 80) {
        return redirect()->back()->with('error',
            "This lead was already marked Interested. You can upload it again only after 80 days. "
        );
    }
}

/* ==============================
   2️⃣ PIPELINE LEAD – 10 DAYS BLOCK
   ============================== */
$pipelineLead = ExcelData::where('dot', $request->dot)
    ->where('phone', $request->phone)
    ->where('form_status', 'Pipeline')
    ->orderBy('created_at', 'desc')
    ->first();

if ($pipelineLead) {
    $daysPassed = Carbon::parse($pipelineLead->created_at)->diffInDays(now());

    if ($daysPassed < 10) {
        return redirect()->back()->with('error',
            "⚠️ This lead already exists in Pipeline. You can upload it again only after 10 days. ($daysPassed days passed)"
        );
    }
}


   
      
        //old code//
        $interestedChecks = ExcelData::where('dot', $request->dot)
        ->where('form_status', 'Intrested')
        ->select('dot', 'click_id', 'form_status')
        ->get();
   
    // Check if there are any 'Interested' records for the same dot
    if ($interestedChecks->isNotEmpty()) {
        // Loop through the records to check each one
        foreach ($interestedChecks as $check_submitdata) {
            // If another agent has marked the lead as 'Interested', block the submission
            if ((int)$check_submitdata->click_id !== (int)session('agent_id')) {
                session()->flash('error', 'This Form Is Already Submitted by another agent.');
                return redirect()->back();
            }
            
            // If the same agent already marked the lead as 'Interested', allow submission
            if ($check_submitdata->form_status == "Interested" && (int)$check_submitdata->click_id === (int)session('agent_id')) {
                // This is valid, so continue with the submission process
                break;
            }
        }
    }      
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
            'Liability' => 'nullable',
            'MTC' => 'nullable',
            'interchange' => 'nullable',
            'commodities' => 'nullable|array',
            'reminder' => 'nullable',
            'date' => 'nullable',
            'contact_mode' => 'nullable',
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
            'vin6' => 'nullable',
            'driver_name6' => 'nullable',
            'driver_dob6' => 'nullable',
            'driver_license6' => 'nullable',
            'driver_license_state6' => 'nullable',
            'vehicle_year6' => 'nullable',
            'vehicle_make6' => 'nullable',
            'stated_value6' => 'nullable',
            'vin7' => 'nullable',
            'driver_name7' => 'nullable',
            'driver_dob7' => 'nullable',
            'driver_license7' => 'nullable',
            'driver_license_state7' => 'nullable',
            'vehicle_year7' => 'nullable',
            'vehicle_make7' => 'nullable',
            'stated_value7' => 'nullable',
            'vin8' => 'nullable',
            'driver_name8' => 'nullable',
            'driver_dob8' => 'nullable',
            'driver_license8' => 'nullable',
            'driver_license_state8' => 'nullable',
            'vehicle_year8' => 'nullable',
            'vehicle_make8' => 'nullable',
            'stated_value8' => 'nullable',
            'vin9' => 'nullable',
            'driver_name9' => 'nullable',
            'driver_dob9' => 'nullable',
            'driver_license9' => 'nullable',
            'driver_license_state9' => 'nullable',
            'vehicle_year9' => 'nullable',
            'vehicle_make9' => 'nullable',
            'stated_value9' => 'nullable',
            'vin10' => 'nullable',
            'driver_name10' => 'nullable',
            'driver_dob10' => 'nullable',
            'driver_license10' => 'nullable',
            'driver_license_state10' => 'nullable',
            'vehicle_year10' => 'nullable',
            'vehicle_make10' => 'nullable',
            'stated_value10' => 'nullable',
        ]);
       
        // Dynamic form_status_value based on form_status
        $validated['form_status_value'] = ($validated['form_status'] == 'Intrested') ? '100' : (($validated['form_status'] == 'Pipeline') ? '50' : null);

        $validated['click_id'] = session('agent_id');
        
        
        $timeZone = 'America/New_York';
        $currentDate = Carbon::now($timeZone);
        $date = $currentDate->format('Y-m-d');

        
       
        
        if (!array_key_exists('commodities', $validated)) {
        $validated['commodities'] = null;
    } else {
        $commodities = json_encode($validated['commodities']);
        $validated['commodities'] = $commodities;
    }
    

        $dataId = $request->data_id;
        
        $unitOwned = unitOwned::updateOrCreate(
            ['data_id' => $dataId],
            $validated2
        );
        if ($unitOwned) {
            $request->session()->flash('success', 'Unit Owned Data submitted successfully!');
        }
        $form_status=$request->form_status;
        $data = ExcelData::find($request->data_id);
        if ($data) {
               if ($data->form_status == "Pipeline") {
            if ($data->updated_at->toDateString() !== Carbon::today()->toDateString()) {
                $data->pipeline_updated = 1;
            }
        }

            //images 
        $fullimagepath1 = $data->file1;
        if (!empty($request->file1)) {
           $allowedFormats = ['jpeg', 'jpg', 'pdf', 'png', 'zip'];
            $extension = strtolower($request->file1->getClientOriginalExtension());
            if (in_array($extension, $allowedFormats)) {
                $file = time() . 'driversdocs1.' . $request->file1->extension();
                $request->file1->move(public_path('uploads/image/drivers_docs/'), $file);
                $fullimagepath1 = 'uploads/image/drivers_docs/' . $file;
            } else {
                // Handle invalid file format (not allowed)
                return redirect()->back()->with('error', 'Invalid file format. Only jpeg, jpg, and pdf files are allowed.');
            }
        }

        $fullimagepath2 = $data->file2;
        if (!empty($request->file2)) {
            $allowedFormats = ['jpeg', 'jpg', 'pdf', 'png', 'zip'];
            $extension = strtolower($request->file2->getClientOriginalExtension());
            if (in_array($extension, $allowedFormats)) {
                $file = time() . 'driversdocs2.' . $request->file2->extension();
                $request->file2->move(public_path('uploads/image/drivers_docs/'), $file);
                $fullimagepath2 = 'uploads/image/drivers_docs/' . $file;
            } else {
                // Handle invalid file format (not allowed)
                return redirect()->back()->with('error', 'Invalid file format. Only jpeg, jpg, and webp files are allowed.');
            }
        }

        $fullimagepath3 = $data->file3;
        if (!empty($request->file3)) {
            $allowedFormats = ['jpeg', 'jpg', 'pdf', 'png', 'zip'];
            $extension = strtolower($request->file3->getClientOriginalExtension());
            if (in_array($extension, $allowedFormats)) {
                $file = time() . 'driversdocs3.' . $request->file3->extension();
                $request->file3->move(public_path('uploads/image/drivers_docs/'), $file);
                $fullimagepath3 = 'uploads/image/drivers_docs/' . $file;
            } else {
                // Handle invalid file format (not allowed)
                return redirect()->back()->with('error', 'Invalid file format. Only jpeg, jpg, and webp files are allowed.');
            }
        }

        $fullimagepath4 = $data->file4;
        if (!empty($request->file4)) {
            $allowedFormats = ['jpeg', 'jpg', 'pdf', 'png', 'zip'];
            $extension = strtolower($request->file4->getClientOriginalExtension());
            if (in_array($extension, $allowedFormats)) {
                $file = time() . 'driversdocs4.' . $request->file4->extension();
                $request->file4->move(public_path('uploads/image/drivers_docs/'), $file);
                $fullimagepath4 = 'uploads/image/drivers_docs/' . $file;
            } else {
                // Handle invalid file format (not allowed)
                return redirect()->back()->with('error', 'Invalid file format. Only jpeg, jpg, and webp files are allowed.');
            }
        }

        $fullimagepath5 = $data->file5;
        if (!empty($request->file5)) {
            $allowedFormats = ['jpeg', 'jpg', 'pdf', 'png', 'zip'];
            $extension = strtolower($request->file5->getClientOriginalExtension());
            if (in_array($extension, $allowedFormats)) {
                $file = time() . 'driversdocs5.' . $request->file5->extension();
                $request->file5->move(public_path('uploads/image/drivers_docs/'), $file);
                $fullimagepath5 = 'uploads/image/drivers_docs/' . $file;
            } else {
                // Handle invalid file format (not allowed)
                return redirect()->back()->with('error', 'Invalid file format. Only jpeg, jpg, and webp files are allowed.');
            }
        }

        $fullimagepath6 = $data->file6;
        if (!empty($request->file6)) {
            $allowedFormats = ['jpeg', 'jpg', 'pdf', 'png', 'zip'];
            $extension = strtolower($request->file6->getClientOriginalExtension());
            if (in_array($extension, $allowedFormats)) {
                $file = time() . 'driversdocs6.' . $request->file6->extension();
                $request->file6->move(public_path('uploads/image/drivers_docs/'), $file);
                $fullimagepath6 = 'uploads/image/drivers_docs/' . $file;
            } else {
                // Handle invalid file format (not allowed)
                return redirect()->back()->with('error', 'Invalid file format. Only jpeg, jpg, zip, and webp files are allowed.');
            }
        }

        $errorfile = $data->error_file;
        if (!empty($request->errorfile)) {
            $allowedFormats = ['jpeg', 'jpg', 'pdf', 'png'];
            $extension = strtolower($request->errorfile->getClientOriginalExtension());
            if (in_array($extension, $allowedFormats)) {
                $file = time() . 'driversdocs1.' . $request->errorfile->extension();
                $request->errorfile->move(public_path('uploads/image/drivers_docs/'), $file);
                $errorfile = 'uploads/image/drivers_docs/' . $file;
            } else {
                // Handle invalid file format (not allowed)
                return redirect()->back()->with('error', 'Invalid file format. Only jpeg, jpg, and pdf files are allowed.');
            }
        }
         if(!empty($request->audioFile)){
            $audioFile = $request->file('audioFile');

    // Create a unique file name
    $fileNameaudio = time() . '.' . $audioFile->getClientOriginalExtension();

    // Define the path to store the file within the 'public/audio' directory
    $audioPath = public_path('audio');
    if (!file_exists($audioPath)) {
        mkdir($audioPath, 0777, true);  // Make sure directory is created with the correct permissions
    }

    // Move the uploaded file to the 'public/audio' directory
    $audioFile->move($audioPath, $fileNameaudio);
        }else{
            $fileNameaudio = null;
        }
           
            $data->update($validated);
               if($validated['form_status'] == 'Intrested'){
                if($data->verify_status == 'pending-information'){
                    $data->star_mark = 1;
                }else{
                    $data->verify_level = 1;
                }
              
                $this->storeComment( $dataId, $request->comment);
            }else{
$data->comment = $request->comment;
            }
             $data->language = $request->language;
            $data->owner_dob = $request->owner_dob;
            $data->Liability = $request->Liability;
            $data->MTC = $request->MTC;
            $data->interchange = $request->interchange;
            $data->red_mark =  null;
            $data->physical = $request->has('physical') ? 1 : null;
            $data->general = $request->has('general') ? 1 : null;
            $data->date = $date;
            $data->file1 = $fullimagepath1;
            $data->file2 = $fullimagepath2;
            $data->file3 = $fullimagepath3;
            $data->file4 = $fullimagepath4;
            $data->file5 = $fullimagepath5;
            $data->file6 = $fullimagepath6;
            $data->error_file = $errorfile;
             $data->audio = $fileNameaudio;
      if ($request->filled('contact_mode')) {
    $data->mail_status = $request->contact_mode;   // Call / Email same save
} else {
    $data->mail_status = null;
}



           
            $data->save();
               $this->updateLeadStatus($request->data_id,$request->form_status);
            if(!empty($data->red_mark)){
                $data = new Notification();
              $data->type = "lead_issue";
              $data->heading = "Form Correction";
              $data->massage = session('agent_alise_name')." corrected his form";
              $data->click_id = 1;
              $data->data_id = $request->data_id;
              $data->save();
            
          }
          //delete manager forword
          if(!empty($request->forword_id)){
            $update  = managerfwd::where('id',$request->forword_id)->first();

            $data_id = json_decode($update->data_id);
            $ids = explode(',', $data_id[0]);
            $total = count($ids);
           
   $dataArray = json_decode($update->data_id, true);

   $dataArray = array_map('trim', explode(',', $dataArray[0]));

   $index = array_search($request->data_id, $dataArray);
   
   if ($index !== false) {
       unset($dataArray[$index]);

       $dataArray = array_values($dataArray);
   
       // Encode the modified array back to JSON
       $updatedJsonData ='["' . implode(',', $dataArray) . '"]';
   
       // Update the JSON data in the database
       $update->data_id = $updatedJsonData;
       
       $update->save();

       
   }

       if($total == 1){
           $update  = managerfwd::where('id',$request->forword_id)->delete();
         }
       
   }
            $request->session()->flash('success', 'Data submitted successfully!');
        
        return redirect()->back();
    }
}
public function agent_intersted_data($n = null){

    DB::table('users')
        ->where('id', session('agent_id'))
        ->update([
            'last_verified_seen' => now()
        ]);

    if(!empty($n)){
        $noti = Notification::where('id',$n)->first();
        if ($noti) {
            $noti->click_id = 2;
            $noti->save();
        }
    }

    $datas = ExcelData::where('click_id', session('agent_id'))
        ->where('form_status','Intrested')
        ->latest('updated_at')
        ->get();

    return view('Agent/leads/intersted_data', compact('datas'));
}

public function agent_pipeline_data($n=''){
   DB::table('users')
        ->where('id', session('agent_id'))
        ->update([
            'last_pipeline_seen' => now()
        ]);

    if(!empty($n)){
        $noti = Notification::where('id',$n)->first();
        if ($noti) {
            $noti->click_id = 2;
            $noti->save();
        }
    }

    $datas = ExcelData::where('click_id',session('agent_id'))->where('form_status','Pipeline')->latest('updated_at')->get();

    return view('Agent/leads/pipelines',compact('datas'));
}
public function agent_won_data(){
    $datas = ExcelData::where('click_id',session('agent_id'))->where('form_status','WON')->latest()->get();
    $title = "Bind";
    return view('Agent/leads/Won',compact('datas','title'));
}
public function agent_voicemail_data($n = '')
{
    if (!empty($n)) {
        $noti = Notification::where('id', $n)->first();
        if ($noti) {
            $noti->click_id = 2;
            $noti->save();
        }
    }

    $fourDaysAgo = Carbon::now()->subDays(4)->startOfDay();
    $today = Carbon::now()->endOfDay();

    $datas = ExcelData::where('click_id', session('agent_id'))
        ->where('form_status', 'Voice Mail')
        ->whereBetween('updated_at', [$fourDaysAgo, $today])
        ->latest('updated_at')
        ->get();

    return view('Agent/leads/voicemail', compact('datas'));
}
public function agent_search_data($id,$n=''){
    $datas = ExcelData::where('id',$id)->get();
    if(!empty($n)){
        $noti = Notification::where('id',$n)->first();
        $noti->click_id = 2;
        $noti->save();
    }
    $title = "Search";
    return view('Agent/leads/Won',compact('datas','title'));
}
public function storeSingleData(Request $request)
{
     $interestedChecks = ExcelData::where('dot', $request->dot)
    ->where('form_status', 'Intrested')
    ->select('dot', 'click_id', 'form_status')
    ->get();

// Check if there are any 'Interested' records for the same dot
if ($interestedChecks->isNotEmpty()) {
    // Loop through the records to check each one
            session()->flash('error', 'This Form Is Already Submitted by another agent.');
            return redirect()->back();
    }
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
        'Liability' => 'nullable',
        'MTC' => 'nullable',
        'interchange' => 'nullable',
        'commodities' => 'nullable|array',
        'reminder' => 'nullable',
        'date' => 'nullable',
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
        'vin6' => 'nullable',
        'driver_name6' => 'nullable',
        'driver_dob6' => 'nullable',
        'driver_license6' => 'nullable',
        'driver_license_state6' => 'nullable',
        'vehicle_year6' => 'nullable',
        'vehicle_make6' => 'nullable',
        'stated_value6' => 'nullable',
        'vin7' => 'nullable',
        'driver_name7' => 'nullable',
        'driver_dob7' => 'nullable',
        'driver_license7' => 'nullable',
        'driver_license_state7' => 'nullable',
        'vehicle_year7' => 'nullable',
        'vehicle_make7' => 'nullable',
        'stated_value7' => 'nullable',
        'vin8' => 'nullable',
        'driver_name8' => 'nullable',
        'driver_dob8' => 'nullable',
        'driver_license8' => 'nullable',
        'driver_license_state8' => 'nullable',
        'vehicle_year8' => 'nullable',
        'vehicle_make8' => 'nullable',
        'stated_value8' => 'nullable',
        'vin9' => 'nullable',
        'driver_name9' => 'nullable',
        'driver_dob9' => 'nullable',
        'driver_license9' => 'nullable',
        'driver_license_state9' => 'nullable',
        'vehicle_year9' => 'nullable',
        'vehicle_make9' => 'nullable',
        'stated_value9' => 'nullable',
        'vin10' => 'nullable',
        'driver_name10' => 'nullable',
        'driver_dob10' => 'nullable',
        'driver_license10' => 'nullable',
        'driver_license_state10' => 'nullable',
        'vehicle_year10' => 'nullable',
        'vehicle_make10' => 'nullable',
        'stated_value10' => 'nullable',
    ]);

    // Dynamic form_status_value based on form_status
    $validated['form_status_value'] = ($validated['form_status'] == 'Intrested') ? '100' : (($validated['form_status'] == 'Pipeline') ? '50' : null);
   
    $timeZone = 'America/New_York';
    $currentDate = Carbon::now($timeZone);
    $date = $currentDate->format('Y-m-d');

    
    if (!array_key_exists('commodities', $validated)) {
        $validated['commodities'] = null;
    } else {
        $commodities = json_encode($validated['commodities']);
        $validated['commodities'] = $commodities;
    }

    $validated['status'] = 'forwarded';
    $validated['click_id'] =session('agent_id');
    $validated['rel_id'] = session('agent_id');

    $fullimagepath1 = null;
if (!empty($request->file('file1'))) {
    $allowedFormats = ['jpeg', 'jpg', 'pdf', 'png'];
    $extension = strtolower($request->file('file1')->getClientOriginalExtension());
    if (in_array($extension, $allowedFormats)) {
        $fileName = time() . 'driversdocs1.' . $extension;
        $request->file('file1')->move(public_path('uploads/image/drivers_docs/'), $fileName);
        $fullimagepath1 = 'uploads/image/drivers_docs/' . $fileName;
    } else {
        // Handle invalid file format (not allowed)
        return redirect()->back()->with('error', 'Invalid file format. Only jpeg, jpg, and pdf pdf are allowed.');
    }
}

    $fullimagepath2 = null;
    if (!empty($request->file('file2'))) {
        $allowedFormats = ['jpeg', 'jpg', 'pdf', 'png'];
        $extension = strtolower($request->file('file2')->getClientOriginalExtension());
        if (in_array($extension, $allowedFormats)) {
            $file = time() . 'driversdocs2.' . $extension;
            $request->file2->move(public_path('uploads/image/drivers_docs/'), $file);
            $fullimagepath2 = 'uploads/image/drivers_docs/' . $file;
        } else {
            // Handle invalid file format (not allowed)
            return redirect()->back()->with('error', 'Invalid file format. Only jpeg, jpg, and pdf files are allowed.');
        }
    }

    $fullimagepath3 = null;
    if (!empty($request->file('file3'))) {
        $allowedFormats = ['jpeg', 'jpg', 'pdf', 'png'];
        $extension = strtolower($request->file('file3')->getClientOriginalExtension());
        if (in_array($extension, $allowedFormats)) {
            $file = time() . 'driversdocs3.' . $extension;
            $request->file3->move(public_path('uploads/image/drivers_docs/'), $file);
            $fullimagepath3 = 'uploads/image/drivers_docs/' . $file;
        } else {
            // Handle invalid file format (not allowed)
            return redirect()->back()->with('error', 'Invalid file format. Only jpeg, jpg, and pdf files are allowed.');
        }
    }

    $fullimagepath4 = null;
    if (!empty($request->file('file4'))) {
        $allowedFormats = ['jpeg', 'jpg', 'pdf', 'png'];
        $extension = strtolower($request->file('file4')->getClientOriginalExtension());
        if (in_array($extension, $allowedFormats)) {
            $file = time() . 'driversdocs4.' . $extension;
            $request->file4->move(public_path('uploads/image/drivers_docs/'), $file);
            $fullimagepath4 = 'uploads/image/drivers_docs/' . $file;
        } else {
            // Handle invalid file format (not allowed)
            return redirect()->back()->with('error', 'Invalid file format. Only jpeg, jpg, and pdf files are allowed.');
        }
    }

    $fullimagepath5 = null;
    if (!empty($request->file('file5'))) {
        $allowedFormats = ['jpeg', 'jpg', 'pdf', 'png'];
        $extension = strtolower($request->file('file5')->getClientOriginalExtension());
        if (in_array($extension, $allowedFormats)) {
            $file = time() . 'driversdocs5.' .$extension;
            $request->file5->move(public_path('uploads/image/drivers_docs/'), $file);
            $fullimagepath5 = 'uploads/image/drivers_docs/' . $file;
        } else {
            // Handle invalid file format (not allowed)
            return redirect()->back()->with('error', 'Invalid file format. Only jpeg, jpg, and pdf files are allowed.');
        }
    }

    $fullimagepath6 = null;
    if (!empty($request->file('file6'))) {
        $allowedFormats = ['jpeg', 'jpg', 'pdf', 'png'];
        $extension = strtolower($request->file('file6')->getClientOriginalExtension());
        if (in_array($extension, $allowedFormats)) {
            $file = time() . 'driversdocs6.' . $extension;
            $request->file6->move(public_path('uploads/image/drivers_docs/'), $file);
            $fullimagepath6 = 'uploads/image/drivers_docs/' . $file;
        } else {
            // Handle invalid file format (not allowed)
            return redirect()->back()->with('error', 'Invalid file format. Only jpeg, jpg, and pdf files are allowed.');
        }
    }

    // Create ExcelData
    $data = ExcelData::create($validated);
      if($validated['form_status'] == 'Intrested'){
                $data->verify_level = 1;
                $this->storeComment(  $data->id, $request->comment);
            }else{
$data->comment = $request->comment;
            }
    $data->Liability = $request->Liability;
    $data->MTC = $request->MTC;
    $data->interchange = $request->interchange;
    $data->is_cover_well = $request->has('CoverWell') ? 1 : null;
    $data->physical = $request->has('physical') ? 1 : null;
    $data->general = $request->has('general') ? 1 : null;
    $data->date = $date;
    $data->file1 = $fullimagepath1;
    $data->file2 = $fullimagepath2;
    $data->file3 = $fullimagepath3;
    $data->file4 = $fullimagepath4;
    $data->file5 = $fullimagepath5;
    $data->file6 = $fullimagepath6;
    $data->save();
    

    if ($data) {
       
        // Retrieve the ID of the created ExcelData record
        $dataId = $data->id;
   $this->storeComment( $dataId, $request->comment);
        // Create UnitOwned with data_id
        $unitOwned = unitOwned::create(array_merge(['data_id' => $dataId], $validated2));

        if ($unitOwned) {
            $request->session()->flash('success', 'Unit Owned Data submitted successfully!');
        }

        $request->session()->flash('success', 'Data submitted successfully!');
    } else {
        $request->session()->flash('error', 'Something went wrong. Please try again!');
    }

    return redirect()->back();
}
public function reminder_notif(Request $req){
      $lead_id = $req->lead_id;
      $reminder_time = $req->reminderDateTime;

      $data = new Notification();
      $data->agent_id = session('agent_id');
      $data->type = "reminder";
      $data->heading = "Reminder";
      $data->massage = "You have new reminder please check pipelines";
      $data->data_id =  $lead_id;
      $data->reminder = $reminder_time;
      $data->click_id = 1;
      $data->save();

      return response()->json('data store successfully');

}
private function add_total_call(){

    $timeZone = 'America/New_York';

    $currentDate = Carbon::now($timeZone);

    $date = $currentDate->format('Y-m-d');

    $report = dayendreport::where('user_id',session('agent_id'))->where('date',$date)->first();

     if(empty($report)){
        $reportdata = new dayendreport();

        $total_call = 1;

        $reportdata->user_id = session('agent_id');
        $reportdata->total_call = $total_call;
        $reportdata->date = $date;
        $reportdata->save();
     }
     else{
        $totalcall = $report->total_call + 1;
        $report->total_call = $totalcall;
        $report->save();
     }
}
public function agent_email_form(Request $request){
      // Validate the form inputs
      $request->validate([
        'company_name' => 'required',
        'phone' => 'required',
        'email' => 'required|email',
        'trucks' => 'required',
        'drivers' => 'required',
    ]);
    $agent_id = session('agent_id');
    // Get the form data
    $data = [
        'agent_id' =>   $agent_id,
        'company_name' => $request->company_name,
        'phone' => $request->phone,
        'email' => $request->email,
        'trucks' => $request->trucks,
        'drivers' => $request->drivers,
        'Comment' => $request->comment,
        'status' => 1,
    ];

    Interested_email::create($data);

    return back()->with('success', 'Data sent successfully!');

}
public function show_email_inrsted(){
    $datas = Interested_email::where('agent_id',session('agent_id'))->latest()->get();

    return view('Agent/leads/email_intrsed',compact('datas'));
}
private function updateLeadStatus($leadId,$status)
{
    // Log the status history
    LeadStatusHistory::create([
        'lead_id' => $leadId,
        'user_id' => session('agent_id'), // The ID of the current user
        'status' => $status,
        'status_date' => Carbon::now(),
    ]);

    return response()->json(['message' => 'Lead status updated and history recorded']);
}
public function view_lead_history(Request $req, $idd)
{
    $id = base64_decode($idd);
    $excel_data = ExcelData::where('id', $id)->first();
    $historys = LeadStatusHistory::where('lead_id', $id)->latest('created_at')->get();
    $duplicates = "";

    if (!empty($excel_data->dot)) {
        // Fetch all leads with the same dot but skip the current lead with the same $id
        $duplicates = ExcelData::where('dot', $excel_data->dot)
                               ->where('id', '!=', $id) // Skip the current lead
                               ->latest('created_at')->get();
    }else{
        $duplicates = ExcelData::where('mc_docket', $excel_data->mc_docket)
        ->where('id', '!=', $id) // Skip the current lead
        ->latest('created_at')->get();

    }
    return view('Agent/leads/lead_history', compact('excel_data', 'historys', 'duplicates'));
}
private function storeComment($leadId,$recivecomment)
{
    // Retrieve the lead and decode existing comments or initialize an empty array if null
    $lead = ExcelData::findOrFail($leadId);
    $comments = $lead->comment ? json_decode($lead->comment, true) : [];

    // Append the new comment to the comments array
    $comments[] = [
        'agent_name' => session('agent_alise_name'), // Get current user's name
        'comment' => $recivecomment,
        'created_at' => now()->toDateTimeString(),
    ];

    // Save the updated comments array back as JSON to avoid overwriting
    $lead->comment = json_encode($comments, JSON_UNESCAPED_UNICODE);
    $lead->save();

    return back();
}


//============================================= manage verified leads ===========================
public function verified_agent_manage(Request $req)
{

        return view('Agent/leads/manage_verified');
}

public function getVerifiedLeadsagent(Request $request)
{
    // Start building the query with eager loading for the 'userDetail' relationship
    $query = ExcelData::with('userDetail')->where('click_id',session('agent_id'))
        ->whereNotNull('verify_status');

    // Check for each filter and apply it to the query if the input is not empty

    // Filter by search input (company_name, phone, dot, mc_docket)
    if ($request->filled('search_input')) {
        $search = $request->input('search_input');
        $query->where(function ($q) use ($search) {
            $q->where('company_name', 'like', '%' . $search . '%')
              ->orWhere('phone', 'like', '%' . $search . '%')
              ->orWhere('dot', 'like', '%' . $search . '%')
              ->orWhere('mc_docket', 'like', '%' . $search . '%');
        });
    }

    // Filter by agent (clickid)
    if ($request->filled('agent')) {
        $agent = $request->input('agent');
        $query->where('click_id', $agent);
    }

    // Filter by date1 and date2
    if ($request->filled('date1') && !$request->filled('date2')) {
        // Only date1 is provided, so filter records where 'date' is equal to date1
        $date1 = $request->input('date1');
        $query->whereDate('date', $date1);
    } elseif ($request->filled('date1') && $request->filled('date2')) {
        // Both date1 and date2 are provided, so filter records between these dates
        $date1 = $request->input('date1');
        $date2 = $request->input('date2');
        $query->whereBetween('date', [$date1, $date2]);
    }

    // Execute the query and get the results
    $leads = $query->get();

    // Return the filtered data as JSON
    return response()->json($leads);
}

public function getLeadByIdagent($id)
{
$lead = ExcelData::with('userDetail')->with('unitOwned')->findOrFail($id); // Fetch lead data and related user details
return response()->json($lead);
}



}
