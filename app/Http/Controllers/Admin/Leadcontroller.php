<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\adminmodel\ExcelData;
use App\adminmodel\Team;
use App\adminmodel\Tab_view_lead;
use App\Models\User;
use App\Models\Notification;
use App\Models\managerfwd;
use App\Models\dayendreport;
use App\Models\LeadStatusHistory;
use App\Models\Manager_team;
use App\Models\Auto_forward;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Events\UserNotification;
use App\Exports\interested_leads;
use App\adminmodel\Interested_email;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Collection;






class Leadcontroller extends Controller
{
    public function all_tab_view(){
        $datas = Tab_view_lead::with('team')->latest()->get();
        return view('admin.leads.all_tab_view',compact('datas')); 
    }
   public function all_tab_view_data($idd, $batchs)
{
    ini_set('memory_limit', '-1');
    $id = base64_decode($idd);
    $batch = base64_decode($batchs);

    // Base query
    $query = ExcelData::where('status', 'not_forwarded')
        ->where('batch_name', $batch)
        ->where('rel_id', $id);

    // ✅ Apply state filter (if any)
    if (!empty($_GET['state'])) {
        $rawStateInput = $_GET['state'];
        $flattened = is_array($rawStateInput) ? implode(',', $rawStateInput) : $rawStateInput;
        $states = array_filter(array_map('trim', explode(',', $flattened)));

        if (!empty($states)) {
            $query->whereIn('business_state', $states);
        }
    }

    // ✅ Apply search filter (if any)
    $searchTerm = $_GET['search_input'] ?? null;
    if (!empty($searchTerm)) {
        $query->where(function ($q) use ($searchTerm) {
            $q->where('company_name', 'like', "%$searchTerm%")
                ->orWhere('phone', 'like', "%$searchTerm%")
                ->orWhere('email', 'like', "%$searchTerm%")
                ->orWhere('business_state', 'like', "%$searchTerm%");
        });
    }

    // ✅ Apply date range filter (if any)
    $date1 = $_GET['date1'] ?? null;
    $date2 = $_GET['date2'] ?? null;
    if (!empty($date1) && !empty($date2)) {
        $query->whereBetween('created_at', [$date1, $date2]);
    }

    // ✅ Pagination rows
    $pagination = $_GET['row_pegi'] ?? 100;

    // ✅ Fetch data with pagination and keep query string in links
    $datas = $query->latest()->paginate($pagination)->appends(request()->query());

    // ✅ Total count (clone before pagination)
    $total = (clone $query)->count();

    // ✅ Get agents
    $agents = User::where('is_active', 1)->where('status', 1)->get();

    return view('admin.leads.all', compact('datas', 'agents', 'total'));
}

    public function all_lead()
    {
        
        ini_set('memory_limit', '-1');
    
        // Check if state filter is provided
        if (isset($_GET['state']) && !empty($_GET['state'])) {
            $state = $_GET['state'];
            $datas = ExcelData::where('status', 'not_forwarded')
                ->where('business_state', 'like', "%$state%")
                ->latest()
                ->paginate(100);
        } else {
            // If state filter is not provided, proceed with other filters or default pagination
            $searchTerm = isset($_GET['search_input']) ? $_GET['search_input'] : null;
            $pagination = isset($_GET['row_pegi']) && $_GET['row_pegi'] !== '' ? $_GET['row_pegi'] : 100;
            $date1 = isset($_GET['date1']) ? $_GET['date1'] : null;
            $date2 = isset($_GET['date2']) ? $_GET['date2'] : null;
    
            $datas = ExcelData::where('status', 'not_forwarded');
    
            // Apply other filters if provided
            if (!empty($searchTerm) && !empty($date1) && !empty($date2)) {
                $datas->where(function ($query) use ($searchTerm) {
                    $query->where('company_name', 'like', "%$searchTerm%")
                        ->orWhere('phone', 'like', "%$searchTerm%")
                        ->orWhere('email', 'like', "%$searchTerm%")
                        ->orWhere('business_state', 'like', "$searchTerm");
                })
                ->whereBetween('created_at', [$date1, $date2]);
            } elseif (!empty($searchTerm)) {
                $datas->where(function ($query) use ($searchTerm) {
                    $query->where('company_name', 'like', "%$searchTerm%")
                        ->orWhere('phone', 'like', "%$searchTerm%")
                        ->orWhere('email', 'like', "%$searchTerm%")
                        ->orWhere('business_state', 'like', "%$searchTerm%");
                });
            } elseif (!empty($date1) && !empty($date2)) {
                $datas->whereBetween('created_at', [$date1, $date2]);
            }
    
            // Apply default pagination
            $datas = $datas->latest()->paginate($pagination);
        }

        $total = ExcelData::where('status', 'not_forwarded')
        ->count();

    
        $agents = User::where('is_active', 1)->where('status', 1)->get();
    
        return view('admin.leads.all', compact('datas', 'agents','total'));
    }
   public function import_leads(){
    return view('admin/leads/import');
   }
   public function delete_lead($idd){
    $id = base64_decode($idd);
    $lead = ExcelData::where('id', $id)->delete();
    return redirect()->back();
   }
   public function update_lead_status($idd,$statuss){
    $id = base64_decode($idd);
    $status =  base64_decode($statuss);
    $lead = ExcelData::where('id', $id)->first();
    $lead->form_status = $status;
    $lead->save();
    return redirect()->back();
   }
   public function deleteDuplicateEntry(Request $request)
    {
        $userId = session('admin_id');

        $duplicates = ExcelData::select('phone', DB::raw('MAX(id) as max_id'))
            ->where('rel_id', $userId)
            ->where('status', 'not_forwarded')
            ->groupBy('phone')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        $deletedCount = 0;

        foreach ($duplicates as $duplicate) {
            $phoneNumber = $duplicate->phone;
            $excelDataIdToKeep = $duplicate->max_id;

            $entriesToDelete = ExcelData::where('rel_id', $userId)
                ->where('phone', $phoneNumber)
                ->where('status', 'not_forwarded')
                ->where('id', '!=', $excelDataIdToKeep)
                ->get();

            $deletedCount += $entriesToDelete->count();

            // Delete duplicate entries
            $entriesToDelete->each(function ($entry) {
                $entry->delete();
            });
        }

        $message = $deletedCount > 0 ? "Deleted $deletedCount duplicate entries and related managerfwd data successfully!" : "No duplicate entries found.";

        $request->session()->flash('success', $message);
        return redirect()->back();
    }
     // Delete Duplicate Entry Batch
     public function deleteDuplicateEntryBatch(Request $request ,$batchname)
     {
         $batchname = base64_decode($batchname);
 
         $duplicates = ExcelData::select('phone', DB::raw('MAX(id) as max_id'))
             ->where('batch_name', $batchname)
             ->where('status', 'not_forwarded')
             ->groupBy('phone')
             ->havingRaw('COUNT(*) > 1')
             ->get();
 
         $deletedCount = 0;
 
         foreach ($duplicates as $duplicate) {
             $phoneNumber = $duplicate->phone;
             $excelDataIdToKeep = $duplicate->max_id;
 
             $entriesToDelete = ExcelData::where('batch_name', $batchname)
                 ->where('phone', $phoneNumber)
                 ->where('status', 'not_forwarded')
                 ->where('id', '!=', $excelDataIdToKeep)
                 ->get();
 
             $deletedCount += $entriesToDelete->count();
 
             // Delete duplicate entries
             $entriesToDelete->each(function ($entry) {
                 $entry->delete();
             });
         }
         $batchdata = Tab_view_lead::where('batch',$batchname)->first();
        $b_data  = $batchdata->total_data;
         $update_data = $b_data- $deletedCount;

         $batchdata->total_data = $update_data;
         $batchdata->save();

         $message = $deletedCount > 0 ? "Deleted $deletedCount duplicate entries from $batchname data successfully!" : "No duplicate entries found.";
 
         $request->session()->flash('success', $message);
         return redirect()->back();
     }
     //------------------- delete all data of batch -----------------
     public function deleteAllbatchData(Request $request ,$batchname)
     {
         try {
            $batchname = base64_decode($batchname);
             // Get all ExcelData records
             $excelDataRecords = ExcelData::where('status', 'not_forwarded')->where('batch_name', $batchname)->get();
 
             // Loop through each ExcelData record and delete it
             foreach ($excelDataRecords as $excelData) {
                 $excelData->delete();
             }
             $batchdata = Tab_view_lead::where('batch',$batchname)->first()->delete();
 
             $request->session()->flash('success', 'All data deleted successfully.');
         } catch (\Exception $e) {
             // Handle exceptions if any
             $request->session()->flash('error', 'Error deleting imported data: ' . $e->getMessage());
         }
 
         return redirect()->back();
     }
        //------------------- delete all dnd of batch -----------------
        public function deleteDNDEntryBatch(Request $request ,$batchname)
     {
         $batchname = base64_decode($batchname);
 
         $batchdata = ExcelData::
             where('batch_name', $batchname)
             ->where('status', 'not_forwarded')
             ->get();
        
             $batchPhones = $batchdata->pluck('phone')->toArray();

             // Retrieve all entries with 'forwarded' status and 'DND' form_status
             $dnddata = ExcelData::where('status', 'forwarded')
                 ->where('form_status', 'DND')
                 ->whereIn('phone', $batchPhones) // Only get those entries that are in batchPhones
                 ->get();

                 $deletedCount = 0;

                 // Filter batchdata to find entries with phone numbers that exist in filtered dnddata
                 $entriesToDelete = $batchdata->filter(function ($entry) use ($dnddata) {
                     return $dnddata->contains('phone', $entry->phone);
                 });
             
                 $deletedCount = $entriesToDelete->count();
             
                 // Delete the filtered entries
                 $entriesToDelete->each(function ($entry) {
                     $entry->delete();
                 });
         $batchdata = Tab_view_lead::where('batch',$batchname)->first();
        $b_data  = $batchdata->total_data;
         $update_data = $b_data- $deletedCount;

         $batchdata->total_data = $update_data;
         $batchdata->save();

         $message = $deletedCount > 0 ? "Deleted $deletedCount DND entries from $batchname data successfully!" : "No duplicate entries found.";
 
         $request->session()->flash('success', $message);
         return redirect()->back();
     }

