<?php

namespace App\Http\Controllers\Backend\Other;

use App\Http\Controllers\Controller;
use App\Models\comment;
use Illuminate\Http\Request;
use App\Events\RealTimeMessage;
use App\Models\clientForm;

class CommentController extends Controller
{
    public function clientDataComment(Request $request)
    {
        $dataId = $request->data_id;
        if (auth()->user()->designation == 'Manager') {
            $message = 'Manager :- ' . $request->message;
        } elseif (auth()->user()->designation == 'Agent') {
            $message = 'Agent :- ' . $request->message;
        } else {
            $message = 'Client :- ' . $request->message;
        }

        $comment = new Comment(); // Create a new instance of the Comment model
        $comment->data_id = $dataId;
        $comment->comment = $message;
        $comment->save(); // Use create() instead of comment()

        // You may return a response if needed
         $data = clientForm::find($dataId);
        $empId = $data->user_id;
        $data = ['id' => $empId, 'message' => "Message From Client Panel, Phone :- $data->phone, $message"];
        event(new RealTimeMessage($data, 'my-channel2', 'my-event2'));
        return response()->json(['message' => 'Comment saved successfully']);
    }

    public function getInitialMessages($id)
    {
        $comments = Comment::where('data_id', $id)->pluck('comment');

        // Return the comments in the response
        return response()->json(['messages' => $comments]);
    }
}
