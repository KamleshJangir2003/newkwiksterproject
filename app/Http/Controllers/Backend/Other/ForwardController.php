<?php

namespace App\Http\Controllers\Backend\Other;

use App\Events\RealTimeMessage;
use App\Http\Controllers\Controller;
use App\Models\adminfwd;
use App\Models\ExcelData;
use App\Models\managerfwd;
use App\Models\User;
use Illuminate\Http\Request;

class ForwardController extends Controller
{
    // Admin Forward Data
    public function adminFwd(Request $request)
    {
        $dataIds = $request->input('data_id');
        $mngIds = $request->input('mng_id');

        $validated = $request->validate([
            'mng_id.*' => 'required',
            'data_id' => 'required|array',
        ]);

        // Find the maximum batch_id within ForwardData
        $maxBatchId = adminfwd::max('batch') ?? 0;

        // Increment the batch_id for the current batch
        $batchId = $maxBatchId + 1;

        foreach ($validated['data_id'] as $dataId) {
            foreach ($validated['mng_id'] as $empId) {
                adminfwd::create([
                    'data_id' => $dataId,
                    'mng_id' => $empId,
                    'batch' => $batchId, // Assign the unique batch_id
                ]);
            }
        }

        // Update status for the selected ExcelData records
        ExcelData::whereIn('id', $dataIds)->update(['status' => 'forwarded']);
        $request->session()->flash('success', 'Data forwarded to the selected manager!');
        return redirect()->back();
    }

    // Manager Forward Data
    public function managerFwd(Request $request)
    {
        $dataIds = $request->input('data_id');
        $agentIds = $request->input('agent_id');

        $validated = $request->validate([
            'agent_id.*' => 'required',
            'data_id' => 'required|array',
        ]);

        // Find the maximum batch_id within ForwardData
        $maxBatchId = adminfwd::max('batch') ?? 0;

        // Increment the batch_id for the current batch
        $batchId = $maxBatchId + 1;

        foreach ($validated['data_id'] as $dataId) {
            foreach ($validated['mng_id'] as $empId) {
                adminfwd::create([
                    'data_id' => $dataId,
                    'agent_id' => $empId,
                    'batch' => $batchId, // Assign the unique batch_id
                ]);
            }
        }

        // Update status for the selected ExcelData records
        ExcelData::whereIn('id', $dataIds)->update(['status' => 'forwarded']);
        $request->session()->flash('success', 'Data forwarded to the selected agent!');
        return redirect()->back();
    }

    public function managerFwdAgent(Request $request)
    {
        $dataIds = $request->input('data_id');
        $agentIds = $request->input('agent_id');

        $validated = $request->validate([
            'agent_id.*' => 'required',
            'data_id' => 'required|array',
        ]);

        // Find the maximum batch_id within ForwardData
        $maxBatchId = managerfwd::max('batch') ?? 0;

        // Increment the batch_id for the current batch
        $batchId = $maxBatchId + 1;

        foreach ($validated['data_id'] as $dataId) {
            foreach ($validated['agent_id'] as $empId) {
                managerfwd::create([
                    'data_id' => $dataId,
                    'agent_id' => $empId,
                    'batch' => $batchId, // Assign the unique batch_id
                ]);
            }
        }
        // Trigger the event outside of the loop
        $data = ['id' => $empId, 'message' => 'New data arrived in Incoming Leads - Please reload the page.'];
        event(new RealTimeMessage($data, 'my-channel', 'my-event'));

        // Delete the records where data_id is in $dataIds array
        adminfwd::whereIn('data_id', $dataIds)->delete();
        ExcelData::whereIn('id', $dataIds)->update(['status' => 'forwarded']);
        $request->session()->flash('success', 'Data forwarded to the selected agent!');

        return redirect()->back();
    }

    public function managerFwdAgentAgain(Request $request)
    {
        $dataIds = $request->input('data_id');
        $agentIds = $request->input('agent_id');

        $validated = $request->validate([
            'agent_id.*' => 'required',
            'data_id' => 'required|array',
        ]);

        // Find the maximum batch_id within ForwardData
        $maxBatchId = managerfwd::max('batch') ?? 0;

        // Increment the batch_id for the current batch
        $batchId = $maxBatchId + 1;

        foreach ($validated['data_id'] as $dataId) {
            foreach ($validated['agent_id'] as $empId) {
                managerfwd::create([
                    'data_id' => $dataId,
                    'agent_id' => $empId,
                    'batch' => $batchId, // Assign the unique batch_id
                ]);
            }
        }

        // Delete the records where data_id is in $dataIds array
        adminfwd::whereIn('data_id', $dataIds)->delete();
        ExcelData::whereIn('id', $dataIds)->update(['status' => 'forwarded', 'form_status' => 'NEW', 'insured_date' => 'NULL', 'form_status_value' => '100', 'comment' => 'NULL', 'click_id' => 'NULL']);
        $request->session()->flash('success', 'Data forwarded to the selected agent!');
        return redirect()->back();
    }
}