     //--------------------------------- forword leads --------------------------
     public function forword_leads(Request $req)
{       
    $req->validate([
        'agent_id' => 'required',
        'leadid' => 'required|array',
    ]);

    $team_id = session('admin_id');

    // Convert the array to JSON if it's an array
    $jsonLeadIds = json_encode($req->leadid);

    // Save managerfwd entry
    $forword = new managerfwd();
    $forword->agent_id = $req->agent_id;
    $forword->data_id = $jsonLeadIds;
    $forword->team_id = $team_id;
    $forword->save();

    $leadIds = [];

    // Loop through each element of the $req->leadid array
    foreach ($req->leadid as $leadGroup) {
        // Split the comma-separated string into individual IDs
        $leadIds = array_merge($leadIds, explode(',', $leadGroup));
    }
    
    // Remove duplicate IDs if any
    $leadIds = array_unique($leadIds);
   
    // Fetch ExcelData records for all lead IDs
    $excelDatas = ExcelData::whereIn('id', $leadIds)->get();
   
    foreach ($excelDatas as $excelData) {
    
        $excelData->status = 'forwarded';
        $excelData->form_status = 'NEW';
        $excelData->save();
    }
    //-------------reduce tab view -------------
    // Group by batch_name and get the count for each batch
   $batchCounts = $excelDatas->groupBy('batch_name')->map(function (Collection $batch) {
     return $batch->count();
     });

foreach ($batchCounts as $batchName => $count) {
    $tab_view = Tab_view_lead::where('batch',$batchName)->first();
    if ($tab_view) {
        $tab_data = $tab_view->total_data;
        if ($tab_data == $count) {
            $tab_view->delete();
        } else {
            $tab_view->total_data = $tab_data - $count;
            $tab_view->save();
        }
    }
}
    $data = new Notification();
      $data->agent_id = $req->agent_id;
      $data->type = "forward";
      $data->heading = "New leads";
      $data->massage = "The manager sent you new leads";
      $data->click_id = 1;
      $data->save();

      $req->session()->flash('success', 'All Selected data forwarded successfully.');
      $data = [
          'massage'=>'You Received New Leads',
          'user_id'=>$req->agent_id,
      ];

    event(new UserNotification($data));
    return redirect()->back();
}
     //--------------------------------- bluck delete leads --------------------------
     public function bluckdelete(Request $req)
{
    $req->validate([
        'leadids' => 'required|array',
    ]);
    // Extract lead IDs from the array
    $leadIdsString = $req->leadids[0];

    // Split the string of lead IDs into an array
    $leadIds = explode(',', $leadIdsString);

     //-------------reduce tab view -------------
    // Group by batch_name and get the count for each batch
    $excelDatas = ExcelData::whereIn('id', $leadIds)->get();
   $batchCounts = $excelDatas->groupBy('batch_name')->map(function (Collection $batch) {
    return $batch->count();
    });
    if(empty($req->assign_leads)){
foreach ($batchCounts as $batchName => $count) {
   $tab_view = Tab_view_lead::where('batch',$batchName)->first();
   if ($tab_view) {
       $tab_data = $tab_view->total_data;
       if ($tab_data == $count) {
           $tab_view->delete();
       } else {
           $tab_view->total_data = $tab_data - $count;
           $tab_view->save();
       }
   }
}
    }
//----------------reduce assign leads -------------------
if(!empty($req->assign_leads)){
    $assign_id = base64_decode($req->assign_leads);
    $update  = managerfwd::where('id', $assign_id)->first();

    if ($update) {
        $ids = json_decode($update->data_id);
        $data_id = explode(',', $ids[0]);
        $total = count($data_id);
       $total_lead = count($leadIds);
      
        foreach ($leadIds as $leadId) {
            // Find the index of $leadId in $data_id array
            $index = array_search($leadId, $data_id);
           
            if ($index !== false) {
                // Remove the element at $index from $data_id
                unset($data_id[$index]);
            }
        }
    
        // Re-index the array after removals
        $data_id = array_values($data_id);
    
        // Encode the modified array back to JSON format
        $updatedJsonData = '["' . implode(',', $data_id) . '"]';
        // Update the JSON data in the database
        $update->data_id = $updatedJsonData;
        $update->save();
  
        // Check if total count is 1 after deletion and delete managerfwd record
        
        if ($total == $total_lead) {
          
            managerfwd::where('id', $req->mangerfwd)->delete();
        }
    
    } else {
        // Handle case when no record is found with the given $assign_id
        return response()->json(['error' => 'Record not found'], 404);
    }
}
//-------------- end reduce assign leads--------------------------
    // Delete leads with the given IDs
    $deletedCount = ExcelData::whereIn('id', $leadIds)->delete();

    // Flash a success message with the count of deleted leads
    $req->session()->flash('success', "Deleted $deletedCount leads.");

    return redirect()->back();
}

    //====================================================discompostion=============================
   public function interstedleads($id = '', $n = '') {
    ini_set('memory_limit', '-1');

    // Check if specific notification is provided
    if (!empty($n)) {
        $noti = Notification::where('id', $n)->first();
        if ($noti) {
            $noti->click_id = 2;
            $noti->save();
        }
        $datas = ExcelData::where('id', $id)->paginate(10);
        return view('admin.disposition.intersted', compact('datas'));
    }

    // Initialize query
    $datas = ExcelData::where('status', 'forwarded')->where('form_status', 'Intrested');

        $manager_id = session('admin_id'); 
        // Fetch team_ids for the manager from the manager_team table
        $manager_team = Manager_team::where('manager_id', $manager_id)->first();
        if ($manager_team) {
            // Get the team_ids as a string (e.g., '["2v", "3v"]')
            $services_string = $manager_team->team_ids;
            
            // Clean up the string (remove square brackets and quotes)
            $cleaned_services_string = trim($services_string, '[]"');
            $cleaned_services_string = str_replace('"', '', $cleaned_services_string);
        
            // Convert the cleaned string into an array of team IDs
            $selected_services = explode(',', $cleaned_services_string);
        
            // Remove the "v" from each element in the array
            $selected_services = array_map(function($service) {
                return str_replace('v', '', $service); // Remove the 'v'
            }, $selected_services);
           
            // If '999' is not in the selected services, filter by team_ids
            if (!in_array('999', $selected_services)) {
              
                // Apply the whereIn query to filter by the selected team_ids
                $datas->whereIn('click_id', $selected_services);
            }
        }
    
    // Apply filters if present
    $state = isset($_GET['state']) ? $_GET['state'] : null;
    $searchTerm = isset($_GET['search_input']) ? $_GET['search_input'] : null;
    $date1 = isset($_GET['date1']) ? $_GET['date1'] : null;
    $date2 = isset($_GET['date2']) ? $_GET['date2'] : null;
    $pagination = isset($_GET['row_pegi']) && !empty($_GET['row_pegi']) ? $_GET['row_pegi'] : 100;

    // Apply state filter if provided
    if (!empty($state)) {
        $datas->where('click_id', $state);
    }

    // Apply search term filter
    if (!empty($searchTerm)) {
        $datas->where(function ($query) use ($searchTerm) {
            $query->where('company_name', 'like', "%$searchTerm%")
                ->orWhere('phone', 'like', "%$searchTerm%")
                ->orWhere('email', 'like', "%$searchTerm%")
                ->orWhere('business_state', 'like', "%$searchTerm%");
        });
    }

    // Apply date range filter
    if (!empty($date1) && empty($date2)) {
        // Only date1 provided
        $datas->whereDate('date', $date1);
    } elseif (!empty($date1) && !empty($date2)) {
        // Both date1 and date2 provided
        $datas->whereBetween('date', [$date1, $date2]);
    }

    // Apply default conditions (is_cover_well, is_submit)
    $datas->where('is_cover_well', null)->where('is_submit', null);

    // Fetch paginated results
    $datas = $datas->latest('date')->paginate($pagination);

    // Get active agents
    $agents = User::where('is_active', 1)->where('status', 1)->get();

    // Return the view with data
    return view('admin.disposition.intersted', compact('datas', 'agents'));
}

