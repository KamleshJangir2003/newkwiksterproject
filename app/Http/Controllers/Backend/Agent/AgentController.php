<?php

namespace App\Http\Controllers\Backend\Agent;

use App\Events\RealTimeMessage;
use App\Http\Controllers\Controller;
use App\Models\ExcelData;
use App\Models\unitOwned;
use App\Models\managerfwd;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\clientForm;

class AgentController extends Controller
{
    // Dashboard
    public function dashboard()
    {
        $total_form = ExcelData::where('click_id', auth()->user()->id)->where('form_status', 'Intrested')->get();
        $total_pipeline = ExcelData::where('click_id', auth()->user()->id)->where('form_status', 'Pipeline')->get();


        // Daily
        $currentUserId = auth()->user()->id;
        $currentDate = now()->toDateString();

        $total_form_daily = ExcelData::where('click_id', $currentUserId)
            ->where('form_status', 'Intrested')
            ->whereDate('updated_at', $currentDate)
            ->get();

        $total_pipeline_daily = ExcelData::where('click_id', $currentUserId)
            ->where('form_status', 'Pipeline')
            ->whereDate('updated_at', $currentDate)
            ->get();

        $total_client_form = clientForm::where('user_id', auth()->user()->id)->get();
        $insurance_sold = clientForm::where('status', 'Sold')->where('user_id', auth()->user()->id)->get();
        $total_pipeline_client = clientForm::where('status', 'Pipeline')->where('user_id', auth()->user()->id)->get();
        $total_cancel_client = clientForm::where('status', 'Cancel')->where('user_id', auth()->user()->id)->get();
        $total_lost_client = clientForm::where('status', 'Lost')->where('user_id', auth()->user()->id)->get();
        
        $total_approve=clientForm::where('approved_declined','Approved')->where('user_id',auth()->user()->id)->get();
        $total_decline=clientForm::where('approved_declined','Declined')->where('user_id',auth()->user()->id)->get();
        

        return view('backend.agent.dashboard', compact('total_form', 'total_pipeline', 'total_form_daily', 'total_pipeline_daily', 'total_client_form', 'insurance_sold', 'total_pipeline_client', 'total_cancel_client', 'total_lost_client','total_approve','total_decline'));
    }

    public function changeFormStatus(Request $request, $data_id, $form_status, $form_status_value)
    {
        $data_id = $data_id;
        $form_status = $form_status;
        $form_status_value = $form_status_value;

        $data = ExcelData::find($data_id);
        if ($data) {
            $data->form_status = $form_status;
            $data->form_status_value = $form_status_value;
            $data->click_id = auth()->user()->id;
            $data->save();
            managerfwd::where('data_id', $data_id)->delete();
            // Trigger the event outside of the loop
            $data = ['name' => auth()->user()->name, 'message' => "Submit $form_status" ];
            if($form_status=='Intrested'){
                event(new RealTimeMessage($data, 'my-channel1', 'my-event1'));
            $request->session()->flash('success', "Form status change to $form_status");
            }
            return redirect()->back();
        }
    }

    // Get Data
    public function getData($id)
    {
        $unitOwned = UnitOwned::where('data_id', $id)->first();
        if ($unitOwned) {
            $excelData = ExcelData::find($id);

            if (!$unitOwned || !$excelData) {
                return response()->json(['error' => 'Data not found'], 404);
            }

            // Concatenate the data into a single array
            $data = array_merge($unitOwned->toArray(), $excelData->toArray());
        } else {
            $data = ExcelData::find($id);
        }

        return response()->json($data);
    }


    // Update Data
    public function updateData(Request $request)
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
            'commodities' => 'nullable|array',
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
        
        if (!array_key_exists('commodities', $validated)) {
        $validated['commodities'] = null;
    } else {
        $commodities = json_encode($validated['commodities']);
        $validated['commodities'] = $commodities;
    }


        $dataId = $request->data_id;
        $unitOwned = UnitOwned::updateOrCreate(
            ['data_id' => $dataId],
            $validated2
        );
        if ($unitOwned) {
            $request->session()->flash('success', 'Unit Owned Data submitted successfully!');
        }
        $form_status=$request->form_status;
        $data = ExcelData::find($request->data_id);
        if ($data) {
            $data->update($validated);
            managerfwd::where('data_id', $request->data_id)->delete();
            $request->session()->flash('success', 'Data submitted successfully!');
             $data = ['name' => auth()->user()->name, 'message' => "Submit $form_status" ];
            if($form_status=='Intrested'){
                event(new RealTimeMessage($data, 'my-channel1', 'my-event1'));
            $request->session()->flash('success', "Form status change to $form_status");
            }
        } else {
            $request->session()->flash('error', 'Something went wrong. Please try again!');
        }

        return redirect()->back();
    }

    public function storeSingleData(Request $request)
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
        
        if (!array_key_exists('commodities', $validated)) {
        $validated['commodities'] = null;
    } else {
        $commodities = json_encode($validated['commodities']);
        $validated['commodities'] = $commodities;
    }

        $user = User::find(auth()->user()->id);
        $validated['status'] = 'forwarded';
        $validated['click_id'] = $user->id;
        $validated['rel_id'] = $user->rel_id;

        // Create ExcelData
        $data = ExcelData::create($validated);

        if ($data) {
            // Retrieve the ID of the created ExcelData record
            $dataId = $data->id;

            // Create UnitOwned with data_id
            $unitOwned = UnitOwned::create(array_merge(['data_id' => $dataId], $validated2));

            if ($unitOwned) {
                $request->session()->flash('success', 'Unit Owned Data submitted successfully!');
            }

            $request->session()->flash('success', 'Data submitted successfully!');
        } else {
            $request->session()->flash('error', 'Something went wrong. Please try again!');
        }

        return redirect()->back();
    }
    // ➕ Add this for "New Chat" fresh start
public function newChat()
{
    $agent = auth()->user(); // already logged in agent
    if (!$agent) {
        return redirect()->route('ajent_login')->with('error', 'Unauthorized access.');
    }

    // Clear chat list state (frontend me empty list show hogi)
    return response()->json([
        'success' => true,
        'message' => 'New chat started',
        'agent_name' => $agent->name
    ]);
}

}
