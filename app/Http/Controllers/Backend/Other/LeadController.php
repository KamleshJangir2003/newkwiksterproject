<?php

namespace App\Http\Controllers\Backend\Other;

use App\Http\Controllers\Controller;
use App\Models\adminfwd;
use App\Models\ExcelData;
use App\Models\managerfwd;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\MasterExcelData;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class LeadController extends Controller
{
    public function allLeads()
    {
        ini_set('memory_limit', '-1');
        $datas = ExcelData::where('status', 'not_forwarded')->where('rel_id', auth()->user()->id)->paginate(100);
        $dnddatas = ExcelData::where('form_status', 'DND')->get();
        foreach ($datas as $data) {
        $data->is_dnd = $dnddatas->contains('phone', $data->phone);
        }

        $managers = User::where('designation', 'Manager')->get();
        return view('backend.leads.all', compact('datas', "managers"));
    }
    public function tabLeadsView($batchName)
    {
        ini_set('memory_limit', '-1');
        $batchname=decrypt($batchName);
        $datas = ExcelData::where('status', 'not_forwarded')->where('batch_name',$batchname)->paginate(100);
        $dnddatas = ExcelData::where('form_status', 'DND')->get();
        foreach ($datas as $data) {
        $data->is_dnd = $dnddatas->contains('phone', $data->phone);
        }

        $managers = User::where('designation', 'Manager')->get();
        return view('backend.leads.all', compact('datas', "managers"));
    }
    
    public function tabLeads()
    {
        ini_set('memory_limit', '-1');
        $excelData = ExcelData::where('status', 'not_forwarded')->get()->groupBy('batch_name');
        return view('backend.leads.tab_view',compact('excelData'));
    }
    public function managertabLeads()
    {
        ini_set('memory_limit', '-1');
        $excelData = ExcelData::where('status', 'not_forwarded')->where('click_id',null)->where('rel_id', auth()->user()->id)->get()->groupBy('batch_name');
        return view('backend.leads.manager_tab_view',compact('excelData'));
    }
   public function tabLeadsDelete(Request $request,$batchName)
   {
    ini_set('memory_limit', '-1');
    $batchname = decrypt($batchName);
    $excelData = ExcelData::where('batch_name', $batchname)->where('status', 'not_forwarded')->where('click_id', null)->get();
    // Check if any records were found
    if ($excelData->count() > 0) {
        // Delete the records
        ExcelData::where('batch_name', $batchname)->where('status', 'not_forwarded')->where('click_id', null)->delete();

        $request->session()->flash('success', 'Data deleted successfully!');
    } else {
        $request->session()->flash('error', 'Data not found!');
    }
    return redirect()->back();
    }

    public function deleteLead(Request $request, $id)
    {
        $excelData = ExcelData::find($id);
        if ($excelData) {
            $excelData->delete();
            $request->session()->flash('success', 'Data deleted successfully!');
        } else {
            $request->session()->flash('success', 'Data not found!');
        }
        return redirect()->back();
    }

    public function bulkDeleteLeads(Request $request)
    {
        $dataIds = $request->input('data_ids', []);
        ExcelData::whereIn('id', $dataIds)->delete();
        $request->session()->flash('success', 'Data deleted successfully!');
        return response()->json(['message' => 'Data deleted successfully']);
    }

    public function managerAllLeads()
    {
        ini_set('memory_limit', '-1');
        $datas = ExcelData::where('status', 'not_forwarded')->where('rel_id', auth()->user()->id)->where('form_status', 'NEW')->paginate(100);
        $dnddatas = ExcelData::where('form_status', 'DND')->get();
        foreach ($datas as $data) {
        $data->is_dnd = $dnddatas->contains('phone', $data->phone);
        }
        $agents = User::where('designation', 'Agent')->get();
        return view('backend.leads.manager_all', compact('datas', 'agents'));
    }
     public function managertabLeadsView($batchName)
    {
        ini_set('memory_limit', '-1');
        $batchname=decrypt($batchName);
        $datas = ExcelData::where('status', 'not_forwarded')->where('batch_name',$batchname)->where('click_id',null)->paginate(100);
        $dnddatas = ExcelData::where('form_status', 'DND')->get();
        foreach ($datas as $data) {
        $data->is_dnd = $dnddatas->contains('phone', $data->phone);
        }
        $agents = User::where('designation', 'Agent')->get();
        return view('backend.leads.manager_all', compact('datas', "agents"));
    }

    public function managerAssignedLeads()
    {
        $managerFwdData = Managerfwd::with(['excelData.managerfwd', 'user:id,name'])->get();

        $groupedExcelData = $managerFwdData->sortByDesc('batch')->groupBy('batch')->map(function ($items) {
            return $items->pluck('excelData')->flatten();
        });

        return view('backend.leads.manager_assigned', compact('groupedExcelData'));
    }

    public function adminAssignedLeads()
    {
        $adminFwdData = adminfwd::with(['excelData.adminfwd', 'user:id,name'])->get();

        $groupedExcelData = $adminFwdData->sortByDesc('batch')->groupBy('batch')->map(function ($items) {
            return $items->pluck('excelData')->flatten();
        });

        return view('backend.leads.admin_assigned', compact('groupedExcelData'));
    }


    public function managerViewAssignedLeads($id)
    {
        $batch_id = decrypt($id);
        $managerFwdData = managerfwd::where('batch', $batch_id)->get();
        $datas = [];

        foreach ($managerFwdData as $data) {
            $datas[] = ExcelData::where('id', $data->data_id)->get();
        }
        $agents = User::where('designation', 'Agent')->get();
        return view('backend.leads.manager_assigned_view', compact('datas', 'agents'));
    }

    public function managerDeleteAssignedLeads(Request $request, $id)
    {
        $batch_id = decrypt($id);
        $managerFwdData = ManagerFwd::where('batch', $batch_id)->get();
        $datas = [];

        foreach ($managerFwdData as $data) {
            $excelData = ExcelData::where('id', $data->data_id)->first(); // Use first() instead of get()
            $datas[] = $excelData;
            $excelData->status = 'not_forwarded';
            $excelData->save();
        }

        if ($managerFwdData->isNotEmpty()) { // Check if the collection is not empty
            $managerFwdData->each->delete(); // Use each() to delete each item in the collection
        }

        $request->session()->flash('success', 'Assigned Leads Deleted Successfully!');
        return redirect()->back();
    }
    public function adminDeleteAssignedLeads(Request $request, $id)
    {
        $batch_id = decrypt($id);
        $adminFwdData = adminfwd::where('batch', $batch_id)->get();
        $datas = [];

        foreach ($adminFwdData as $data) {
            $excelData = ExcelData::where('id', $data->data_id)->first(); // Use first() instead of get()
            $datas[] = $excelData;
            $excelData->status = 'not_forwarded';
            $excelData->save();
        }

        if ($adminFwdData->isNotEmpty()) { // Check if the collection is not empty
            $adminFwdData->each->delete(); // Use each() to delete each item in the collection
        }

        $request->session()->flash('success', 'Assigned Leads Deleted Successfully!');
        return redirect()->back();
    }


    public function adminViewAssignedLeads($id)
    {
        $batch_id = decrypt($id);
        $adminFwdData = adminfwd::where('batch', $batch_id)->get();
        $datas = [];

        foreach ($adminFwdData as $data) {
            $datas[] = ExcelData::where('id', $data->data_id)->get();
        }
        $managers = User::where('designation', 'Manager')->get();
        return view('backend.leads.admin_assigned_view', compact('datas', 'managers'));
    }


    public function managerIncomingLeads()
    {
        $adminFwdData = adminfwd::with('excelData')
            ->where('mng_id', auth()->user()->id)
            ->whereHas('excelData', function ($query) {
                $query->where('form_status', 'NEW');
            })
            ->get();

        $groupedExcelData = $adminFwdData->sortByDesc('batch')->groupBy('batch')->map(function ($items) {
            return $items->pluck('excelData')->flatten();
        });

        return view('backend.leads.manager_incoming', compact('groupedExcelData'));
    }


    public function managerViewIncomingLeads($id)
    {
        $batch_id = decrypt($id);
        $adminFwdData = adminfwd::where('batch', $batch_id)->get();
        $datas = [];

        foreach ($adminFwdData as $data) {
            $datas[] = ExcelData::where('id', $data->data_id)->where('form_status', 'NEW')->get();
        }
        $agents = User::where('designation', 'Agent')->get();
        return view('backend.leads.manager_incoming_view', compact('datas', 'agents'));
    }

    // Agent
    public function agentIncomingLeads()
    {
        $managerFwdData = managerfwd::with('excelData')->where('agent_id', auth()->user()->id)->get();

        $groupedExcelData = $managerFwdData->sortByDesc('batch')->groupBy('batch')->map(function ($items) {
            return $items->pluck('excelData')->reject(function ($item) {
                return collect($item)->contains(function ($value) {
                    return in_array($value, ['Intrested', 'Pipeline', 'Voice Mail', 'Not Intrested', 'Not Connected', 'Wrong Number','Insured']);
                });
            })->flatten();
        });

        return view('backend.leads.agent_incoming', compact('groupedExcelData'));
    }

    public function agentViewIncomingLeads($id)
    {
        $batch_id = decrypt($id);
        $managerFwdData = managerfwd::where('batch', $batch_id)->get();
        $datas = [];

        foreach ($managerFwdData as $data) {
            $datas[] = ExcelData::where('id', $data->data_id)->where('form_status', 'NEW')->get();
        }
        return view('backend.leads.agent_incoming_view', compact('datas'));
    }

    // Manager Leads
   public function managerintrestedLeads()
{
    $userId = auth()->user()->id;
    $agentIds = User::where('rel_id', $userId)->pluck('id')->toArray();
    
    $agentDatas = ExcelData::where('form_status', 'Intrested')->whereIn('click_id', $agentIds);
    $managerDatas = ExcelData::where('form_status', 'Intrested')->where('click_id', $userId);
    
    $datas = $agentDatas->union($managerDatas)->orderByDesc('updated_at')->paginate(100);
    
    $agents = User::where('rel_id', $userId)->get();
    
    return view('backend.leads.manager_leads', compact('datas', 'agents'));
}

    
    public function managermintrestedLeads()
    {
        $userId = auth()->user()->id;
    $agentIds = User::where('rel_id', $userId)->pluck('id')->toArray();
    
    $mAgentDatas = MasterExcelData::where('form_status', 'Intrested')->whereIn('click_id', $agentIds)->get();
    $mManagerDatas = MasterExcelData::where('form_status', 'Intrested')->where('click_id', $userId)->get();
    
    $datas = $mAgentDatas->concat($mManagerDatas);
    
    $datas = $datas->sortByDesc('updated_at');
    $agents = User::where('rel_id', $userId)->get();
    
    return view('backend.leads.manager_mleads', compact('datas', 'agents'));
    }

   public function managerpipelineLeads()
{
    $userId = auth()->user()->id;
    $agentIds = User::where('rel_id', $userId)->pluck('id')->toArray();
    
    $agentDatas = ExcelData::where('form_status', 'Pipeline')->whereIn('click_id', $agentIds);
    $managerDatas = ExcelData::where('form_status', 'Pipeline')->where('click_id', $userId);
    
    $datas = $agentDatas->union($managerDatas)->orderByDesc('updated_at')->paginate(100);
    
    $agents = User::where('rel_id', $userId)->get();
    
    return view('backend.leads.manager_leads', compact('datas', 'agents'));
}
    
    public function managerwonLeads()
{
    $userId = auth()->user()->id;
    $agentIds = User::where('rel_id', $userId)->pluck('id')->toArray();

    $agentDatas = ExcelData::where('form_status', 'WON')->whereIn('click_id', $agentIds);
    $managerDatas = ExcelData::where('form_status', 'WON')->where('click_id', $userId);

    $datas = $agentDatas->union($managerDatas)->orderByDesc('updated_at')->paginate(100);

    $agents = User::where('rel_id', $userId)->get();

    return view('backend.leads.manager_leads', compact('datas', 'agents'));
}

   public function managerdndLeads()
{
    $userId = auth()->user()->id;
    $agentIds = User::where('rel_id', $userId)->pluck('id')->toArray();

    $agentDatas = ExcelData::where('form_status', 'DND')->whereIn('click_id', $agentIds);
    $managerDatas = ExcelData::where('form_status', 'DND')->where('click_id', $userId);

    $datas = $agentDatas->union($managerDatas)->orderByDesc('updated_at')->paginate(100);

    $agents = User::where('rel_id', $userId)->get();

    return view('backend.leads.manager_leads', compact('datas', 'agents'));
}

    
    public function managermpipelineLeads()
    {
    $userId = auth()->user()->id;
    $agentIds = User::where('rel_id', $userId)->pluck('id')->toArray();
    
    $mAgentDatas = MasterExcelData::where('form_status', 'Pipeline')->whereIn('click_id', $agentIds)->get();
    $mManagerDatas = MasterExcelData::where('form_status', 'Pipeline')->where('click_id', $userId)->get();
    
    $datas = $mAgentDatas->concat($mManagerDatas);
    
    $datas = $datas->sortByDesc('updated_at');
    $agents = User::where('rel_id', $userId)->get();
    
    return view('backend.leads.manager_mleads', compact('datas', 'agents'));
    }


   public function managervoicemailLeads()
{
    $userId = auth()->user()->id;
    $agentIds = User::where('rel_id', $userId)->pluck('id')->toArray();

    $agentDatas = ExcelData::where('form_status', 'Voice Mail')->whereIn('click_id', $agentIds);
    $managerDatas = ExcelData::where('form_status', 'Voice Mail')->where('click_id', $userId);

    $datas = $agentDatas->union($managerDatas)->orderByDesc('updated_at')->paginate(100);

    $agents = User::where('rel_id', $userId)->get();

    return view('backend.leads.manager_leads', compact('datas', 'agents'));
}


    public function managernotintrestedLeads()
{
    $userId = auth()->user()->id;
    $agentIds = User::where('rel_id', $userId)->pluck('id')->toArray();

    $agentDatas = ExcelData::where('form_status', 'Not Intrested')->whereIn('click_id', $agentIds);
    $managerDatas = ExcelData::where('form_status', 'Not Intrested')->where('click_id', $userId);

    $datas = $agentDatas->union($managerDatas)->orderByDesc('updated_at')->paginate(100);

    $agents = User::where('rel_id', $userId)->get();

    return view('backend.leads.manager_leads', compact('datas', 'agents'));
}


    public function managernotconnectedLeads()
{
    $userId = auth()->user()->id;
    $agentIds = User::where('rel_id', $userId)->pluck('id')->toArray();

    $agentDatas = ExcelData::where('form_status', 'Not Connected')->whereIn('click_id', $agentIds);
    $managerDatas = ExcelData::where('form_status', 'Not Connected')->where('click_id', $userId);

    $datas = $agentDatas->union($managerDatas)->orderByDesc('updated_at')->paginate(100);

    $agents = User::where('rel_id', $userId)->get();

    return view('backend.leads.manager_leads', compact('datas', 'agents'));
}


    public function managerwrongnumberLeads()
{
    $userId = auth()->user()->id;
    $agentIds = User::where('rel_id', $userId)->pluck('id')->toArray();

    $agentDatas = ExcelData::where('form_status', 'Wrong Number')->whereIn('click_id', $agentIds)->orderBy('updated_at', 'DESC');
    $managerDatas = ExcelData::where('form_status', 'Wrong Number')->where('click_id', $userId)->orderBy('updated_at', 'DESC');

    $datas = $agentDatas->union($managerDatas)->paginate(100);

    $agents = User::where('rel_id', $userId)->get();

    return view('backend.leads.manager_leads', compact('datas', 'agents'));
}

    public function managerinsuredLeads()
{
    $userId = auth()->user()->id;
    $agentIds = User::where('rel_id', $userId)->pluck('id')->toArray();

    $agentDatas = ExcelData::where('form_status', 'Insured')->whereIn('click_id', $agentIds)->orderByDesc('updated_at');
    $managerDatas = ExcelData::where('form_status', 'Insured')->where('click_id', $userId)->orderByDesc('updated_at');

    $datas = $agentDatas->union($managerDatas)->paginate(100);

    $agents = User::where('rel_id', $userId)->get();

    return view('backend.leads.manager_insured_leads', compact('datas', 'agents'));
}


    // Agent Leads
    public function intrestedLeads()
    {
        $datas = ExcelData::where('form_status', 'Intrested')->where('click_id', auth()->user()->id)->orderBy('updated_at', 'DESC')->paginate(100);
        return view('backend.leads.agent_leads', compact('datas'));
    }
    public function mintrestedLeads()
    {
        $datas = MasterExcelData::where('form_status', 'Intrested')->where('click_id', auth()->user()->id)->orderBy('updated_at', 'DESC')->paginate(100);
        return view('backend.leads.agent_mleads', compact('datas'));
    }

    public function pipelineLeads()
    {
        $datas = ExcelData::where('form_status', 'Pipeline')->where('click_id', auth()->user()->id)->orderBy('updated_at', 'DESC')->paginate(100);
        return view('backend.leads.agent_leads', compact('datas'));
    }
    
    public function wonLeads()
    {
        $datas = ExcelData::where('form_status', 'WON')->where('click_id', auth()->user()->id)->orderBy('updated_at', 'DESC')->paginate(100);
        return view('backend.leads.agent_leads', compact('datas'));
    }
    public function mpipelineLeads()
    {
        $datas = MasterExcelData::where('form_status', 'Pipeline')->where('click_id', auth()->user()->id)->orderBy('updated_at', 'DESC')->paginate(100);
        return view('backend.leads.agent_mleads', compact('datas'));
    }
    
    public function voicemailLeads()
    {
        $datas = ExcelData::where('form_status', 'Voice Mail')->where('click_id', auth()->user()->id)->orderBy('updated_at', 'DESC')->paginate(100);
        return view('backend.leads.agent_leads', compact('datas'));
    }
    public function notintrestedLeads()
    {
        $datas = ExcelData::where('form_status', 'Not Intrested')->where('click_id', auth()->user()->id)->orderBy('updated_at', 'DESC')->paginate(100);
        return view('backend.leads.agent_leads', compact('datas'));
    }
    public function notconnectedLeads()
    {
        $datas = ExcelData::where('form_status', 'Not Connected')->where('click_id', auth()->user()->id)->orderBy('updated_at', 'DESC')->paginate(100);
        return view('backend.leads.agent_leads', compact('datas'));
    }
    public function wrongnumberLeads()
    {
        $datas = ExcelData::where('form_status', 'Wrong Number')->where('click_id', auth()->user()->id)->orderBy('updated_at', 'DESC')->paginate(100);
        return view('backend.leads.agent_leads', compact('datas'));
    }

    // Insured Form 
    public function storeInsuredForm(Request $request)
    {
        $dataId = $request->insured_id;
        $form_status = $request->form_status;
        $insured_date = $request->insured_date;

        $data = ExcelData::find($dataId);
        if ($data) {
            $data->form_status = $form_status;
            $data->form_status_value = 100;
            $data->insured_date = $insured_date;
            $data->click_id = auth()->user()->id;
            $data->save();
            managerfwd::where('data_id', $dataId)->delete();
            $request->session()->flash('success', 'Insured Lead Submitted Successfully!');
            return redirect()->back();
        }
    }

    // View Team Leads
    public function viewTeamLeads()
    {
        // Get an array of all user IDs
        $userIds = User::pluck('id')->toArray();

        // Retrieve ExcelData records where click_id is in the array of user IDs
        $datas = ExcelData::whereIn('click_id', $userIds)->get();
        // Pass the data to the view

        $agents = User::where('designation', '!=', 'admin')->get();
        return view('backend.leads.admin_team_leads', compact('datas','agents'));
    }
}