  public function newinterstedleads($id='', $n='') {
        ini_set('memory_limit', '-1');
    
        // Check if specific notification is provided
        if (!empty($n)) {
            $noti = Notification::where('id', $n)->first();
            if ($noti) {
                $noti->click_id = 2;
                $noti->save();
            }
            $datas = ExcelData::where('id', $id)->paginate(10);
            return view('admin.disposition.new_intrested', compact('datas'));
        }
    
        // Initialize query
        $datas = ExcelData::where('form_status', 'Intrested')->where('verify_level',3);
    
        // Apply filters if present
        $state = isset($_GET['state']) ? $_GET['state'] : null;
        $searchTerm = isset($_GET['search_input']) ? $_GET['search_input'] : null;
        $date1 = isset($_GET['date1']) ? $_GET['date1'] : null;
        $date2 = isset($_GET['date2']) ? $_GET['date2'] : null;
        $pagination = isset($_GET['row_pegi']) && !empty($_GET['row_pegi']) ? $_GET['row_pegi'] : 100;
    
        // Apply state filter if provided
        if (!empty($state)) {
            $datas->where('click_id', $state);
        }
    
        // Apply search term filter
        if (!empty($searchTerm)) {
            $datas->where(function ($query) use ($searchTerm) {
                $query->where('company_name', 'like', "%$searchTerm%")
                    ->orWhere('phone', 'like', "%$searchTerm%")
                    ->orWhere('email', 'like', "%$searchTerm%")
                    ->orWhere('business_state', 'like', "%$searchTerm%");
            });
        }
    
        // Apply date range filter
        if (!empty($date1) && !empty($date2)) {
            $datas->whereBetween('updated_at', [$date1, $date2]);
        }
    
        // Apply default conditions (is_cover_well, is_submit)
        $datas->where('is_submit', null);
    
        // Fetch paginated results
        $datas = $datas->latest()->paginate($pagination);
    
        // Get active agents
        $agents = User::where('is_active', 1)->where('status', 1)->get();
    
        // Return the view with data
        return view('admin.disposition.new_intrested', compact('datas', 'agents'));
    }

