<?php

namespace App\Http\Controllers\forms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\formpage2;
use App\Models\formpage3;
use App\Models\formpage4;
use App\Mail\multiform;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;



class multiformscontroller extends Controller
{

    public function page_one_view(){
        return view('forms.pageone');
    }
    public function page_two_view(){
        return view('forms.pagetwo');
    }
    public function page_three_view($id){
        return view('forms.pagethree',compact('id'));
    }
     public function page_four_view(){
        return view('forms.pagefour');
    }
    public function view_thankyou(){
        return view('forms.thankyou');
    }

    public function page_two_store(Request $req){

      
        $fullimagepath = '';
			if (!empty($req->certificate)) {
				$allowedFormats = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'csv', 'txt', 'rtf', 'html', 'zip', 'mp3', 'wma', 'mpg', 'flv', 'avi', 'jpg', 'jpeg', 'png', 'gif'];
				$extension = strtolower($req->certificate->getClientOriginalExtension());
				if (in_array($extension, $allowedFormats)) {
					$file = time() . 'two.' . $req->certificate->extension();
					$req->certificate->move(public_path('uploads/multiforms/'), $file);
					$fullimagepath = 'uploads/multiforms/' . $file;
				} else {
					// Handle invalid file format (not allowed)
					return redirect()->back()->with('error', 'Invalid file format. Only jpeg, jpg, and webp files are allowed.')->withInput();
				}
			}
            $fullimagepath2 = '';
			if (!empty($req->w9)) {
				$allowedFormats = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'csv', 'txt', 'rtf', 'html', 'zip', 'mp3', 'wma', 'mpg', 'flv', 'avi', 'jpg', 'jpeg', 'png', 'gif'];
				$extension = strtolower($req->w9->getClientOriginalExtension());
				if (in_array($extension, $allowedFormats)) {
					$file = time() . 'two2.' . $req->w9->extension();
					$req->w9->move(public_path('uploads/multiforms/'), $file);
					$fullimagepath2 = 'uploads/multiforms/' . $file;
				} else {
					// Handle invalid file format (not allowed)
					return redirect()->back()->with('error', 'Invalid file format. Only jpeg, jpg, and webp files are allowed.')->withInput();
				}
			}

            $fullimagepath3 = '';
			if (!empty($req->insurance)) {
				$allowedFormats = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'csv', 'txt', 'rtf', 'html', 'zip', 'mp3', 'wma', 'mpg', 'flv', 'avi', 'jpg', 'jpeg', 'png', 'gif'];
				$extension = strtolower($req->insurance->getClientOriginalExtension());
				if (in_array($extension, $allowedFormats)) {
					$file = time() . 'two3.' . $req->insurance->extension();
					$req->insurance->move(public_path('uploads/multiforms/'), $file);
					$fullimagepath3 = 'uploads/multiforms/' . $file;
				} else {
					// Handle invalid file format (not allowed)
					return redirect()->back()->with('error', 'Invalid file format. Only jpeg, jpg, and webp files are allowed.')->withInput();
				}
			}
            $fullimagepath4 = '';
			if (!empty($req->company_picture)) {
				$allowedFormats = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'csv', 'txt', 'rtf', 'html', 'zip', 'mp3', 'wma', 'mpg', 'flv', 'avi', 'jpg', 'jpeg', 'png', 'gif'];
				$extension = strtolower($req->company_picture->getClientOriginalExtension());
				if (in_array($extension, $allowedFormats)) {
					$file = time() . 'two4.' . $req->company_picture->extension();
					$req->company_picture->move(public_path('uploads/multiforms/'), $file);
					$fullimagepath4 = 'uploads/multiforms/' . $file;
				} else {
					// Handle invalid file format (not allowed)
					return redirect()->back()->with('error', 'Invalid file format. Only jpeg, jpg, and webp files are allowed.')->withInput();
				}
			}
      
            $formdata = new formpage2();
            $formdata->first_name =  $req->first_name;
            $formdata->last_name =  $req->last_name;
            $formdata->phone =  $req->phone;
            $formdata->email =  $req->email;
            $formdata->dot =  $req->dot;
            $formdata->mc_docket =  $req->mc_docket;
            $formdata->equipment =  $req->equipment;
            $formdata->address =  $req->address;
            $formdata->city =  $req->city;
            $formdata->state =  $req->state;
            $formdata->zip =  $req->zip;
            $formdata->certificate =  $fullimagepath;
            $formdata->license =  $fullimagepath2;
            $formdata->file1 =  $fullimagepath3;
            $formdata->file2 =  $fullimagepath4;
              
            $formdata->save();

            $idd = base64_encode($formdata->id);
			return redirect()->route('view_page_three',  $idd);
                

    }
  public function page_three_store(Request $req, $idd = "")
{
    $req->validate([
        'signature' => 'required',
    ]);

    $id = base64_decode($idd);

    // Process signature
    $signature = str_replace('data:image/png;base64,', '', $req->input('signature'));
    $signature = str_replace(' ', '+', $signature);

    $signatureData = base64_decode($signature);
    $fileName = 'signature_' . time() . '.png';
    $filePath = 'uploads/multiforms/signature/' . $fileName;
    $fullPath = public_path($filePath);

    // Ensure directory exists
    $directoryPath = public_path('uploads/multiforms/signature');
    if (!File::exists($directoryPath)) {
        File::makeDirectory($directoryPath, 0755, true);
    }

    // Save signature image
    file_put_contents($fullPath, $signatureData);

    // Save form data
    $formdata = new formpage3();
    $formdata->page_2_id   = $id;
    $formdata->comapny_name = $req->comapny_name;
    $formdata->year        = $req->year;
    $formdata->Make        = $req->make;
    $formdata->model       = $req->model;
    $formdata->vin         = $req->vin;
    $formdata->license_no  = $req->license_plate;
    $formdata->signature   = $filePath;
    $formdata->save();

    // Send email
    // $data = formpage2::find($id);
    // if ($data) {
    //     $name = trim($data->first_name . ' ' . $data->last_name);
    //     if (!empty($name)) {
    //         Mail::to($data->email)->send(new multiform(['name' => $name]));
    //     }
    // }

    return redirect()->route('view_thankyou');
}

     public function page_four_store(Request $req){

        $fullimagepath = '';
        if (!empty($req->file1)) {
            $allowedFormats = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'csv', 'txt', 'rtf', 'html', 'zip', 'mp3', 'wma', 'mpg', 'flv', 'avi', 'jpg', 'jpeg', 'png', 'gif'];
            $extension = strtolower($req->file1->getClientOriginalExtension());
            if (in_array($extension, $allowedFormats)) {
                $file = time() . 'four.' . $req->file1->extension();
                $req->file1->move(public_path('uploads/multiforms/'), $file);
                $fullimagepath = 'uploads/multiforms/' . $file;
            } else {
                // Handle invalid file format (not allowed)
                return redirect()->back()->with('error', 'Invalid file format. Only jpeg, jpg, and webp files are allowed.')->withInput();
            }
        }
        $fullimagepath2 = '';
        if (!empty($req->file2)) {
            $allowedFormats = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'csv', 'txt', 'rtf', 'html', 'zip', 'mp3', 'wma', 'mpg', 'flv', 'avi', 'jpg', 'jpeg', 'png', 'gif'];
            $extension = strtolower($req->file2->getClientOriginalExtension());
            if (in_array($extension, $allowedFormats)) {
                $file = time() . 'four2.' . $req->file2->extension();
                $req->file2->move(public_path('uploads/multiforms/'), $file);
                $fullimagepath2 = 'uploads/multiforms/' . $file;
            } else {
                // Handle invalid file format (not allowed)
                return redirect()->back()->with('error', 'Invalid file format. Only jpeg, jpg, and webp files are allowed.')->withInput();
            }
        }
        $fullimagepath3 = '';
        if (!empty($req->file3)) {
            $allowedFormats = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'csv', 'txt', 'rtf', 'html', 'zip', 'mp3', 'wma', 'mpg', 'flv', 'avi', 'jpg', 'jpeg', 'png', 'gif'];
            $extension = strtolower($req->file3->getClientOriginalExtension());
            if (in_array($extension, $allowedFormats)) {
                $file = time() . 'four3.' . $req->file3->extension();
                $req->file3->move(public_path('uploads/multiforms/'), $file);
                $fullimagepath3 = 'uploads/multiforms/' . $file;
            } else {
                // Handle invalid file format (not allowed)
                return redirect()->back()->with('error', 'Invalid file format. Only jpeg, jpg, and webp files are allowed.')->withInput();
            }
        }
        $fullimagepath4 = '';
        if (!empty($req->file4)) {
            $allowedFormats = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'csv', 'txt', 'rtf', 'html', 'zip', 'mp3', 'wma', 'mpg', 'flv', 'avi', 'jpg', 'jpeg', 'png', 'gif'];
            $extension = strtolower($req->file4->getClientOriginalExtension());
            if (in_array($extension, $allowedFormats)) {
                $file = time() . 'four4.' . $req->file4->extension();
                $req->file4->move(public_path('uploads/multiforms/'), $file);
                $fullimagepath4 = 'uploads/multiforms/' . $file;
            } else {
                // Handle invalid file format (not allowed)
                return redirect()->back()->with('error', 'Invalid file format. Only jpeg, jpg, and webp files are allowed.')->withInput();
            }
        }
        $fullimagepath5 = '';
        if (!empty($req->file5)) {
            $allowedFormats = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'csv', 'txt', 'rtf', 'html', 'zip', 'mp3', 'wma', 'mpg', 'flv', 'avi', 'jpg', 'jpeg', 'png', 'gif'];
            $extension = strtolower($req->file5->getClientOriginalExtension());
            if (in_array($extension, $allowedFormats)) {
                $file = time() . 'four5.' . $req->file5->extension();
                $req->file5->move(public_path('uploads/multiforms/'), $file);
                $fullimagepath5 = 'uploads/multiforms/' . $file;
            } else {
                // Handle invalid file format (not allowed)
                return redirect()->back()->with('error', 'Invalid file format. Only jpeg, jpg, and webp files are allowed.')->withInput();
            }
        }
     
        $formdata = new formpage4();
        $formdata->dot =  $req->dot;
        $formdata->file1 =  $fullimagepath;
        $formdata->file2 =  $fullimagepath2;
        $formdata->file3 =  $fullimagepath3;
        $formdata->file4 =  $fullimagepath4;
        $formdata->file5 =  $fullimagepath5;
        $formdata->comment =  $req->comments;
        $formdata->save();
      
        return redirect()->route('view_thankyou');

    }


}