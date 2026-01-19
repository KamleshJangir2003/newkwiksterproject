<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\formpage2;
use App\Models\formpage3;
use App\Models\formpage4;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;


class loadformscontroller extends Controller
{
public function view_load_forms(){
    $dot = $_GET['dot'] ?? '';
    $users = User::where('status',1)->wherenull('deleted_at')->where('is_active',1)->get();
    if(!empty($dot)){
        $datas = formpage2::where('type',1)->where('dot',$dot)->latest()->paginate(10);
    }
    else{
        $datas = formpage2::where('type',1)->latest()->paginate(10);
    }
    return view('admin.loadform.view_load_forms',compact('datas','users'));
}
public function view_load_docs(){
    $dot = $_GET['dot'] ?? '';
    if(!empty($dot)){
        $datas = formpage4::where('dot',$dot)->latest()->paginate(10);
    }
    else{
        $datas = formpage4::latest()->paginate(10);
    }
   
    return view('admin.loadform.view_last_data',compact('datas'));
}
public function view_load_pdfs($id){
    $data = formpage3::where('page_2_id',$id)->first();
    return view('admin.loadform.view_load_pdfs',compact('data'));
}

public function delete_load_forms($idd){

    $id = base64_decode($idd);
    $datas = formpage2::find($id);
    $datas->delete();

    $data = formpage3::where('page_2_id',$id)->first();
    if(!empty($data)){
    $data->delete();
}

    return redirect()->back();

}
public function delete_load_docs($idd){
    $id = base64_decode($idd);
    $datas = formpage4::find($id);
    $datas->delete();
    return redirect()->back();

}
public function comment_load_forms(Request $request){

    $id = $request->input('id');
    $comment = $request->input('comment');

    $data = formpage2::find($id);
    if ($data) {
        $data->comment = $comment;
        $data->save();
        return response()->json(['message' => 'Comment updated successfully!'], 200);
    } else {
        return response()->json(['message' => 'Data not found!'], 404);
    }

}
public function agentid_load_forms(Request $request,$idd,$formidd){

    $id = base64_decode($idd);
    $formid = base64_decode($formidd);

    $data = formpage2::find($formid);
    if ($data) {
        $data->agent_id = $id;
        $data->save();
        return redirect()->back();
    } else {
        return redirect()->back();
    }

}
public function Update_loadform_Status($status, $idd, Request $req)
	{
			$id = base64_decode($idd);
			
				if ($status == "active") {
					
					$TeamData = formpage2::where('id', $id)->first();
					$TeamData->status  = 0;
					$TeamData->save();
				} else {
					$TeamData = formpage2::where('id', $id)->first();
					$TeamData->status  = 1;
					$TeamData->save();
				}
				return Redirect()->back()->with('success', 'Status Updated Successfully.');
	}

//=================================================kwikload================================================
public function view_kwikload_forms(){
    $dot = $_GET['dot'] ?? '';
    if(!empty($dot)){
        $datas = formpage2::where('type',2)->where('dot',$dot)->latest()->paginate(10);
    }
    else{
        $datas = formpage2::where('type',2)->latest()->paginate(10);
    }
    return view('admin.loadform.view_kwikload_forms',compact('datas'));
}
public function view_kwikload_pdfs($id){
    $data = formpage3::where('page_2_id',$id)->first();
    return view('admin.loadform.view_kwikloadpdf',compact('data'));
}


}