    public function Submitedforms($id='',$n=''){
        ini_set('memory_limit', '-1');
         // Check if state filter is provided
         if(!empty($n)){
            $noti = Notification::where('id',$n)->first();
             $noti->click_id = 2;
              $noti->save();
              $datas = ExcelData::where('id',$id)->paginate(10);
              return view('admin.disposition.intersted', compact('datas'));
         }
         if (isset($_GET['state']) && !empty($_GET['state'])) {
            $state = $_GET['state'];
            $datas = ExcelData::where('status', 'forwarded')
            ->where('form_status', 'Intrested')
                ->where('business_state', 'like', "%$state%")
                ->where('is_submit',1)
                ->latest()
                ->paginate(100);
        } else {
            // If state filter is not provided, proceed with other filters or default pagination
            $searchTerm = isset($_GET['search_input']) ? $_GET['search_input'] : null;
            $pagination = isset($_GET['row_pegi']) && $_GET['row_pegi'] !== '' ? $_GET['row_pegi'] : 100;
            $date1 = isset($_GET['date1']) ? $_GET['date1'] : null;
            $date2 = isset($_GET['date2']) ? $_GET['date2'] : null;
    
            $datas = ExcelData::where('status', 'forwarded')->where('form_status', 'Intrested');
    
            // Apply other filters if provided
            if (!empty($searchTerm) && !empty($date1) && !empty($date2)) {
                $datas->where(function ($query) use ($searchTerm) {
                    $query->where('company_name', 'like', "%$searchTerm%")
                        ->orWhere('phone', 'like', "%$searchTerm%")
                        ->orWhere('email', 'like', "%$searchTerm%")
                        ->orWhere('business_state', 'like', "$searchTerm");
                })
                ->whereBetween('updated_at', [$date1, $date2]);
            } elseif (!empty($searchTerm)) {
                $datas->where(function ($query) use ($searchTerm) {
                    $query->where('company_name', 'like', "%$searchTerm%")
                        ->orWhere('phone', 'like', "%$searchTerm%")
                        ->orWhere('email', 'like', "%$searchTerm%")
                        ->orWhere('business_state', 'like', "%$searchTerm%");
                });
            } elseif (!empty($date1) && !empty($date2)) {
                $datas->whereBetween('updated_at', [$date1, $date2]);
            }
    
            // Apply default pagination
            $datas = $datas->where('is_submit',1)->latest()->paginate($pagination);
        }
    
        $agents = User::where('is_active', 1)->where('status', 1)->get();
    
        return view('admin.disposition.submitedforms', compact('datas', 'agents'));
    }
    public function coverwhaleleads($id='',$n=''){
        ini_set('memory_limit', '-1');
         // Check if state filter is provided
         if(!empty($n)){
            $noti = Notification::where('id',$n)->first();
             $noti->click_id = 2;
              $noti->save();
              $datas = ExcelData::where('id',$id)->paginate(10);
              return view('admin.disposition.intersted', compact('datas'));
         }
         if (isset($_GET['state']) && !empty($_GET['state'])) {
            $state = $_GET['state'];
            $datas = ExcelData::where('status', 'forwarded')
            ->where('form_status', 'Intrested')
                ->where('business_state', 'like', "%$state%")
                ->where('is_cover_well',1)
                ->latest()
                ->paginate(100);
        } else {
            // If state filter is not provided, proceed with other filters or default pagination
            $searchTerm = isset($_GET['search_input']) ? $_GET['search_input'] : null;
            $pagination = isset($_GET['row_pegi']) && $_GET['row_pegi'] !== '' ? $_GET['row_pegi'] : 100;
            $date1 = isset($_GET['date1']) ? $_GET['date1'] : null;
            $date2 = isset($_GET['date2']) ? $_GET['date2'] : null;
    
            $datas = ExcelData::where('status', 'forwarded')->where('form_status', 'Intrested');
    
            // Apply other filters if provided
            if (!empty($searchTerm) && !empty($date1) && !empty($date2)) {
                $datas->where(function ($query) use ($searchTerm) {
                    $query->where('company_name', 'like', "%$searchTerm%")
                        ->orWhere('phone', 'like', "%$searchTerm%")
                        ->orWhere('email', 'like', "%$searchTerm%")
                        ->orWhere('business_state', 'like', "$searchTerm");
                })
                ->whereBetween('updated_at', [$date1, $date2]);
            } elseif (!empty($searchTerm)) {
                $datas->where(function ($query) use ($searchTerm) {
                    $query->where('company_name', 'like', "%$searchTerm%")
                        ->orWhere('phone', 'like', "%$searchTerm%")
                        ->orWhere('email', 'like', "%$searchTerm%")
                        ->orWhere('business_state', 'like', "%$searchTerm%");
                });
            } elseif (!empty($date1) && !empty($date2)) {
                $datas->whereBetween('updated_at', [$date1, $date2]);
            }
    
            // Apply default pagination
            $datas = $datas->where('is_cover_well',1)->latest()->paginate($pagination);
        }
    
        $agents = User::where('is_active', 1)->where('status', 1)->get();
    
        return view('admin.disposition.coverwhale', compact('datas', 'agents'));
    }
    public function Pipelineleads() {
        ini_set('memory_limit', '-1');
    
        // Initialize query
        $datas = ExcelData::where('status', 'forwarded')->where('form_status', 'Pipeline');
      $manager_id = session('admin_id'); 
        // Fetch team_ids for the manager from the manager_team table
        $manager_team = Manager_team::where('manager_id', $manager_id)->first();
        if ($manager_team) {
            // Get the team_ids as a string (e.g., '["2v", "3v"]')
            $services_string = $manager_team->team_ids;
            
            // Clean up the string (remove square brackets and quotes)
            $cleaned_services_string = trim($services_string, '[]"');
            $cleaned_services_string = str_replace('"', '', $cleaned_services_string);
        
            // Convert the cleaned string into an array of team IDs
            $selected_services = explode(',', $cleaned_services_string);
        
            // Remove the "v" from each element in the array
            $selected_services = array_map(function($service) {
                return str_replace('v', '', $service); // Remove the 'v'
            }, $selected_services);
           
            // If '999' is not in the selected services, filter by team_ids
            if (!in_array('999', $selected_services)) {
              
                // Apply the whereIn query to filter by the selected team_ids
                $datas->whereIn('click_id', $selected_services);
            }
        }
        // Apply filters if present
        $state = isset($_GET['state']) ? $_GET['state'] : null;
        $searchTerm = isset($_GET['search_input']) ? $_GET['search_input'] : null;
        $date1 = isset($_GET['date1']) ? $_GET['date1'] : null;
        $date2 = isset($_GET['date2']) ? $_GET['date2'] : null;
        $pagination = isset($_GET['row_pegi']) && !empty($_GET['row_pegi']) ? $_GET['row_pegi'] : 100;
    
        // Apply state filter if provided
        if (!empty($state)) {
            $datas->where('click_id', $state);
        }
    
        // Apply search term filter
        if (!empty($searchTerm)) {
            $datas->where(function ($query) use ($searchTerm) {
                $query->where('company_name', 'like', "%$searchTerm%")
                    ->orWhere('phone', 'like', "%$searchTerm%")
                    ->orWhere('email', 'like', "%$searchTerm%")
                    ->orWhere('business_state', 'like', "%$searchTerm%");
            });
        }
    
        // Apply date range filter
        if (!empty($date1) && !empty($date2)) {
            $datas->whereBetween('created_at', [$date1, $date2]);
        }
    
        // Fetch paginated results
        $datas = $datas->latest()->paginate($pagination);
    
        // Get active agents
        $agents = User::where('is_active', 1)->where('status', 1)->get();
    
        // Return the view with data
        return view('admin.disposition.pipeline', compact('datas', 'agents'));
    }
   public function VoiceMailleads()
{
    ini_set('memory_limit', '-1');

    $datas = ExcelData::where('status', 'forwarded')
        ->where('form_status', 'Voice Mail');

    $manager_id = session('admin_id');
    $manager_team = Manager_team::where('manager_id', $manager_id)->first();

    if ($manager_team) {
        $services_string = $manager_team->team_ids;
        $cleaned_services_string = trim($services_string, '[]"');
        $cleaned_services_string = str_replace('"', '', $cleaned_services_string);
        $selected_services = explode(',', $cleaned_services_string);

        $selected_services = array_map(function ($service) {
            return str_replace('v', '', $service);
        }, $selected_services);

        if (!in_array('999', $selected_services)) {
            $datas->whereIn('click_id', $selected_services);
        }
    }

    // Filters
    $searchTerm = request()->query('search_input');
    $date1 = request()->query('date1');
    $date2 = request()->query('date2');
    $pagination = request()->query('row_pegi', 100);

    // Handle state input as comma-separated string or array
    $stateParam = request()->query('state');
    if (!empty($stateParam)) {
        $state = is_array($stateParam) ? $stateParam : explode(',', $stateParam);
        $state = array_map('trim', $state);
        $state = array_filter($state);
        if (!empty($state)) {
            $datas->whereIn('business_state', $state);
        }
    }

    // Handle agent input as comma-separated string or array
    $agentParam = request()->query('agent');
    if (!empty($agentParam)) {
        $agent = is_array($agentParam) ? $agentParam : explode(',', $agentParam);
        $agent = array_map('trim', $agent);
        $agent = array_filter($agent);
        if (!empty($agent)) {
            $datas->whereIn('click_id', $agent);
        }
    }

    // Search filter
    if (!empty($searchTerm)) {
        $datas->where(function ($query) use ($searchTerm) {
            $query->where('company_name', 'like', "%$searchTerm%")
                ->orWhere('phone', 'like', "%$searchTerm%")
                ->orWhere('email', 'like', "%$searchTerm%");
        });
    }

    // Date filter
    if (!empty($date1) && empty($date2)) {
        $datas->whereDate('date', $date1);
    } elseif (!empty($date1) && !empty($date2)) {
        $datas->whereBetween('date', [$date1, $date2]);
    }

    // Default filters
    $datas->whereNull('is_cover_well')->whereNull('is_submit');

    // Pagination
    $datas = $datas->latest()->paginate($pagination)->withQueryString();

    // Fetch agents
    $agents = User::where('is_active', 1)->where('status', 1)->get();

    return view('admin.disposition.voicemail', compact('datas', 'agents'));
}
     public function WrongNumberleads(){
        ini_set('memory_limit', '-1');
    
           // Initialize query
           $datas = ExcelData::where('status', 'forwarded')->where('form_status', 'Wrong Number');

           $manager_id = session('admin_id'); 
           // Fetch team_ids for the manager from the manager_team table
           $manager_team = Manager_team::where('manager_id', $manager_id)->first();
           if ($manager_team) {
               // Get the team_ids as a string (e.g., '["2v", "3v"]')
               $services_string = $manager_team->team_ids;
               
               // Clean up the string (remove square brackets and quotes)
               $cleaned_services_string = trim($services_string, '[]"');
               $cleaned_services_string = str_replace('"', '', $cleaned_services_string);
           
               // Convert the cleaned string into an array of team IDs
               $selected_services = explode(',', $cleaned_services_string);
           
               // Remove the "v" from each element in the array
               $selected_services = array_map(function($service) {
                   return str_replace('v', '', $service); // Remove the 'v'
               }, $selected_services);
              
               // If '999' is not in the selected services, filter by team_ids
               if (!in_array('999', $selected_services)) {
                 
                   // Apply the whereIn query to filter by the selected team_ids
                   $datas->whereIn('click_id', $selected_services);
               }
           }
       
           // Apply filters if present
           $state = isset($_GET['state']) ? $_GET['state'] : null;
           $searchTerm = isset($_GET['search_input']) ? $_GET['search_input'] : null;
           $date1 = isset($_GET['date1']) ? $_GET['date1'] : null;
           $date2 = isset($_GET['date2']) ? $_GET['date2'] : null;
           $pagination = isset($_GET['row_pegi']) && !empty($_GET['row_pegi']) ? $_GET['row_pegi'] : 100;
       
           // Apply state filter if provided
           if (!empty($state)) {
               $datas->where('click_id', $state);
           }
       
           // Apply search term filter
           if (!empty($searchTerm)) {
               $datas->where(function ($query) use ($searchTerm) {
                   $query->where('company_name', 'like', "%$searchTerm%")
                       ->orWhere('phone', 'like', "%$searchTerm%")
                       ->orWhere('email', 'like', "%$searchTerm%")
                       ->orWhere('business_state', 'like', "%$searchTerm%");
               });
           }
       
           // Apply date range filter
           if (!empty($date1) && empty($date2)) {
               // Only date1 provided
               $datas->whereDate('date', $date1);
           } elseif (!empty($date1) && !empty($date2)) {
               // Both date1 and date2 provided
               $datas->whereBetween('date', [$date1, $date2]);
           }
       
           // Apply default conditions (is_cover_well, is_submit)
           $datas->where('is_cover_well', null)->where('is_submit', null);
       
           // Fetch paginated results
           $datas = $datas->latest()->paginate($pagination);
       
           // Get active agents
           $agents = User::where('is_active', 1)->where('status', 1)->get();
    
        return view('admin.disposition.wrongnumber', compact('datas', 'agents'));
    }
    public function NotInterestedleads(){
        ini_set('memory_limit', '-1');
           // Initialize query
           $datas = ExcelData::where('status', 'forwarded')->where('form_status', 'Not Intrested');

           $manager_id = session('admin_id'); 
           // Fetch team_ids for the manager from the manager_team table
           $manager_team = Manager_team::where('manager_id', $manager_id)->first();
           if ($manager_team) {
               // Get the team_ids as a string (e.g., '["2v", "3v"]')
               $services_string = $manager_team->team_ids;
               
               // Clean up the string (remove square brackets and quotes)
               $cleaned_services_string = trim($services_string, '[]"');
               $cleaned_services_string = str_replace('"', '', $cleaned_services_string);
           
               // Convert the cleaned string into an array of team IDs
               $selected_services = explode(',', $cleaned_services_string);
           
               // Remove the "v" from each element in the array
               $selected_services = array_map(function($service) {
                   return str_replace('v', '', $service); // Remove the 'v'
               }, $selected_services);
              
               // If '999' is not in the selected services, filter by team_ids
               if (!in_array('999', $selected_services)) {
                 
                   // Apply the whereIn query to filter by the selected team_ids
                   $datas->whereIn('click_id', $selected_services);
               }
           }
       
           // Apply filters if present
           $state = isset($_GET['state']) ? $_GET['state'] : null;
           $searchTerm = isset($_GET['search_input']) ? $_GET['search_input'] : null;
           $date1 = isset($_GET['date1']) ? $_GET['date1'] : null;
           $date2 = isset($_GET['date2']) ? $_GET['date2'] : null;
           $pagination = isset($_GET['row_pegi']) && !empty($_GET['row_pegi']) ? $_GET['row_pegi'] : 100;
       
           // Apply state filter if provided
           if (!empty($state)) {
               $datas->where('click_id', $state);
           }
       
           // Apply search term filter
           if (!empty($searchTerm)) {
               $datas->where(function ($query) use ($searchTerm) {
                   $query->where('company_name', 'like', "%$searchTerm%")
                       ->orWhere('phone', 'like', "%$searchTerm%")
                       ->orWhere('email', 'like', "%$searchTerm%")
                       ->orWhere('business_state', 'like', "%$searchTerm%");
               });
           }
       
           // Apply date range filter
           if (!empty($date1) && empty($date2)) {
               // Only date1 provided
               $datas->whereDate('date', $date1);
           } elseif (!empty($date1) && !empty($date2)) {
               // Both date1 and date2 provided
               $datas->whereBetween('date', [$date1, $date2]);
           }
       
           // Apply default conditions (is_cover_well, is_submit)
           $datas->where('is_cover_well', null)->where('is_submit', null);
       
           // Fetch paginated results
           $datas = $datas->latest()->paginate($pagination);
       
           // Get active agents
           $agents = User::where('is_active', 1)->where('status', 1)->get();
    
        return view('admin.disposition.notintersted', compact('datas', 'agents'));
    }
    public function NotConnectedleads(){
        ini_set('memory_limit', '-1');
           // Initialize query
           $datas = ExcelData::where('status', 'forwarded')->where('form_status', 'Not Connected');

           $manager_id = session('admin_id'); 
           // Fetch team_ids for the manager from the manager_team table
           $manager_team = Manager_team::where('manager_id', $manager_id)->first();
           if ($manager_team) {
               // Get the team_ids as a string (e.g., '["2v", "3v"]')
               $services_string = $manager_team->team_ids;
               
               // Clean up the string (remove square brackets and quotes)
               $cleaned_services_string = trim($services_string, '[]"');
               $cleaned_services_string = str_replace('"', '', $cleaned_services_string);
           
               // Convert the cleaned string into an array of team IDs
               $selected_services = explode(',', $cleaned_services_string);
           
               // Remove the "v" from each element in the array
               $selected_services = array_map(function($service) {
                   return str_replace('v', '', $service); // Remove the 'v'
               }, $selected_services);
              
               // If '999' is not in the selected services, filter by team_ids
               if (!in_array('999', $selected_services)) {
                 
                   // Apply the whereIn query to filter by the selected team_ids
                   $datas->whereIn('click_id', $selected_services);
               }
           }
       
           // Apply filters if present
           $state = isset($_GET['state']) ? $_GET['state'] : null;
           $searchTerm = isset($_GET['search_input']) ? $_GET['search_input'] : null;
           $date1 = isset($_GET['date1']) ? $_GET['date1'] : null;
           $date2 = isset($_GET['date2']) ? $_GET['date2'] : null;
           $pagination = isset($_GET['row_pegi']) && !empty($_GET['row_pegi']) ? $_GET['row_pegi'] : 100;
       
           // Apply state filter if provided
           if (!empty($state)) {
               $datas->where('click_id', $state);
           }
       
           // Apply search term filter
           if (!empty($searchTerm)) {
               $datas->where(function ($query) use ($searchTerm) {
                   $query->where('company_name', 'like', "%$searchTerm%")
                       ->orWhere('phone', 'like', "%$searchTerm%")
                       ->orWhere('email', 'like', "%$searchTerm%")
                       ->orWhere('business_state', 'like', "%$searchTerm%");
               });
           }
       
           // Apply date range filter
           if (!empty($date1) && empty($date2)) {
               // Only date1 provided
               $datas->whereDate('date', $date1);
           } elseif (!empty($date1) && !empty($date2)) {
               // Both date1 and date2 provided
               $datas->whereBetween('date', [$date1, $date2]);
           }
       
           // Apply default conditions (is_cover_well, is_submit)
           $datas->where('is_cover_well', null)->where('is_submit', null);
       
           // Fetch paginated results
           $datas = $datas->latest()->paginate($pagination);
       
           // Get active agents
           $agents = User::where('is_active', 1)->where('status', 1)->get();
    
        return view('admin.disposition.notconnected', compact('datas', 'agents'));
    }
    public function InsuredLeadsleads(){
        ini_set('memory_limit', '-1');
        $datas = ExcelData::where('form_status', 'Voice Mail')
        ->paginate(100);
      return view('admin.disposition.InsuredLeads', compact('datas'));
    }
    public function WONleads(){
        ini_set('memory_limit', '-1');
           // Initialize query
           $datas = ExcelData::where('status', 'forwarded')->where('form_status', 'WON');

           $manager_id = session('admin_id'); 
           // Fetch team_ids for the manager from the manager_team table
           $manager_team = Manager_team::where('manager_id', $manager_id)->first();
           if ($manager_team) {
               // Get the team_ids as a string (e.g., '["2v", "3v"]')
               $services_string = $manager_team->team_ids;
               
               // Clean up the string (remove square brackets and quotes)
               $cleaned_services_string = trim($services_string, '[]"');
               $cleaned_services_string = str_replace('"', '', $cleaned_services_string);
           
               // Convert the cleaned string into an array of team IDs
               $selected_services = explode(',', $cleaned_services_string);
           
               // Remove the "v" from each element in the array
               $selected_services = array_map(function($service) {
                   return str_replace('v', '', $service); // Remove the 'v'
               }, $selected_services);
              
               // If '999' is not in the selected services, filter by team_ids
               if (!in_array('999', $selected_services)) {
                 
                   // Apply the whereIn query to filter by the selected team_ids
                   $datas->whereIn('click_id', $selected_services);
               }
           }
       
           // Apply filters if present
           $state = isset($_GET['state']) ? $_GET['state'] : null;
           $searchTerm = isset($_GET['search_input']) ? $_GET['search_input'] : null;
           $date1 = isset($_GET['date1']) ? $_GET['date1'] : null;
           $date2 = isset($_GET['date2']) ? $_GET['date2'] : null;
           $pagination = isset($_GET['row_pegi']) && !empty($_GET['row_pegi']) ? $_GET['row_pegi'] : 100;
       
           // Apply state filter if provided
           if (!empty($state)) {
               $datas->where('click_id', $state);
           }
       
           // Apply search term filter
           if (!empty($searchTerm)) {
               $datas->where(function ($query) use ($searchTerm) {
                   $query->where('company_name', 'like', "%$searchTerm%")
                       ->orWhere('phone', 'like', "%$searchTerm%")
                       ->orWhere('email', 'like', "%$searchTerm%")
                       ->orWhere('business_state', 'like', "%$searchTerm%");
               });
           }
       
           // Apply date range filter
           if (!empty($date1) && empty($date2)) {
               // Only date1 provided
               $datas->whereDate('date', $date1);
           } elseif (!empty($date1) && !empty($date2)) {
               // Both date1 and date2 provided
               $datas->whereBetween('date', [$date1, $date2]);
           }
       
           // Apply default conditions (is_cover_well, is_submit)
           $datas->where('is_cover_well', null)->where('is_submit', null);
       
           // Fetch paginated results
           $datas = $datas->latest()->paginate($pagination);
       
           // Get active agents
           $agents = User::where('is_active', 1)->where('status', 1)->get();
    
        return view('admin.disposition.won', compact('datas', 'agents'));
    }
   public function DNDleads(){
        ini_set('memory_limit', '-1');
          // Initialize query
          $datas = ExcelData::where('status', 'forwarded')->where('form_status', 'DND');

          $manager_id = session('admin_id'); 
          // Fetch team_ids for the manager from the manager_team table
          $manager_team = Manager_team::where('manager_id', $manager_id)->first();
          if ($manager_team) {
              // Get the team_ids as a string (e.g., '["2v", "3v"]')
              $services_string = $manager_team->team_ids;
              
              // Clean up the string (remove square brackets and quotes)
              $cleaned_services_string = trim($services_string, '[]"');
              $cleaned_services_string = str_replace('"', '', $cleaned_services_string);
          
              // Convert the cleaned string into an array of team IDs
              $selected_services = explode(',', $cleaned_services_string);
          
              // Remove the "v" from each element in the array
              $selected_services = array_map(function($service) {
                  return str_replace('v', '', $service); // Remove the 'v'
              }, $selected_services);
             
              // If '999' is not in the selected services, filter by team_ids
              if (!in_array('999', $selected_services)) {
                
                  // Apply the whereIn query to filter by the selected team_ids
                  $datas->whereIn('click_id', $selected_services);
              }
          }
      
          // Apply filters if present
          $state = isset($_GET['state']) ? $_GET['state'] : null;
          $searchTerm = isset($_GET['search_input']) ? $_GET['search_input'] : null;
          $date1 = isset($_GET['date1']) ? $_GET['date1'] : null;
          $date2 = isset($_GET['date2']) ? $_GET['date2'] : null;
          $pagination = isset($_GET['row_pegi']) && !empty($_GET['row_pegi']) ? $_GET['row_pegi'] : 100;
      
          // Apply state filter if provided
          if (!empty($state)) {
              $datas->where('click_id', $state);
          }
      
          // Apply search term filter
          if (!empty($searchTerm)) {
              $datas->where(function ($query) use ($searchTerm) {
                  $query->where('company_name', 'like', "%$searchTerm%")
                      ->orWhere('phone', 'like', "%$searchTerm%")
                      ->orWhere('email', 'like', "%$searchTerm%")
                      ->orWhere('business_state', 'like', "%$searchTerm%");
              });
          }
      
          // Apply date range filter
          if (!empty($date1) && empty($date2)) {
              // Only date1 provided
              $datas->whereDate('date', $date1);
          } elseif (!empty($date1) && !empty($date2)) {
              // Both date1 and date2 provided
              $datas->whereBetween('date', [$date1, $date2]);
          }
      
          // Apply default conditions (is_cover_well, is_submit)
          $datas->where('is_cover_well', null)->where('is_submit', null);
      
          // Fetch paginated results
          $datas = $datas->latest()->paginate($pagination);
      
          // Get active agents
          $agents = User::where('is_active', 1)->where('status', 1)->get();
    
        return view('admin.disposition.dnd', compact('datas', 'agents'));
    }
  public function assigned_leads(Request $request) {
    $datas = managerfwd::latest();
    $manager_id = session('admin_id');
    $selected_services = []; // Initialize the variable
    
    // Fetch team_ids for the manager from the manager_team table
    $manager_team = Manager_team::where('manager_id', $manager_id)->first();
    
    if ($manager_team && !empty($manager_team->team_ids)) {
        try {
            // Get the team_ids as a string (e.g., '["2v", "3v"]')
            $services_string = $manager_team->team_ids;
            
            // Clean up the string (remove square brackets and quotes)
            $cleaned_services_string = trim($services_string, '[]"');
            $cleaned_services_string = str_replace('"', '', $cleaned_services_string);
        
            // Convert the cleaned string into an array of team IDs
            $selected_services = explode(',', $cleaned_services_string);
        
            // Remove the "v" from each element in the array
            $selected_services = array_map(function($service) {
                return str_replace('v', '', $service); // Remove the 'v'
            }, $selected_services);
           
            // If '999' is not in the selected services, filter by team_ids
            if (!in_array('999', $selected_services)) {
                // Apply the whereIn query to filter by the selected team_ids
                $datas->whereIn('agent_id', $selected_services);
            }
        } catch (\Exception $e) {
            // Log error if team_ids processing fails
            \Log::error("Error processing team_ids for manager {$manager_id}: " . $e->getMessage());
            $selected_services = [];
        }
    }
    
    // Add user filter if user_id parameter is present
    if ($request->has('user_id') && $request->user_id != '') {
        $datas->where('agent_id', $request->user_id);
    }
    
    $datas = $datas->get();
    
    // Get all active users for the filter dropdown
    $usersQuery = User::where('is_active', 1)->where('status', 1);
    
    // Only apply team filter if we have valid selected_services and 999 isn't present
    if (!empty($selected_services) && !in_array('999', $selected_services)) {
        $usersQuery->whereIn('id', $selected_services);
    }
    
    $users = $usersQuery->get();
    
    return view('admin.leads.asign_lead', compact('datas', 'users')); 
}
    public function assigned_leads_view(Request $req){
        $id = $_GET['assign'];
        $id = base64_decode($id);
        
        $leads = managerfwd::where('id',$id)->first();
        
        if ($leads) {
            $lead_ids = json_decode($leads->data_id);
            $lead_ids_string = $lead_ids[0]; // Extract the first (and only) element of the array
            $lead_ids_array = explode(',', $lead_ids_string);
        
            if ($lead_ids && is_array($lead_ids)) {
                // Retrieve ExcelData records based on the array of lead IDs
                $datas = ExcelData::whereIn('id', $lead_ids_array)->paginate(100);
                $total = ExcelData::whereIn('id', $lead_ids_array)->count();
                return view('admin.leads.assign_leads_view',compact('datas','id','total'));	
            } else {
                return redirect()->back();
            }
        } else {
            return redirect()->back();
        }
 
    }
    public function assigned_leads_delete($id){
        $id = base64_decode($id);
        
        $leads = managerfwd::where('id',$id)->first();
        
        if ($leads) {
            $lead_ids = json_decode($leads->data_id);
            $lead_ids_string = $lead_ids[0]; // Extract the first (and only) element of the array
            $lead_ids_array = explode(',', $lead_ids_string);
        
            if ($lead_ids && is_array($lead_ids)) {
                // Retrieve ExcelData records based on the array of lead IDs
                $datas = ExcelData::whereIn('id', $lead_ids_array)->get();

                foreach ($datas as $data) {
                    $data->status = 'not_forwarded';
                    $data->save();
                }
            }
            $excelDatas = ExcelData::whereIn('id', $lead_ids_array)->get();
            //-------------reduce tab view -------------
            // Group by batch_name and get the count for each batch
           $batchCounts = $excelDatas->groupBy('batch_name')->map(function (Collection $batch) {
             return $batch->count();
             });
        
        foreach ($batchCounts as $batchName => $count) {
            $tab_view = Tab_view_lead::where('batch',$batchName)->first();
            if ($tab_view) {
                $tab_data = $tab_view->total_data;
                $tab_view->total_data = $tab_data + $count;
                $tab_view->save();
            }
        } 
        } 
        $leads->delete();
        session()->flash('success','data deleted succfully');
        return redirect()->back();
    }
      public function intrested_check(Request $req){
       
         // ✅ VALIDATION — YAHI ADD KARO (TOP PE)
    $req->validate([
        'data_id'   => 'required|exists:excel_data,id',
        'loss_runs' => 'required|in:yes,no',
    ]);

    $id = $req->data_id;
    $comment = $req->comment;
    $exceldata = ExcelData::where('id',$id)->first();
  

 
    $fullimagepath = $exceldata->error_file;
    if (!empty($req->errorfile)) {
        $allowedFormats = ['jpeg', 'jpg', 'pdf'];
        $extension = strtolower($req->errorfile->getClientOriginalExtension());
        if (in_array($extension, $allowedFormats)) {
            $file = time() . 'driversdocs1.' . $req->errorfile->extension();
                $req->errorfile->move(public_path('uploads/image/drivers_docs/'), $file);
                $fullimagepath = 'uploads/image/drivers_docs/' . $file;
        } else {
            // Handle invalid file format (not allowed)
            return redirect()->back()->with('error', 'Invalid file format. Only jpeg, jpg, and pdf files are allowed.');
        }
    }
    
    if($req->redmark == 2){
        $exceldata->verify_level = $req->verify_level;
        if($req->verify_level == 3){
            $exceldata->verify_status = "verified"; 
        }
    }elseif( $req->verify_level== 4){
        $exceldata->verify_level = 0;
    }
    else{
        $exceldata->verify_level = 0;
    }
   
       // $exceldata->comment = $comment;
$this->storeComment($id, $comment);
    $exceldata->red_mark = !empty($req->redmark) ? $req->redmark : null;
    $exceldata->error_file =  $fullimagepath;
    $exceldata->save();
    if(!empty($req->redmark) && $req->redmark == 1){
         if($req->verify_level == 4 && $req->redmark == 1){
            $timeZone = 'America/New_York';

            $currentDate = Carbon::now($timeZone);
        
            $date = $currentDate->format('Y-m-d');
        
            $report = dayendreport::where('user_id',$exceldata->click_id)->where('date',$date)->first();
        
             if(empty($report)){
                $reportdata = new dayendreport();
        
                $total_call = 1;
        
                $reportdata->user_id = $agent_id;
                $reportdata->intrested = $total_call;
                $reportdata->date = $date;
                $reportdata->save();
             }
             else{
                    $totalcall = $report->intrested - 1;
                    $report->intrested = $totalcall;
                }
                $report->save();
        }
        $data = new Notification();
      $data->agent_id = $exceldata->click_id;
      $data->type = "lead_issue";
      $data->heading = "Form Mistake";
      $data->massage = session('position')." got a mistake in your form";
      $data->click_id = 1;
      $data->data_id = $id;
      $data->save();
      $data = [
          'massage'=> session('position').' got a mistake in your form',
          'user_id'=>$exceldata->click_id,
      ];
    event(new UserNotification($data));
}elseif(!empty($req->redmark) && $req->redmark == 3){
    $data = new Notification();
    $data->agent_id = $exceldata->click_id;
    $data->type = "lead_issue";
    $data->heading = "Duplicate Form";
    $data->massage = "Your Form is Duplicate";
    $data->click_id = 1;
    $data->data_id = $id;
    $data->save();
    $data = [
        'massage'=> session('position').' got a mistake in your form',
        'user_id'=>$exceldata->click_id,
    ];
  event(new UserNotification($data));

} else{
    if($req->verify_level == 3){
      $this->add_intrested_call($exceldata->click_id);
    $data = new Notification();
    $data->agent_id = $exceldata->click_id;
    $data->type = "lead_issue";
    $data->heading = "Form Correct";
    $data->massage =" Your Form Is Submitted";
    $data->click_id = 1;
    $data->data_id = $id;
    $data->save();
    $data = [
        'massage'=>' Your Form Is Submitted',
        'user_id'=>$exceldata->click_id,
    ];
  event(new UserNotification($data));
    }
}
 // 🔥 FINAL PLACE — END OF FUNCTION
    $exceldata->loss_runs = $req->loss_runs;
    $exceldata->live_transfer = $req->live_transfer;
    $exceldata->save();
    return redirect()->back();

    }
public function instersted_download($date1 = null, $date2 = null)
{
    ini_set('memory_limit', '-1'); // Allow large memory for Excel export

    // Initialize base query
    $query = ExcelData::where('status', 'forwarded')
                      ->where('form_status', 'Intrested')
                      ->whereNull('is_cover_well')
                      ->whereNull('is_submit');

    // Fetch GET parameters
    $state = request()->query('state', '');
    $searchTerm = request()->query('search_input', '');
    $limit = request()->query('row_pegi', null); // Number of rows to limit

    // Apply state filter
    if (!empty($state)) {
        $query->where('click_id', $state);
    }

    // Apply search filter
    if (!empty($searchTerm)) {
        $query->where(function ($subQuery) use ($searchTerm) {
            $subQuery->where('company_name', 'like', "%$searchTerm%")
                ->orWhere('phone', 'like', "%$searchTerm%")
                ->orWhere('email', 'like', "%$searchTerm%")
                ->orWhere('business_state', 'like', "%$searchTerm%");
        });
    }

    // Apply date range filter (very important - on `date` column, not `updated_at`)
    if (!empty($date1) && empty($date2)) {
        $query->whereDate('date', $date1);
    } elseif (!empty($date1) && !empty($date2)) {
        $query->whereBetween('date', [$date1, $date2]);
    }

    // Always order latest first
    $query->orderBy('date', 'desc');

    // Fetch the data
    if (!empty($limit)) {
        $dataCollection = $query->limit($limit)->get();
    } else {
        $dataCollection = $query->get();
    }

    // Prepare Excel filename
    $today = Carbon::today();
    $formattedDate = $today->format('Y_m_d');
    $filename = 'interested_' . $formattedDate . '.xlsx';

    // Download Excel
    return Excel::download(new interested_leads($dataCollection), $filename);
}




