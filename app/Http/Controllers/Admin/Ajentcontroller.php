<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\adminmodel\Team;
use App\adminmodel\Users_detailsModal;
use App\adminmodel\AdminSidebar;
use App\adminmodel\AdminSidebar2;
use App\adminmodel\Order1Modal;
use App\adminmodel\UserModal;
use App\adminmodel\CategoryModal;
use App\adminmodel\ProductModal;
use App\Models\User;
use App\Models\bank;
use App\Models\Leaves;
use App\adminmodel\Current_employ;
use App\adminmodel\IdentityModal;
use App\adminmodel\SalaryModal;
use App\Models\Goal;


class Ajentcontroller extends Controller
{
	public function add_ajent_view(Request $req)
	{
			return view('admin/Ajent/add_Ajent');
	}
	public function view_ajent(Request $req)
{
    // First get active users
    $activeUsers = User::where('team_id', null)
        ->where('is_active', 1) // Only active users
        ->orderBy('id', 'desc') // Order them by id descending
        ->get();

    // Then get inactive users
    $inactiveUsers = User::where('team_id', null)
        ->where('is_active', 0) // Only inactive users
        ->orderBy('id', 'desc') // Order them by id descending
        ->get();

    // Combine both active and inactive users into one collection
    $teamData = $activeUsers->merge($inactiveUsers);

    return view('admin/Ajent/view_ajent', ['teamdetails' => $teamData]);
}
	public function UpdateajentStatus($status, $idd, Request $req)
	{
			$id = base64_decode($idd);


			$admin_id = $req->session()->get('admin_id');
			if ($id == $admin_id) {

				return Redirect()->back()->with('error', "Sorry You can't change status of yourself.");
			}
			
				if ($status == "active") {
					$teamStatusInfo = [
						'is_active' => 0,
					];
					$TeamData = User::where('id', $id)->first();
					$TeamData->update($teamStatusInfo);
				} else {
					$teamStatusInfo = [
						'is_active' => 1,
					];
					$TeamData = User::where('id', $id)->first();
					$TeamData->update($teamStatusInfo);
				}
				return Redirect()->route('view_ajent')->with('success', 'Status Updated Successfully.');
	}
	public function deleteajent($idd, Request $req)
	{
			$id = base64_decode($idd);


				$TeamData = User::where('id', $id)->first();
				if (!empty($TeamData)) {
					$img = $TeamData->image;
					$TeamData->delete();
					// if (!empty($img)) {
					// 	unlink($img);
					// }
					return Redirect()->route('view_ajent')->with('success', 'Data Deleted Successfully.');
				} else {
					return Redirect()->route('view_ajent')->with('error', 'Some Error Occurred.');
				}
	}
	public function add_ajent_process(Request $req)
	{
			$admin_id = $req->session()->get('admin_id');
			$req->validate([
				'name' => 'required',
				'email' => 'required|unique:users|email',
				'password' => 'required',
			]);

			$fullimagepath = '';
			if (!empty($req->img)) {
				$allowedFormats = ['jpeg', 'jpg', 'webp'];
				$extension = strtolower($req->img->getClientOriginalExtension());
				if (in_array($extension, $allowedFormats)) {
					$file = time() . '.' . $req->img->extension();
					$req->img->move(public_path('uploads/image/Ajents/'), $file);
					$fullimagepath = 'uploads/image/Ajents/' . $file;
				} else {
					// Handle invalid file format (not allowed)
					return redirect()->back()->with('error', 'Invalid file format. Only jpeg, jpg, and webp files are allowed.')->withInput();
				}
			}
			$teamInfo = [
				'name' => ucwords($req->input('name')),
				'email' => $req->input('email'),
				'phone' => $req->input('phone'),
				'password' => bcrypt($req->input('password')),
				'address' => $req->input('address'),
				'new_pass' => $req->input('password'),
				'status' => 1,
				'image' => $fullimagepath,
				'ip' => $req->ip(),
				'added_by' => $req->input('admin_id'),
				'is_active' => 1,
			];
			$last_id = User::create($teamInfo);
			return redirect()->route('update_ajent', base64_encode($last_id->id))
                 ->with('success', 'Data Added Successfully.');
		//return response()->json(['response' => 'OK']);
	}
    public function update_ajent($idd){


        $id = base64_decode($idd);

        $profile_data = Users_detailsModal::where('ajent_id', $id)->first();
		$current = Current_employ::where('ajent_id', $id)->first();
        $identety = IdentityModal::where('ajent_id', $id)->first();
        $salary = SalaryModal::where('ajent_id', $id)->first();
        $profile = User::where('id', $id)->first();
        $bank = bank::where('agent_id', $id)->first();
        $goal = Goal::where('agent_id', $id)->first();

   

        return view('admin/Ajent/update',compact('profile_data','id','profile','current','identety','salary','bank','goal'));
    }
    public function update_ajent_process(Request $req){
        $admin_id = $req->session()->get('admin_id');

        $id = $req->id;



			$teamInfo = [
                'ajent_id' => $req->input('id'),
				'name' => ucwords($req->input('name')),
				'alise_name' => ucwords($req->input('alise_name')),
				'phone' => $req->input('phone'),
				'dob' => $req->input('dob'),
				'gender' => $req->input('gender'),
				'marital' => $req->input('marital'),
				'blood' => $req->input('blood'),
				'guardian_name' => $req->input('guardian_name'),
				'em_name' => $req->input('em_name'),
				'em_number' => $req->input('em_number'),
				'em_relation' => $req->input('em_relation'),
				'em_address' => $req->input('em_address'),
				'ip' => $req->ip(),
				'added_by' =>$admin_id,
				'is_active' => 1,
			];

            $data = Users_detailsModal::where('ajent_id',$id)->first();


            if(empty($data)) {

                $last_id = Users_detailsModal::create($teamInfo);
                return Redirect()->back()->with('success', 'Data Added Successfully.');
            } else {
                $data->update($teamInfo);
                return Redirect()->back()->with('success', 'Data Updated Successfully.');
            }

    }
    public function update_current_ajent(Request $req){
        $admin_id = $req->session()->get('admin_id');

        $id = $req->id;

			$teamInfo = [
                'ajent_id' => $req->input('id'),
				'employ_id' => ucwords($req->input('employ_id')),
				'doj' => ucwords($req->input('doj')),
				'job_title' => ucwords($req->input('job_title')),

				'added_by' =>$admin_id,

			];

            $data = Current_employ::where('ajent_id',$id)->first();

            if(empty($data)) {

                $last_id = Current_employ::create($teamInfo);
                return Redirect()->back()->with('success', 'Data Added Successfully.');
            } else {
                $data->update($teamInfo);
                return Redirect()->back()->with('success', 'Data Added Successfully.');
            }




    }
    public function update_identety_ajent(Request $req){
		
        $admin_id = $req->session()->get('admin_id');

        $id = $req->id;

        $data = IdentityModal::where('ajent_id',$id)->first();
//-----------------aadhar image---------------------
        $fullaadharpath = '';
			if (!empty($req->aadhar)) {
				$allowedFormats = ['jpeg', 'jpg', 'webp'];
				$extension = strtolower($req->aadhar->getClientOriginalExtension());
				if (in_array($extension, $allowedFormats)) {
					$file = time() . 'aadhar.' . $req->aadhar->extension();
					$req->aadhar->move(public_path('uploads/image/docs/'), $file);
					$fullaadharpath = 'uploads/image/docs/' . $file;
				} else {
					// Handle invalid file format (not allowed)
					return redirect()->back()->with('error', 'Invalid file format. Only jpeg, jpg, and webp files are allowed.');
				}
			}
            else{
                $fullaadharpath = !empty($data->aadhar_card) ? $data->aadhar_card:'';
            }
//----------------------- pan image-------------------------
            $fullpanpath = '';
			if (!empty($req->pan)) {
				$allowedFormats = ['jpeg', 'jpg', 'webp'];
				$extension = strtolower($req->pan->getClientOriginalExtension());
				if (in_array($extension, $allowedFormats)) {
					$file = time() . 'pan.' . $req->pan->extension();
					$req->pan->move(public_path('uploads/image/docs/'), $file);
					$fullpanpath = 'uploads/image/docs/' . $file;
				} else {
					// Handle invalid file format (not allowed)
					return redirect()->back()->with('error', 'Invalid file format. Only jpeg, jpg, and webp files are allowed.');
				}
			}
            else{
                $fullpanpath = !empty($data->pan_card) ? $data->pan_card :'';
            }
//---------------------- licence image----------------------------
            $fulllicencepath = '';
			if (!empty($req->licence)) {
				$allowedFormats = ['jpeg', 'jpg', 'webp'];
				$extension = strtolower($req->licence->getClientOriginalExtension());
				if (in_array($extension, $allowedFormats)) {
					$file = time() . 'licence.' . $req->licence->extension();
					$req->licence->move(public_path('uploads/image/docs/'), $file);
					$fulllicencepath = 'uploads/image/docs/' . $file;
				} else {
					// Handle invalid file format (not allowed)
					return redirect()->back()->with('error', 'Invalid file format. Only jpeg, jpg, and webp files are allowed.');
				}
			}
            else{
                $fulllicencepath = !empty($data->driving_licence) ? $data->driving_licence : '';
            }

			if(!empty($req->verify)){
               $verify = 1;
			}else{
$verify = null;
			}

			$teamInfo = [
                'ajent_id' => $req->input('id'),
				'pan_card' => $fullpanpath,
				'aadhar_card' => $fullaadharpath,
				'driving_licence' => $fulllicencepath,
                'is_active'=>$verify,
				'added_by' =>$admin_id,

			];

   

            if(empty($data)) {

                $last_id = IdentityModal::create($teamInfo);
                return Redirect()->back()->with('success', 'Data Added Successfully.');
            } else {
                $data->update($teamInfo);
                return Redirect()->back()->with('success', 'Data Added Successfully.');
            }




    }
	public function update_bank_ajent(Request $req){

        $id = $req->id;

			$teamInfo = [
                'agent_id' => $req->input('id'),
				'holder_name' =>$req->input('name'),
				'account_number' => $req->input('account_no'),
				'ipsc' => $req->input('ifsc'),
				'upi_id' =>$req->input('upi'),
			];

            $data = bank::where('agent_id',$id)->first();

            if(empty($data)) {

                $last_id = bank::create($teamInfo);
                return Redirect()->back()->with('success', 'Data Added Successfully.');
            } else {
                $data->update($teamInfo);
                return Redirect()->back()->with('success', 'Data Added Successfully.');
            }




    }
    public function update_salary_ajent(Request $req){
        $admin_id = $req->session()->get('admin_id');

        $id = $req->id;
          if($req->ip_check){
			$ip = User::where('id',$id)->first();
			$ip->ip_check = $req->ip_check;
			$ip->save();
		  }
			$teamInfo = [
                'ajent_id' => $req->input('id'),
				'type' => ucwords($req->input('type')),
				'amount' => ucwords($req->input('amount')),
				'ip' => $req->ip(),
				'added_by' =>$admin_id,

			];

            $data = SalaryModal::where('ajent_id',$id)->first();

            if(empty($data)) {

                $last_id = SalaryModal::create($teamInfo);
                return Redirect()->back()->with('success', 'Data Added Successfully.');
            } else {
                $data->update($teamInfo);
                return Redirect()->back()->with('success', 'Data Added Successfully.');
            }
    }
	public function edit_agent($id){
		$team = User::where('id',$id)->first();
			return view('admin/Ajent/edit_agent', compact('team'));
	}
	public function edit_agent_store(Request $req,$id){
		$team = User::where('id',$id)->first();
		if(!empty($req->password)){
			$password = bcrypt($req->password);
		}else{
			$password = $team->password;
		}
		$team->name = $req->name;
		$team->email = $req->email;
		$team->password = $password;
		$team->phone = $req->phone;
		$team->save();

		return redirect()->route('view_ajent');

	}

    public function update_target_ajent(Request $req){
        $admin_id = $req->session()->get('admin_id');
        $id = $req->id;

        $goalInfo = [
            'agent_id' => $id,
            'target_month' => $req->input('target_month'),
            'target_value' => $req->input('target_value'),
            'notes' => $req->input('notes')
        ];

        $data = Goal::where('agent_id', $id)->first();

        if(empty($data)) {
            Goal::create($goalInfo);
            return Redirect()->back()->with('success', 'Monthly Target Added Successfully.');
        } else {
            $data->update($goalInfo);
            return Redirect()->back()->with('success', 'Monthly Target Updated Successfully.');
        }
    }

}
