<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\adminmodel\ExcelData;
use App\Models\User;
use App\Models\Manager_team;

class LiveTransferController extends Controller
{
    public function index(Request $request)
    {
        ini_set('memory_limit', '-1');

        // Initialize query for interested leads
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
        $state = $request->get('state');
        $searchTerm = $request->get('search_input');
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $pagination = $request->get('row_pegi', 100);

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

        return view('admin.live_transfer.index', compact('datas', 'agents'));
    }
    
    public function updateLiveTransfer(Request $request)
    {
        try {
            $leadId = $request->lead_id;
            $liveTransfer = $request->live_transfer;
            
            $lead = ExcelData::find($leadId);
            if ($lead) {
                $lead->live_transfer = $liveTransfer;
                $lead->save();
                
                return response()->json([
                    'success' => true,
                    'message' => 'Live transfer status updated successfully'
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Lead not found'
            ], 404);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating live transfer status'
            ], 500);
        }
    }
}
