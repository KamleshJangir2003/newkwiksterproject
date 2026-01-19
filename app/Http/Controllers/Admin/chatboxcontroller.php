<?php

namespace App\Http\Controllers\Admin;

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

class chatboxcontroller extends Controller
{

    public function agent_chat(){
        $users = User::whereIn('status', [1, 3])->where('is_active', 1)->get();
       
       $ID = User::where('team_id', session('admin_id'))->first();

// Fallback: agar session ya agent user na mile to bhi page load hone do
$agent_id = $ID->id ?? 0;

$groups = Groups_chat::all();

// Filter the groups safely
$filtered_groups = $groups->filter(function($group) use ($agent_id) {
    $user_ids_array = json_decode($group->user_ids, true) ?? [];
    return $group->created_by == $agent_id || in_array($agent_id, $user_ids_array);
});

return view('admin.chat.view_chat', compact('users', 'filtered_groups', 'ID'));


    }
    public function sendMessage(Request $request)
{
    $request->validate([
        'file' => 'nullable|file|max:5120',
        'to_id' => 'nullable|integer', // This can be null if sending to a group
        'group_id' => 'nullable|integer', // Add group_id validation
        'body' => 'string'
    ]);

    $ID = User::where('team_id',session('admin_id'))->first();

    $seen = [$ID->id];
    $message = new ChMessage();
    $message->from_id = $ID->id;
    $message->to_id = $request->to_id;
    $message->group_id = $request->group_id; // Store the group ID if provided
    $message->body = $request->body ? nl2br(e($request->body)) : nl2br(e($request->groupbody));
    $message->reply_id = $request->replyId;
    $message->seen = json_encode($seen);

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
    If(!empty($rmessage))
   { if(!empty($rmessage->body))
    {$reply_message = $rmessage->body;}
    else{
        $reply_message = '<img src="' . asset($rmessage->attachment) . '"
                      alt="Attachment" width="100px"
                      height="100px" style="margin-bottom: 10px">';
    }}
    $data = [
        'body' => $message->body,
        'to_id' => $request->to_id,
        'group_id' => $request->group_id, // Include group_id in the event data
        'reply_id' => $request->replyId, 
        'reply_message' => $reply_message, 
        'from_id' => $ID->id,
        'from_name' => $ID->name,
        'attachment' => $fullimagepath,
        'created_at' => $message->created_at,
    ];
     $notification = [
        'massage'=>'New Chat From '. session('admin_name'),
        'user_id'=>$request->to_id,
    ];

  event(new UserNotification($notification));
    event(new Chatnotification($data));
    return response()->json(['success' => true, 'message' => 'Message sent successfully','reply' => $reply_message]);
}

    public function createChat(Request $request){
        $ID = User::where('team_id',session('admin_id'))->first();
        // If frontend sends a user_id, create an initial placeholder message to initialize a chat
        if($request->has('user_id')){
            $message = new ChMessage();
            $message->from_id = $ID->id ?? null;
            $message->to_id = $request->user_id;
            $message->body = 'Chat started';
            $message->seen = json_encode([$message->from_id]);
            $message->save();
            return response()->json(['success'=>true,'chat_id'=>$message->id]);
        }
        // Generic success response for other uses
        return response()->json(['success'=>true]);
    }

    public function create_group(Request $req){
        $req->validate([
            'group_name' => 'required|string|max:30',
            'agent_ids' => 'required|array',
        ]);
        $ID = User::where('team_id',session('admin_id'))->first();
        $group = new Groups_chat();
        $group->name = $req->group_name;
        $group->created_by = $ID->id;
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
        $ID = User::where('team_id',session('admin_id'))->first();
        $group = Groups_chat::where('id',$req->group_id)->first();
        $check = $group->created_by;
        if($check == $ID->id){
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
        $ID = User::where('team_id',session('admin_id'))->first();
        $group = Groups_chat::where('id',$id)->first();
        $check = $group->created_by;
        if($check == $ID->id){
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
        $ID = User::where('team_id',session('admin_id'))->first();
        $forword = ChMessage::where('id',$id)->first();
       if(!empty($request->agent_ids))
        {foreach($request->agent_ids as $agent){
            $message = new ChMessage();
            $message->from_id = $ID->id;
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
            $message->from_id = $ID->id;
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
    public function read_mark(Request $request){
        $id = $request->group_id;
        $user_id = $request->user_id;
        $ID = User::where('team_id',session('admin_id'))->first();
        $agentId = $ID->id;
    
       
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



    public function loadChat($id) {
    $user = User::find($id);
    if(!$user) return "<p>User not found ❌</p>";

    return "
    <div class='chat-header border-bottom p-2'>
        <strong>{$user->name}</strong>
    </div>
    <div class='chat-messages p-2'>
        <p>Chat started with {$user->name} ✅</p>
    </div>
    ";
}

}