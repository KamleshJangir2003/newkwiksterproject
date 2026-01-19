<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\adminmodel\Sameday;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use Illuminate\Routing\Controller as BaseController;

class Samedaycontroller extends BaseController
{

    public function samedayload_link(){
        return view('admin.same_day_load.make_link');
    }
   
    public function samedayload(Request $request)
{
    // Get the Base64 encoded data from the query parameter
    $encodedData = $request->input('data');

    // Decode the Base64 encoded data
    $decodedData = base64_decode($encodedData);

    // Parse the query string into an array
    parse_str($decodedData, $parameters);

    // Access the parameters
    $name1 = $parameters['name1'] ?? null;
    $name2 = $parameters['name2'] ?? null;
    $name3 = $parameters['name3'] ?? null;
    $name4 = $parameters['name4'] ?? null;
    $name5 = $parameters['name5'] ?? null;
    $name6 = $parameters['name6'] ?? null;
    $name7 = $parameters['name7'] ?? null;
    $name8 = $parameters['name8'] ?? null;
    $name9 = $parameters['name9'] ?? null;

    // Pass parameters to the Blade view
    return view('admin.same_day_load.view_pdf', compact('name1', 'name2', 'name3', 'name4', 'name5', 'name6', 'name7', 'name8', 'name9'));
}

public function sameday_process(Request $req){
    $req->validate([
        'signature' => 'required',
    ]);
    $signature = $req->input('signature');

    // Remove the base64 prefix from the string
    $signature = str_replace('data:image/png;base64,', '', $signature);
    $signature = str_replace(' ', '+', $signature);

    $signatureData = base64_decode($signature);
    $fileName = 'signature_' . time() . '.png';
    $filePath = 'same_day_load/signature/' . $fileName;
    $fullPath = public_path($filePath); // Define the full path in the public directory

    // Check if the directory exists and create it if it doesn't
    $directoryPath = public_path('same_day_load/signature/');
    if (!File::exists($directoryPath)) {
        File::makeDirectory($directoryPath, 0755, true); // Create directory with permissions
    }
  
    // Save the file to the public path
    file_put_contents($fullPath, $signatureData);

    $formdata = new Sameday();
    $formdata->name1 =  $req->name1;
    $formdata->name2 =  $req->name2;
    $formdata->name3 =  $req->name3;
    $formdata->name4 =  $req->name4;
    $formdata->name5 =  $req->name5;
    $formdata->name6 =  $req->name6;
    $formdata->name7 =  $req->name7;
    $formdata->name8 =  $req->name8;
    $formdata->name9 =  $req->name9;
    $formdata->signature =  $filePath;
  
    $formdata->save();
    
      return redirect()->route('view_thankyou');
}
public function view_sameday_forms(){
    $datas = Sameday::latest()->paginate(10);
    $users = User::where('is_active',1);
      return view('admin.same_day_load.admin_view',compact('datas','users'));
    
}
public function view_sameday_pdfs(Request $req,$id){
    $data = Sameday::where('id',$id)->first();
       return view('admin.same_day_load.same_day_pdf',compact('data'));
}


}