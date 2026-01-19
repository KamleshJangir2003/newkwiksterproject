<?php

namespace App\Http\Controllers\Backend\Manager;

use App\Events\RealTimeMessage;
use App\Http\Controllers\Controller;
use App\Models\ExcelData;
use App\Models\User;
use App\Notifications\CrmNotification;
use Illuminate\Http\Request;
use App\Models\clientForm;

class ManagerController extends Controller
{
    // Dashboard
    // public function dashboard()
    // {
    //     $agent = User::where('rel_id', auth()->user()->id)->first();
    //     $currentDate = now()->toDateString();

    //     $agent_total_form = ExcelData::where('click_id', $agent->id)
    //         ->where('form_status', 'Intrested')
    //         ->get();

    //     $manager_total_form = ExcelData::where('click_id', auth()->user()->id)
    //         ->where('form_status', 'Intrested')
    //         ->get();

    //     $agent_total_pipeline = ExcelData::where('click_id', $agent->id)
    //         ->where('form_status', 'Pipeline')
    //         ->get();

    //     $manager_total_pipeline = ExcelData::where('click_id', auth()->user()->id)
    //         ->where('form_status', 'Pipeline')
    //         ->get();

    //     // Combine both collections into a single collection
    //     $total_form = $agent_total_form->merge($manager_total_form);
    //     $total_pipeline = $agent_total_pipeline->merge($manager_total_pipeline);

    //     // Daily Data
    //     $agent_total_form_daily = ExcelData::where('click_id', $agent->id)
    //         ->where('form_status', 'Intrested')
    //         ->whereDate('updated_at', $currentDate)
    //         ->get();

    //     $manager_total_form_daily = ExcelData::where('click_id', auth()->user()->id)
    //         ->where('form_status', 'Intrested')
    //         ->whereDate('updated_at', $currentDate)
    //         ->get();

    //     $agent_total_pipeline_daily = ExcelData::where('click_id', $agent->id)
    //         ->where('form_status', 'Pipeline')
    //         ->whereDate('updated_at', $currentDate)
    //         ->get();

    //     $manager_total_pipeline_daily = ExcelData::where('click_id', auth()->user()->id)
    //         ->where('form_status', 'Pipeline')
    //         ->whereDate('updated_at', $currentDate)
    //         ->get();

    //     // Combine both collections into a single collection
    //     $total_form_daily = $agent_total_form_daily->merge($manager_total_form_daily);
    //     $total_pipeline_daily = $agent_total_pipeline_daily->merge($manager_total_pipeline_daily);
    //     return view('backend.manager.dashboard', compact('total_form', 'total_pipeline', 'total_form_daily', 'total_pipeline_daily'));
    // }

    public function dashboard()
    {
        // Get the agent
        $agent = User::where('rel_id', auth()->user()->id)->first();

        // Check if the agent is not found
        if (!$agent) {
            // Display the dashboard without specific data
            return view('backend.manager.dashboard');
        }

        $currentDate = now()->toDateString();

        // Retrieve data for agent and manager
        $agent_total_form = ExcelData::where('click_id', $agent->id)
            ->where('form_status', 'Intrested')
            ->get();

        $manager_total_form = ExcelData::where('click_id', auth()->user()->id)
            ->where('form_status', 'Intrested')
            ->get();

        $agent_total_pipeline = ExcelData::where('click_id', $agent->id)
            ->where('form_status', 'Pipeline')
            ->get();

        $manager_total_pipeline = ExcelData::where('click_id', auth()->user()->id)
            ->where('form_status', 'Pipeline')
            ->get();

        // Check if both agent and manager data exist
        if ($agent_total_form->isNotEmpty() || $manager_total_form->isNotEmpty() || $agent_total_pipeline->isNotEmpty() || $manager_total_pipeline->isNotEmpty()) {
            // Combine both collections into a single collection
            $total_form = $agent_total_form->merge($manager_total_form);
            $total_pipeline = $agent_total_pipeline->merge($manager_total_pipeline);

            // Daily Data
            $agent_total_form_daily = ExcelData::where('click_id', $agent->id)
                ->where('form_status', 'Intrested')
                ->whereDate('updated_at', $currentDate)
                ->get();

            $manager_total_form_daily = ExcelData::where('click_id', auth()->user()->id)
                ->where('form_status', 'Intrested')
                ->whereDate('updated_at', $currentDate)
                ->get();

            $agent_total_pipeline_daily = ExcelData::where('click_id', $agent->id)
                ->where('form_status', 'Pipeline')
                ->whereDate('updated_at', $currentDate)
                ->get();

            $manager_total_pipeline_daily = ExcelData::where('click_id', auth()->user()->id)
                ->where('form_status', 'Pipeline')
                ->whereDate('updated_at', $currentDate)
                ->get();

            // Combine both daily collections into a single collection
            $total_form_daily = $agent_total_form_daily->merge($manager_total_form_daily);
            $total_pipeline_daily = $agent_total_pipeline_daily->merge($manager_total_pipeline_daily);
            
             $total_approve=clientForm::where('approved_declined','Approved')->get();
        $total_decline=clientForm::where('approved_declined','Declined')->get();
        
            return view('backend.manager.dashboard', compact('total_form', 'total_pipeline', 'total_form_daily', 'total_pipeline_daily','total_approve','total_decline'));
        } else {
            // Display the dashboard without specific data
            return view('backend.manager.dashboard');
        }
    }


    public function sendPusher(){

        $data=['name'=>'Ajeet','age'=>'19'];
        event(new RealTimeMessage($data,'my-channel','my-event'));
    }
}
