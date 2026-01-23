<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\managerfwd;
use App\Models\ExcelData;
use App\Models\unitOwned;
use App\Models\User;
use App\Models\Groups_chat;
use Carbon\Carbon;
use App\Models\ChMessage;
use App\Events\Chatnotification;
use App\Events\UserNotification;
use DB;

class chatcontroller extends Controller
{

    public function agent_chat(){
        // Get all users for agent chat
        $users = User::all();
        $filtered_groups = Groups_chat::all();
        $agent_id = 2; // Dummy agent ID for Kamlesh

        return view('Agent.chat-box.view_chat',compact('users', 'filtered_groups'))->with('agent_id', $agent_id);
    }
    public function sendMessage(Request $request)
{
    $request->validate([
        'file' => 'nullable|file|max:5120',
        'to_id' => 'nullable|integer',
        'group_id' => 'nullable|integer',
        'body' => 'nullable|string'
    ]);
    
    $agent_id = 2; // Use dummy agent ID for testing
    
    $seen = [$agent_id];
    $message = new ChMessage();
    $message->from_id = $agent_id;
    $message->to_id = $request->to_id;
    $message->group_id = $request->group_id;
    $message->body = $request->body ? $request->body : ($request->groupbody ?? '');
    $message->reply_id = $request->replyId;
    $message->seen = $request->to_id ? 0 : json_encode($seen);

    $fullimagepath = '';
    if (!empty($request->file)) {
        $extension = strtolower($request->file->getClientOriginalExtension());
        $file = time() . 'chatfile.' . $request->file->extension();
        $request->file->move(public_path('uploads/image/chat_file/'), $file);
        $fullimagepath = 'uploads/image/chat_file/' . $file;
    }
    $message->attachment = $fullimagepath;
    $message->save();
    
    $rmessage = ChMessage::where('id',$request->replyId)->first();
    $reply_message = '';
    if(!empty($rmessage)) {
        if(!empty($rmessage->body)) {
            $reply_message = $rmessage->body;
        } else {
            $reply_message = '<img src="' . asset($rmessage->attachment) . '" alt="Attachment" width="100px" height="100px" style="margin-bottom: 10px">';
        }
    }
    
    $data = [
        'body' => $message->body,
        'to_id' => $request->to_id,
        'group_id' => $request->group_id,
        'reply_id' => $request->replyId, 
        'reply_message' => $reply_message, 
        'from_id' => $agent_id,
        'from_name' => session('agent_alise_name') ?? 'Agent',
        'attachment' => $fullimagepath,
        'created_at' => $message->created_at,
    ];
    
    $notification = [
        'massage'=>'New Chat From '. (session('agent_alise_name') ?? 'Agent'),
        'user_id'=>$request->to_id,
    ];

    event(new UserNotification($notification));
    event(new Chatnotification($data));
    return response()->json(['success' => true, 'message' => 'Message sent successfully','reply' => $reply_message]);
}

    public function create_group(Request $req){
        $req->validate([
            'group_name' => 'required|string|max:30',
            'agent_ids' => 'required|array',
        ]);

        $group = new Groups_chat();
        $group->name = $req->group_name;
        $group->created_by = session('agent_id');
        $group->user_ids = json_encode($req->agent_ids);
        $fullimagepath = '';
        if (!empty($req->group_profile)) {
            $extension = strtolower($req->group_profile->getClientOriginalExtension());
            $file = time() . 'group_dp.' . $req->group_profile->extension();
            $req->group_profile->move(public_path('uploads/image/chat_file/'), $file);
            $fullimagepath = 'uploads/image/chat_file/' . $file;
        }
        $group->image = $fullimagepath;
        $group->save();
        session()->flash('success','Group Created Successfully');
        return redirect()->back();

    }
    public function edit_group(Request $req){
        
        $group = Groups_chat::where('id',$req->group_id)->first();
        $check = $group->created_by;
        if($check == session('agent_id')){
            $group->name = $req->group_name;
            $group->user_ids = json_encode($req->agent_ids);
            $fullimagepath = $group->image;
            if (!empty($req->group_profile)) {
                $extension = strtolower($req->group_profile->getClientOriginalExtension());
                $file = time() . 'group_dp.' . $req->group_profile->extension();
                $req->group_profile->move(public_path('uploads/image/chat_file/'), $file);
                $fullimagepath = 'uploads/image/chat_file/' . $file;
            }
            $group->image = $fullimagepath;
            $group->save();
            session()->flash('success','Group Updated Successfully');
            return redirect()->back();
        } else{
            session()->flash('success','Only admin can change group details');
            return redirect()->back();
        }
       
    }
    public function delete_group($id){
        $group = Groups_chat::where('id',$id)->first();
        $check = $group->created_by;
        if($check == session('agent_id')){
            $group->delete();
             session()->flash('success','Group Deleted Successfully');
              return redirect()->back();
        } else{
            session()->flash('success','Only admin can Delete group.');
            return redirect()->back();
        }
        
    }
    public function delete_message($id){
        $message = ChMessage::where('id',$id)->first();
        $message->deleted = 1;
        $message->save();
        return redirect()->back();

    }
    public function forward_message(Request $request,$id)
    {
        $forword = ChMessage::where('id',$id)->first();
       if(!empty($request->agent_ids))
        {foreach($request->agent_ids as $agent){
            $message = new ChMessage();
            $message->from_id = session('agent_id');
            $message->to_id = $agent;
            $message->body = $forword->body ;
            $message->forward = 1;
        
            if(!empty($forword->attachment))
           {
            $message->attachment = $forword->attachment;
             }
            $message->save();
        }}
        if(!empty($request->group_ids))
        {foreach($request->group_ids as $group){
            $message = new ChMessage();
            $message->from_id = session('agent_id');
            $message->group_id = $group;
            $message->body = $forword->body ;
            $message->forward = 1;
        
            if(!empty($forword->attachment))
            {
             $message->attachment = $forword->attachment;
              }
        
            $message->save();
        }}
       
        return redirect()->back()->with('success','Message Forwarded Successfully');
    }

    public function chat_read_status(Request $request){
        $id = $request->group_id;
        $user_id = $request->user_id;
        $agentId = SESSION('agent_id');
    
       
       if(!empty($id)){
        $messages = ChMessage::where('group_id', $id)->get();
        foreach ($messages as $message) {
            if ($message->seen == 0) {
                $agents = [$agentId]; 
                $message->seen = json_encode($agents); 
                $message->save();
            } else {
                $seens = json_decode($message->seen, true);
             
              if (!in_array($agentId, $seens)) {
                  // Add the agent ID to the array
                  $seens[] = $agentId;
            
                  $message->seen = json_encode($seens);
                  $message->save(); 
              }
            }
        }}
        else{
            $messages = ChMessage::where('from_id', $user_id)->where('to_id', $agentId)->get();
            foreach ($messages as $message) {
               $message->seen = 1;
               $message->save();
            }
        }
        return response()->json(['success' => true]);
    }
}