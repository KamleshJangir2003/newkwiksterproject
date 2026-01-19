<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\load_lead;

use Carbon\Carbon;

class loadcontroller extends Controller
{
public function view_load(){
    $incomings = load_lead::where('category','Incoming')->latest()->get();
    $insureds = load_lead::where('category','Insured')->latest()->get();
    $factoings = load_lead::where('category','factoring')->latest()->get();
    $loads = load_lead::where('category','Load')->latest()->get();
    $boards = load_lead::where('category','On Board')->latest()->get();
    $roasters = load_lead::where('category','Roaster')->latest()->get();
    return view('Agent.load.view_load',compact('incomings','insureds','factoings','loads','boards','roasters'));
}
public function store_load_lead(Request $req){
    $id = $req->id;
	$olddata = load_lead::where('id',$id)->first();
  $fullimagepath = $olddata->file1 ?? '';
			if (!empty($req->file1)) {
			$allowedFormats = ['jpeg', 'jpg', 'webp','pdf'];
				$extension = strtolower($req->file1->getClientOriginalExtension());
				if (in_array($extension, $allowedFormats)) {
					$file = time() . '1.' . $req->file1->extension();
					$req->file1->move(public_path('uploads/image/loaddocs/'), $file);
					$fullimagepath = 'uploads/image/loaddocs/' . $file;
				} else {
					// Handle invalid file format (not allowed)
					return redirect()->back()->with('error', 'Invalid file format. Only jpeg, jpg, and webp files are allowed.')->withInput();
				}
			}

      $fullimagepath2 =  $olddata->file2 ?? '';
			if (!empty($req->file2)) {
        $allowedFormats = ['jpeg', 'jpg', 'webp','pdf'];
				$extension = strtolower($req->file2->getClientOriginalExtension());
				if (in_array($extension, $allowedFormats)) {
					$file = time() . '1.' . $req->file2->extension();
					$req->file2->move(public_path('uploads/image/loaddocs/'), $file);
					$fullimagepath2 = 'uploads/image/loaddocs/' . $file;
				} else {
					// Handle invalid file format (not allowed)
					return redirect()->back()->with('error', 'Invalid file format. Only jpeg, jpg, and webp files are allowed.')->withInput();
				}
			}

      $fullimagepath3 =  $olddata->file3 ?? '';
			if (!empty($req->file3)) {
        $allowedFormats = ['jpeg', 'jpg', 'webp','pdf'];
				$extension = strtolower($req->file3->getClientOriginalExtension());
				if (in_array($extension, $allowedFormats)) {
					$file = time() . '1.' . $req->file3->extension();
					$req->file3->move(public_path('uploads/image/loaddocs/'), $file);
					$fullimagepath3 = 'uploads/image/loaddocs/' . $file;
				} else {
					// Handle invalid file format (not allowed)
					return redirect()->back()->with('error', 'Invalid file format. Only jpeg, jpg, and webp files are allowed.')->withInput();
				}
			}

      $fullimagepath4 =  $olddata->file4 ?? '';
			if (!empty($req->file4)) {
				$allowedFormats = ['jpeg', 'jpg', 'webp','pdf'];
				$extension = strtolower($req->file4->getClientOriginalExtension());
				if (in_array($extension, $allowedFormats)) {
					$file = time() . '1.' . $req->file4->extension();
					$req->file4->move(public_path('uploads/image/loaddocs/'), $file);
					$fullimagepath4 = 'uploads/image/loaddocs/' . $file;
				} else {
					// Handle invalid file format (not allowed)
					return redirect()->back()->with('error', 'Invalid file format. Only jpeg, jpg, and webp files are allowed.')->withInput();
				}
			}

			if(!empty($id)){
				$formdata =  load_lead::where('id',$id)->first();
			}else{
				$formdata = new load_lead();
			}

    
    $formdata->name =  $req->name;
    $formdata->company =  $req->company_name;
    $formdata->dot =  $req->dot;
    $formdata->mc =  $req->mc;
    $formdata->phone =  $req->phone;
    $formdata->category =  $req->category;
    $formdata->file1 =  $fullimagepath;
    $formdata->file2 =  $fullimagepath2;
    $formdata->file3 =  $fullimagepath3;
    $formdata->file4 =  $fullimagepath4;
    $formdata->note =  $req->notepad;
    $formdata->save();
  session()->flash('success','Lead added successfully');
    return redirect()->back();

}
public function delete_load_leads($id){

  $lead = load_lead::find($id);
  $lead->delete();
  return redirect()->back();

}

}