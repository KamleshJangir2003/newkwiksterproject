<?php

namespace App\Http\Controllers\Backend\Other;

use App\Http\Controllers\Controller;
use App\Models\calling;
use App\Models\dayendreport;
use App\Models\email;
use App\Models\Events;
use App\Models\ExcelData;
use App\Models\note;
use App\Models\offer;
use App\Models\text;
use App\Models\User;
use App\Models\managerfwd;
use App\Models\clientForm;
use App\Models\credentials;
use App\Models\pin;
use App\Exports\DataExportClass;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class UtilityController extends Controller
{
    // My Notes
    public function mynotes()
    {
        $note = note::where('user_id', auth()->user()->id)->first();
        return view('backend.utility.mynotes', compact('note'));
    }

    public function storeMynotes(Request $request)
    {
        $notes = $request->input('notes');
        $user_id = auth()->user()->id;
        $note = Note::where('user_id', $user_id)->first();
        if ($note) {
            $note->update(['notes' => $notes]);
        } else {
            Note::create([
                'user_id' => $user_id,
                'notes' => $notes,
            ]);
        }
        $request->session()->flash('success', 'Notes saved successfully!');
        return redirect()->back();
    }

    // Email Script
    public function emails()
    {
        $email = email::where('user_id', auth()->user()->id)->first();
        return view('backend.utility.emails', compact('email'));
    }

    public function storeEmails(Request $request)
    {
        $emails = $request->input('emails');
        $user_id = auth()->user()->id;
        $email = email::where('user_id', $user_id)->first();
        if ($email) {
            $email->update(['emails' => $emails]);
        } else {
            email::create([
                'user_id' => $user_id,
                'emails' => $emails,
            ]);
        }
        $request->session()->flash('success', 'Email script saved successfully!');
        return redirect()->back();
    }
    // Calling Script
    public function calling()
    {
        $calling = calling::where('user_id', auth()->user()->id)->first();
        return view('backend.utility.calling', compact('calling'));
    }

    public function storeCalling(Request $request)
    {
        $callings = $request->input('calling');
        $user_id = auth()->user()->id;
        $calling = calling::where('user_id', $user_id)->first();
        if ($calling) {
            $calling->update(['calling' => $callings]);
        } else {
            calling::create([
                'user_id' => $user_id,
                'calling' => $callings,
            ]);
        }
        $request->session()->flash('success', 'Calling script saved successfully!');
        return redirect()->back();
    }

    // Text Script
    public function text()
    {
        $text = text::where('user_id', auth()->user()->id)->first();
        return view('backend.utility.text', compact('text'));
    }

    public function storeText(Request $request)
    {
        $texts = $request->input('text');
        $user_id = auth()->user()->id;
        $text = text::where('user_id', $user_id)->first();
        if ($text) {
            $text->update(['text' => $texts]);
        } else {
            text::create([
                'user_id' => $user_id,
                'text' => $texts,
            ]);
        }
        $request->session()->flash('success', 'Text script saved successfully!');
        return redirect()->back();
    }

    // Submit Day End Report
    public function submitReport(Request $request)
    {
        $user_id = auth()->user()->id;

        // Set the desired timezone for Florida
        $floridaTimezone = 'America/New_York';

        // Convert the current date to the Florida time zone
        $floridaToday = Carbon::today($floridaTimezone)->toDateString();

        // Check if a report already exists for the current date
        $existingReport = DayEndReport::where('user_id', $user_id)
            ->whereDate('created_at', $floridaToday)
            ->first();

        if ($existingReport) {
            $request->session()->flash('warning', 'Day end report already submitted for today!');
            return redirect()->back();
        }

        $intrested = ExcelData::where('form_status', 'Intrested')
            ->where('click_id', $user_id)
            ->whereDate('created_at', $floridaToday)
            ->get();

        $pipeline = ExcelData::where('form_status', 'Pipeline')
            ->where('click_id', $user_id)
            ->whereDate('created_at', $floridaToday)
            ->get();

        $total_call = ExcelData::whereIn('form_status', ['Intrested', 'Pipeline', 'Not Connected', 'Not Intrested', 'Voice Mail', 'Wrong Number', 'Insured'])
            ->where('click_id', $user_id)
            ->whereDate('created_at', $floridaToday)
            ->get();

        $call_connect = ExcelData::whereIn('form_status', ['Intrested', 'Pipeline', 'Not Intrested', 'Wrong Number', 'Insured'])
            ->where('click_id', $user_id)
            ->whereDate('created_at', $floridaToday)
            ->get();

        $dayendreport = new DayEndReport();
        $dayendreport->user_id = $user_id;
        $dayendreport->intrested = count($intrested);
        $dayendreport->pipeline = count($pipeline);
        $dayendreport->total_call = count($total_call);
        $dayendreport->call_connect = count($call_connect);
        $dayendreport->save();

        $request->session()->flash('success', 'Day end report submitted successfully!');
        return redirect()->back();
    }

    // View Day End Report
    public function viewReport()
    {
        $user_id = auth()->user()->id;
        $users = User::where('rel_id', $user_id)->get();
        $datas = [];

        foreach ($users as $user) {
            $userReports = dayendreport::where('user_id', $user->id)->get();
            $datas[] = $userReports;
        }
        return view('backend.report.view_report', compact('datas'));
    }

    // Admin View Day End Report
    public function adminViewReport()
    {
        $user_id = auth()->user()->id;
        $Musers = User::where('rel_id', $user_id)->get();
        $datas = [];

        foreach ($Musers as $Muser) {
            $Ausers = User::where('rel_id', $Muser->id)->get();
        }

        foreach ($Musers as $Muser) {
            $userReports = dayendreport::where('user_id', $Muser->id)->get();
            $datas[] = $userReports;
        }
        foreach ($Ausers as $Auser) {
            $userReports = dayendreport::where('user_id', $Auser->id)->get();
            $datas[] = $userReports;
        }

        return view('backend.report.view_report', compact('datas'));
    }

    public function deleteReport(Request $request, $id)
    {
        $report = dayendreport::find($id);
        if ($report) {
            $report->delete();
            $request->session()->flash('success', 'Report deleted successfully!');

            return redirect()->back();
        }
    }
    // Offers
    public function viewOffers()
    {
        $offers = offer::all();
        return view('backend.utility.offers', compact('offers'));
    }

    // Store Offer 
    public function storeOffers(Request $request)
    {
        $offer = new offer();
        $offer->offers = $request->offers;
        $offer->save();
        $request->session()->flash('success', 'Offer Created successfully!');
        return redirect()->back();
    }

    // Delete Offer
    public function deleteOffers(Request $request, $id)
    {
        $offer = offer::find($id);
        if ($offer) {
            $offer->delete();
            $request->session()->flash('success', 'Offer Deleted successfully!');
            return redirect()->back();
        }
    }

    // Holidays Calendar
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Events::whereDate('start', '>=', $request->start)
                ->whereDate('end',   '<=', $request->end)
                ->get(['id', 'title', 'start', 'end']);
            return response()->json($data);
        }
        return view('backend.utility.holidays_calendar');
    }

    public function action(Request $request)
    {
        if ($request->ajax()) {
            if ($request->type == 'add') {
                $event = Events::create([
                    'title'        =>    $request->title,
                    'start'        =>    $request->start,
                    'end'        =>    $request->end
                ]);

                return response()->json($event);
            }

            if ($request->type == 'update') {
                $event = Events::find($request->id)->update([
                    'title'        =>    $request->title,
                    'start'        =>    $request->start,
                    'end'        =>    $request->end
                ]);

                return response()->json($event);
            }

            if ($request->type == 'delete') {
                $event = Events::find($request->id)->delete();

                return response()->json($event);
            }
        }
    }
    // Holidays Calendar


    // Delete Duplicate Entry
    public function deleteDuplicateEntry(Request $request)
    {
        $userId = auth()->user()->id;

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

            // Delete related data from managerfwd in a single query
            managerfwd::whereIn('data_id', $entriesToDelete->pluck('id'))->delete();
        }

        $message = $deletedCount > 0 ? "Deleted $deletedCount duplicate entries and related managerfwd data successfully!" : "No duplicate entries found.";

        $request->session()->flash('success', $message);
        return redirect()->back();
    }
    // Delete Duplicate Entry Batch
    public function deleteDuplicateEntryBatch(Request $request ,$batchname)
    {
        $batchname = decrypt($batchname);

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

            // Delete related data from managerfwd in a single query
            managerfwd::whereIn('data_id', $entriesToDelete->pluck('id'))->delete();
        }

        $message = $deletedCount > 0 ? "Deleted $deletedCount duplicate entries from $batchname data successfully!" : "No duplicate entries found.";

        $request->session()->flash('success', $message);
        return redirect()->back();
    }


    // Delete Duplicate Entry

    public function deleteAllImportLeads(Request $request)
    {
        try {
            // Get all ExcelData records
            $excelDataRecords = ExcelData::where('status', 'not_forwarded')->get();

            // Loop through each ExcelData record and delete it
            foreach ($excelDataRecords as $excelData) {
                $excelData->delete();
            }

            $request->session()->flash('success', 'All imported data deleted successfully.');
        } catch (\Exception $e) {
            // Handle exceptions if any
            $request->session()->flash('error', 'Error deleting imported data: ' . $e->getMessage());
        }

        return redirect()->back();
    }


    public function openTimer()
    {
        return view('backend.utility.timer-widget');
    }
    
    // Delete Dnd Entry
   public function deleteDndEntry(Request $request) {
    ini_set('memory_limit', '-1');
    $datas = ExcelData::where('status', 'not_forwarded')->where('rel_id', auth()->user()->id)->get();

    $deletedCount = 0; 

    foreach ($datas as $data) {
       
        $isDND = ExcelData::where('status', 'forwarded')
                          ->where('form_status', 'DND')
                          ->where('phone', $data->phone)
                          ->exists();

        if ($isDND) {
            $data->delete();
            $deletedCount++; 
        }
    }

    $request->session()->flash('success', $deletedCount . ' DND Data Deleted Successfully');
    return redirect()->back();
   }
   
   public function credentials(){
       $pin = Pin::where('user_id', auth()->user()->id)->first();
       $cs=credentials::where('user_id',auth()->user()->id)->get();
       return view('backend.utility.credentials',compact('cs','pin'));
   }
   public function storeCredentials(Request $request){
       $c=new credentials();
       $c->user_id=auth()->user()->id;
       $c->platform=$request->platform;
       $c->username=$request->username;
       $c->password=$request->password;
       $c->link=$request->link;
       $c->save();
       $request->session()->flash('success', 'Credentials Added Successfully');
       return redirect()->back();
   }
   public function deleteCredentials(Request $request,$id){
       $c=credentials::find($id);
       $c->delete();
       $request->session()->flash('success', 'Credentials Deleted Successfully');
       return redirect()->back();
   }
 public function clientFormApprove(Request $request, $statusParam, $id)
{
    $clientForm = clientForm::find($id);

    if ($clientForm) {
        $clientForm->approved_declined = $statusParam;
        $clientForm->save();

        $request->session()->flash('success', "$statusParam Successfully");
    } else {
        $request->session()->flash('error', 'Client Form not found');
    }

    return redirect()->back();
}

public function generatePin(Request $request){
    $existingPin = Pin::where('user_id', $request->user_id)->first();

    if($existingPin) {
        $request->session()->flash('error', "PIN already exists!");
        return redirect()->back();
    }

    $pin = new Pin();
    $pin->user_id = $request->user_id;
    $pin->pin = $request->new_pin;
    $pin->save();

    $request->session()->flash('success', "PIN Generated Successfully!");
    return redirect()->back();
}

public function changePin(Request $request){
    $pin = pin::where('user_id',$request->user_id)->first();
   ;
    if($pin->pin==$request->old_pin){
    $pin->pin=$request->new_pin;
    $pin->save();
     $request->session()->flash('success', "PIN Changed Successfully!");
    }else{
        $request->session()->flash('error', "Old PIN Not Matched!");
    }
     return redirect()->back();
}
public function viewCredentialsPin()
{
    // Assuming your model is named Pin
    $pin = Pin::all();
  
    return view('backend.utility.view_pin', compact('pin'));
}
public function dataExport($batchname){
    $dbatch = decrypt($batchname);
    $data = ExcelData::where('batch_name',$dbatch)->get(); 
    return Excel::download(new DataExportClass($data), "$dbatch.xlsx");
}

}