     //--------------------------------- Submit Forms leads --------------------------
      public function submitformstore(Request $req)
{
    $req->validate([
        'leadidss' => 'required|array',
    ]);

    // Extract lead IDs from the array
    $leadIdsString = $req->leadidss[0];
    // Split the string of lead IDs into an array
    $leadIds = explode(',', $leadIdsString);

    // Retrieve the relevant ExcelData records
    $excelDatas = ExcelData::whereIn('id', $leadIds)->get();
 
    // Toggle the is_submit field for each record
    foreach ($excelDatas as $item) {
        $item->is_submit = $item->is_submit == 1 ? null : 1;
       
        $item->save();
    }

    // Flash success message
    $req->session()->flash('success', "Data Submitted Successfully.");

    // Redirect back
    return redirect()->back();
}
public function bluck_delete_assign(Request $req){

   $ids = $req->selected_ids;
   $ids_array = explode(',', $ids);
   foreach($ids_array as $id)
   {   
   $leads = managerfwd::where('id',$id)->first();
   if ($leads) {
       $lead_ids = json_decode($leads->data_id);
       $lead_ids_string = $lead_ids[0]; // Extract the first (and only) element of the array
       $lead_ids_array = explode(',', $lead_ids_string);
   
       if ($lead_ids && is_array($lead_ids)) {
           // Retrieve ExcelData records based on the array of lead IDs
           $datas = ExcelData::whereIn('id', $lead_ids_array)->get();

           foreach ($datas as $data) {
               $data->status = 'not_forwarded';
               $data->save();
           }
       }
       $excelDatas = ExcelData::whereIn('id', $lead_ids_array)->get();
       //-------------reduce tab view -------------
       // Group by batch_name and get the count for each batch
      $batchCounts = $excelDatas->groupBy('batch_name')->map(function (Collection $batch) {
        return $batch->count();
        });
   
   foreach ($batchCounts as $batchName => $count) {
       $tab_view = Tab_view_lead::where('batch',$batchName)->first();
       if ($tab_view) {
           $tab_data = $tab_view->total_data;
           $tab_view->total_data = $tab_data + $count;
           $tab_view->save();
       }
   } 
   } 
   $leads->delete();
}
   session()->flash('success','Assigned leads deleted Successfully');
   return redirect()->back();

}
public function deleteoldintrested(){
    $datas = ExcelData::where('status', 'forwarded')
    ->where('form_status', 'Intrested')
    ->where('red_mark', null)
    ->where('updated_at', '<', Carbon::now()->subDays(2))
    ->get();
    foreach($datas as $data){
        $data->red_mark = 2;
        $data->save();
    }
    
}
//----------------------------------verify check ----------------------------------
public function level_first($id='', $n='') {
    ini_set('memory_limit', '-1');


    // Initialize query
    $datas = ExcelData::where('form_status', 'Intrested')->where('verify_level',1);

    // Apply filters if present
    $state = isset($_GET['state']) ? $_GET['state'] : null;
    $searchTerm = isset($_GET['search_input']) ? $_GET['search_input'] : null;
    $date1 = isset($_GET['date1']) ? $_GET['date1'] : null;
    $date2 = isset($_GET['date2']) ? $_GET['date2'] : null;
    $pagination = isset($_GET['row_pegi']) && !empty($_GET['row_pegi']) ? $_GET['row_pegi'] : 100;

    // Apply state filter if provided
    if (!empty($state)) {
        $datas->where('click_id', $state);
    }

    // Apply search term filter
    if (!empty($searchTerm)) {
        $datas->where(function ($query) use ($searchTerm) {
            $query->where('company_name', 'like', "%$searchTerm%")
                ->orWhere('phone', 'like', "%$searchTerm%")
                ->orWhere('email', 'like', "%$searchTerm%")
                ->orWhere('business_state', 'like', "%$searchTerm%");
        });
    }

    // Apply date range filter
    if (!empty($date1) && !empty($date2)) {
        $datas->whereBetween('updated_at', [$date1, $date2]);
    }

    // Apply default conditions (is_cover_well, is_submit)
    $datas->where('red_mark', null)->where('is_submit', null);

    // Fetch paginated results
    $datas = $datas->latest('updated_at')->paginate($pagination);

    // Get active agents
    $agents = User::where('is_active', 1)->where('status', 1)->get();

    // Return the view with data
    return view('admin.verification.first_level', compact('datas', 'agents'));
}

public function second_level($id='', $n='') {
    ini_set('memory_limit', '-1');

    // Check if specific notification is provided
    if (!empty($n)) {
        $noti = Notification::where('id', $n)->first();
        if ($noti) {
            $noti->click_id = 2;
            $noti->save();
        }
        $datas = ExcelData::where('id', $id)->paginate(10);
        return view('admin.disposition.new_intrested', compact('datas'));
    }

    // Initialize query
    $datas = ExcelData::where('form_status', 'Intrested')->where('verify_level',2);

    // Apply filters if present
    $state = isset($_GET['state']) ? $_GET['state'] : null;
    $searchTerm = isset($_GET['search_input']) ? $_GET['search_input'] : null;
    $date1 = isset($_GET['date1']) ? $_GET['date1'] : null;
    $date2 = isset($_GET['date2']) ? $_GET['date2'] : null;
    $pagination = isset($_GET['row_pegi']) && !empty($_GET['row_pegi']) ? $_GET['row_pegi'] : 100;

    // Apply state filter if provided
    if (!empty($state)) {
        $datas->where('click_id', $state);
    }

    // Apply search term filter
    if (!empty($searchTerm)) {
        $datas->where(function ($query) use ($searchTerm) {
            $query->where('company_name', 'like', "%$searchTerm%")
                ->orWhere('phone', 'like', "%$searchTerm%")
                ->orWhere('email', 'like', "%$searchTerm%")
                ->orWhere('business_state', 'like', "%$searchTerm%");
        });
    }

    // Apply date range filter
    if (!empty($date1) && !empty($date2)) {
        $datas->whereBetween('updated_at', [$date1, $date2]);
    }

    // Apply default conditions (is_cover_well, is_submit)
    $datas->where('is_submit', null);

    // Fetch paginated results
    $datas = $datas->latest('updated_at')->paginate($pagination);

    // Get active agents
    $agents = User::where('is_active', 1)->where('status', 1)->get();

    // Return the view with data
    return view('admin.verification.second_level', compact('datas', 'agents'));
}

private function add_intrested_call($agent_id){

    $timeZone = 'America/New_York';

    $currentDate = Carbon::now($timeZone);

    $date = $currentDate->format('Y-m-d');

    $report = dayendreport::where('user_id',$agent_id)->where('date',$date)->first();

     if(empty($report)){
        $reportdata = new dayendreport();

        $total_call = 1;

        $reportdata->user_id = $agent_id;
        $reportdata->intrested = $total_call;
        $reportdata->date = $date;
        $reportdata->save();
     }
     else{
        if( $report->intrested == null){
            $report->intrested = 1;
        }else{
            $totalcall = $report->intrested + 1;
            $report->intrested = $totalcall;
        }
        $report->save();
     }
}
public function view_email_intrestred(Request $req)
{
    ini_set('memory_limit', '-1');
    
    // Initialize the query
    $query = Interested_email::query();

    // Apply search filters
    if ($req->has('search_input') && !empty($req->search_input)) {
        $query->where(function($q) use ($req) {
            $q->where('company_name', 'like', '%' . $req->search_input . '%')
              ->orWhere('phone', 'like', '%' . $req->search_input . '%')
              ->orWhere('email', 'like', '%' . $req->search_input . '%');
        });
    }

    if ($req->has('row_pegi') && !empty($req->row_pegi)) {
        $query->paginate((int)$req->row_pegi);
    } else {
        $query->paginate(10); // default pagination
    }

    if ($req->has('agent') && !empty($req->agent)) {
        $query->where('agent_id', $req->agent);
    }

    if ($req->has('date1') && $req->has('date2') && !empty($req->date1) && !empty($req->date2)) {
        $query->whereBetween('updated_at', [$req->date1, $req->date2]);
    }

    // Get active agents
    $agents = User::where('is_active', 1)->where('status', 1)->get();

    // Paginate the query result based on row_pegi or default to 10
    $datas = $query->paginate($req->get('row_pegi', 10))->appends($req->all());

    // Return the view with data
    return view('admin.verification.view_email_interested', compact('datas', 'agents'));
}

public function update_emailintre_status(Request $req,$idd ,$statuss){
   $id =  base64_decode($idd);
   $status =  base64_decode($statuss);

   $data = Interested_email::where('id',$id)->first();
   if($status == "good"){
    $this->add_intrested_call($data->agent_id);
    $data->status = 2;
   
   }elseif($status == "bad"){
    $data->status = 3;
   }
   $data->save();
  return redirect()->back();
}
public function delete_emailintre($idd){
    $id =  base64_decode($idd); 
    $data = Interested_email::where('id',$id)->first();
    if(!empty($data)){
        $data->delete();
    }
    return redirect()->back();
}
public function dashboard_intrested(Request $req, $idd)
{
    $id = base64_decode($idd);
    ini_set('memory_limit', '-1');

    // Initialize query for ExcelData
    $datas = ExcelData::where('form_status', 'Intrested')
        ->where('red_mark', 2)
        ->where('click_id', $id);

    // Default date1 to the start of the current month if not provided
    $date1 = $req->input('date1') ? Carbon::parse($req->input('date1')) : Carbon::now()->startOfMonth();
    $date2 = $req->input('date2') ? Carbon::parse($req->input('date2')) : $date1->copy()->endOfMonth();
    $pagination = $req->input('row_pegi', 100);

    // Apply search term filter
    $searchTerm = $req->input('search_input', null);
    if (!empty($searchTerm)) {
        $datas->where(function ($query) use ($searchTerm) {
            $query->where('company_name', 'like', "%$searchTerm%")
                ->orWhere('phone', 'like', "%$searchTerm%")
                ->orWhere('email', 'like', "%$searchTerm%")
                ->orWhere('business_state', 'like', "%$searchTerm%");
        });
    }

    // Apply date range filter for ExcelData
    if (!empty($date1) && !empty($date2)) {
        $datas->whereBetween('date', [$date1, $date2]);
    }

    // Fetch paginated results for ExcelData
    $datas = $datas->latest('updated_at')->paginate($pagination);

    // Define the start and end of the current or selected month
    $startOfMonth = $date1->copy()->startOfMonth();
    $endOfMonth = $date1->copy()->endOfMonth();

    // Retrieve dayendreport data for the current month or selected date range
    $dayendreports = dayendreport::where('user_id', $id)
        ->whereBetween('date', [$startOfMonth, $endOfMonth])
        ->get()
        ->map(function ($report) {
            // Ensure the 'date' is parsed as a Carbon instance
            $report->date = Carbon::parse($report->date);
            return $report;
        });

    // Explicitly define week ranges based on the start of the month
    $week1End = $startOfMonth->copy()->addDays(6);
    $week2Start = $week1End->copy()->addDay();
    $week2End = $week2Start->copy()->addDays(6);
    $week3Start = $week2End->copy()->addDay();
    $week3End = $week3Start->copy()->addDays(6);
    $week4Start = $week3End->copy()->addDay();

    // Calculate sums for each explicitly defined week of the month
    $week1Sum = $dayendreports->whereBetween('date', [$startOfMonth, $week1End])->sum('intrested');
    $week2Sum = $dayendreports->whereBetween('date', [$week2Start, $week2End])->sum('intrested');
    $week3Sum = $dayendreports->whereBetween('date', [$week3Start, $week3End])->sum('intrested');
    $week4Sum = $dayendreports->whereBetween('date', [$week4Start, $endOfMonth])->sum('intrested');
    $monthSum = $dayendreports->sum('intrested');

    // Get active agent details
    $agent = User::where('id', $id)->first();

    // Pass the sums and data to the view
    return view('admin.verification.dashboard_intrested', compact('datas', 'agent', 'week1Sum', 'week2Sum', 'week3Sum', 'week4Sum', 'monthSum'));
}
public function remove_intrested(Request $req ,$idd,$user_idd){
    $id = base64_decode($idd);
    $user_id = base64_decode($user_idd);

      $data = ExcelData::where('id',$id)->first();
       $data->form_status = "NEW";
       $data->save();
    
        $report = dayendreport::where('user_id',$user_id)->where('date',$data->date)->first();
         if(!empty($report)){
            $totalcall = $report->intrested - 1;
            $report->intrested = $totalcall;
            $report->save();
         }
         return redirect()->back();
    

}
public function admin_global_search(Request $req,$searchh){
    $searchTerm = base64_decode($searchh);

    // Perform the search query
    $datas = ExcelData::orWhere('company_name', 'like', "%$searchTerm%")
                        ->orWhere('phone', 'like', "%$searchTerm%")
                        ->orWhere('email', 'like', "%$searchTerm%")
                        ->orWhere('dot', 'like', '%' . $searchTerm . '%')
                        ->orWhere('mc_docket', 'like', '%' . $searchTerm . '%')
                        ->paginate(10);
  return view('admin.leads.search_data', compact('datas'));

}
public function view_lead_details(Request $req, $idd)
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
    }
    return view('admin/leads/view_lead_detail', compact('excel_data', 'historys', 'duplicates'));
}
private function storeComment($leadId,$recivecomment)
{
    // Retrieve the lead and decode existing comments or initialize an empty array if null
    $lead = ExcelData::findOrFail($leadId);
    $comments = $lead->comment ? json_decode($lead->comment, true) : [];

    // Append the new comment to the comments array
    $comments[] = [
        'agent_name' => session('admin_name'), // Get current user's name
        'comment' => $recivecomment,
        'created_at' => now()->toDateTimeString(),
    ];

    // Save the updated comments array back as JSON to avoid overwriting
    $lead->comment = json_encode($comments, JSON_UNESCAPED_UNICODE);
    $lead->save();

    return back();
}
   //==================================================== Auto Forwarding =============================
    public function add_auto_forward(Request $req)
	{
			$service_data = User::where('status', 1)->where('is_active', 1)->latest('created_at')->get();
            $datas = Tab_view_lead::with('team')->latest()->get();
            $team = Auto_forward::first();
			return view('admin/auto_forward/add', compact('service_data','datas','team'));
	}
    public function store_auto_forward(Request $request){
        // Validate the incoming request data
          $validatedData = $request->validate([
            'services' => 'nullable|array', // Services can be null or an array
            'services.*' => 'integer', // Validate individual service IDs
            'tab_view' => 'required', // Validate Tab View selection
        ]);
        $service = $request->input('service');
			$services = $request->input('services');
        // Handle the "All" checkbox selection
        if ($service == 999) {
            $ser = '["999"]';
        } else {
            $ser = json_encode($services);
        }
        // Example: Saving data to a database table
       $agent = Auto_forward::first();
        $agent->user_id = $ser; 
        $agent->tab_view_ids = $validatedData['tab_view']; 
        $agent->status = 1;
        $agent->save();
    
        // Redirect back with a success message
        return redirect()->back()->with('success', 'Auto forwarding start successfully.');

    }
      public function changeStatusforward(Request $request, $team_id){
          // Find the team by ID
    $team = Auto_forward::find($team_id);

    if ($team) {
        // Toggle the status
        $team->status = $team->status == 1 ? 0 : 1;
        $team->save();

        return redirect()->back()->with('success', 'Status updated successfully!');
    }

    return redirect()->back()->with('error', 'Team not found!');
    }
 //==================================================== verified_lead_manage =============================
        public function verified_lead_manage(Request $req)
        {
        
                return view('admin/verification/verified_leads_manage');
        }

        public function getVerifiedLeads(Request $request)
        {
            // Start building the query with eager loading for the 'userDetail' relationship
            $query = ExcelData::with('userDetail')
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
            $leads = $query->latest('date')->get();
        
            // Return the filtered data as JSON
            return response()->json($leads);
        }
        
        
        public function updateLeadStatus(Request $req)
        {
           $id = $req->id;
           $status = $req->status;
           $starred = $req->starred;
            $data = ExcelData::where('id', $id)->first();
         
            if(empty($status)){
                $status =  $data->verify_status ?? '';
            }
            if($starred == "false"){
                $starred = null;
            }
            if($data){
                $data->verify_status = $status;
                $data->star_mark = $starred;
                $data->save();
                return response()->json(['status' => 'success']);
            }
            return response()->json(['status' => 'lead not found']);
        }

        public function getLeadById($id)
{
    $lead = ExcelData::with('userDetail')->with('unitOwned')->findOrFail($id); // Fetch lead data and related user details
    return response()->json($lead);
}
public function correct_all_date()
{
    // Fetch records where 'verify_status' is not null and 'date' is null
    $records = ExcelData::whereNotNull('verify_status')
        ->whereNull('date')
        ->get();

    foreach ($records as $record) {
        $record->date = $record->created_at; // Set 'date' to 'created_at'
        $record->save(); // Save the updated model
    }
}

   }
