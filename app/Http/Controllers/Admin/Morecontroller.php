<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\adminmodel\ScriptModal;
use App\Models\credentials;
use App\Models\Training;
use App\Models\Bonus;
use App\Models\Submit_form;
use App\Models\Admin_leave;
use App\Models\Extra_leaves;
use App\Events\notification;
use App\Models\User;
use Carbon\Carbon;



class Morecontroller extends Controller
{
   public function email_script(){
    $script = ScriptModal::where('team_id',session('admin_id'))->first();
    return view('admin/More/Email_script',compact('script'));
   // return view('admin/popup/calender');
   }


   public function calling_script(){
    $script = ScriptModal::where('team_id',session('admin_id'))->first();
    return view('admin/More/calling_script',compact('script'));
   }


   public function text_script(){
    $script = ScriptModal::where('team_id',session('admin_id'))->first();
    return view('admin/More/Text_script',compact('script'));
   }


   public function my_note(){
    $script = ScriptModal::where('team_id',session('admin_id'))->first();
    return view('admin/More/my_note',compact('script'));
   }


   public function credentials(){
    $credentials = credentials::where('team_id',session('admin_id'))->paginate(10);
    return view('admin/More/credentials',compact('credentials'));
   }


   public function store_script(Request $req){
     $id = $req->id;

    $script = ScriptModal::where('team_id',$id)->first();
    if(empty($script)){
        $script_data = new ScriptModal();
        $script_data->team_id = $id;
        $script_data->email_script = $req->email;
        $script_data->calling_script = $req->calling;
        $script_data->text_script = $req->text;
        $script_data->my_note = $req->my_note;
        $script_data->ip = $req->ip();
        $script_data->save();
    }
    else{
        if(empty($req->email)){
            $email = $script->email_script;
        }
        else{
            $email = $req->email;
        }if(empty($req->calling)){
            $calling = $script->calling_script;
        }else{
            $calling = $req->calling;
        }if(empty($req->text)){
            $text = $script->text_script;
        }else{
            $text = $req->text;
        }
        if(empty($req->my_note)){
            $my_note = $script->my_note;
        }else{
            $my_note = $req->my_note;
        }

        $script->email_script = $email;
        $script->calling_script = $calling;
        $script->text_script = $text;
        $script->my_note = $my_note;
        $script->save();
    }
    // Set the flash message
    session()->flash('success', 'Your success message here.');
    return redirect()->back();

   }


   public function store_credentials(Request $req){
    $id = $req->id;

    $credentials = new credentials();
    $credentials->team_id = $id;
    $credentials->platform = $req->platform;
    $credentials->username = $req->username;
    $credentials->password = $req->password;
    $credentials->link = $req->link;
    $credentials->save();

   return redirect()->back();

  }
  public function delete_credentials($idd){
    $id = base64_decode($idd);
    $delete_credentials = credentials::where('id',$id)->delete();
    return redirect()->back();
  }
  public function Training_metarial(){
    $datas = Training::latest()->get();
    return view('admin/popup/view',compact('datas'));
  }
  public function store_Training_metarial(Request $req){
    $req->validate([
        'img' => 'file|mimes:jpeg,png,pdf|max:2048', // Example validation rules
    ]);
    $message = $req->message;
    $heading = $req->heading;
    $fullimagepath = '';
			if (!empty($req->img)) {
				$allowedFormats = ['jpeg', 'jpg', 'pdf'];
				$extension = strtolower($req->img->getClientOriginalExtension());
				if (in_array($extension, $allowedFormats)) {
					$file = time() . 'training.' . $req->img->extension();
					$req->img->move(public_path('uploads/image/Teams/'), $file);
					$fullimagepath = 'uploads/image/Teams/' . $file;
				} else {
					// Handle invalid file format (not allowed)
					return redirect()->back()->with('error', 'Invalid file format. Only jpeg, jpg, and webp files are allowed.');
				}
			}

            $data = new Training();
            $data->user_id = session('admin_id');
            $data->heading = $heading;
            $data->message = $message;
            $data->image =$fullimagepath;
            $data->save();
            return redirect()->back();
     }
     public function delete_Training_metarial($id)
{
    try {
        $decodedId = base64_decode($id);
        $trainingMaterial = Training::findOrFail($decodedId);
        $trainingMaterial->delete();
        
        return redirect()->back()->with('success', 'Training material deleted successfully.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Error deleting training material.');
    }
}
public function view_form_submit(){
    $datas = Submit_form::latest()->paginate(10);
    return view('admin/More/view_form_submit',compact('datas'));
}
 public function store_bonus(Request $req){

    $bonus = $req->bonus;
    $leaves = $req->leaves;
    $agentId = $req->agent_id;
    $month = Carbon::now()->startOfMonth(); // Get the start of the current month

   if(!empty($bonus))
    {
        $bonus_check = Bonus::where('agent_id', $agentId)
                        ->whereYear('updated_at', $month->year)
                        ->whereMonth('updated_at', $month->month)
                        ->first();

    if ($bonus_check) {
        // If entry exists for the current month, update the bonus amount
        $bonus_check->bonus = $bonus; 
        $bonus_check->save();
    } else {
        // If no entry exists for the current month, create a new entry
        Bonus::create([
            'agent_id' => $agentId,
            'bonus' => $bonus, // Replace $newBonusValue with the initial bonus amount
        ]);
    }
    
 }
 if(!empty($leaves)){
     $leave_check = Admin_leave::where('agent_id', $agentId)
     ->whereYear('updated_at', $month->year)
     ->whereMonth('updated_at', $month->month)
     ->first();
     $remaining_leaves = Extra_leaves::where('agent_id',$agentId)->first();
     if( $remaining_leaves->leaves < $leaves){
        session()->flash('error','only '.$remaining_leaves->leaves.' leaves Remaining.');
        return redirect()->back();
    }else{
     if ($leave_check) {
        $leave_check->leaves = $leave_check->leaves+$leaves; 
        $leave_check->save();
    } else {
        // If no entry exists for the current month, create a new entry
        Admin_leave::create([
            'agent_id' => $agentId,
            'leaves' => $leaves, // Replace $newBonusValue with the initial bonus amount
        ]);
    }
    
    $remaining_leaves->leaves = $remaining_leaves->leaves - $leaves;
    $remaining_leaves->save();
}
    
 }
 session()->flash('success','data updated successfully');
 return redirect()->back();
}
public function view_submint_report(){

    $datas = User::where('status',1)->where('is_active',1)->paginate(10);
    return view('admin/More/view_submit_report',compact('datas'));
}

}
