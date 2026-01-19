<?php

namespace App\Http\Controllers\Backend\Other;

use App\Http\Controllers\Controller;
use App\Models\address;
use App\Models\login_logout;
use App\Models\salary;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TeamController extends Controller
{

    // Admin Open
    public function viewTeam()
    {
        $teams = User::all();
        return view('backend.admin.team.index', compact('teams'));
    }

    public function storeTeam(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'gender' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'password' => 'required',
            'cpassword' => 'required|same:password',
            'designation' => 'required|in:Manager,Agent',
            'profile' => 'file|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Check if email or phone already exists
        $existingUser = User::where('email', $validated['email'])->orWhere('phone', $validated['phone'])->first();

        if ($existingUser) {
            // User with the same email or phone already exists
            $request->session()->flash('error', 'Email or phone already taken.');
            return redirect()->back();
        }

        // Handle file upload
        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = 'profiles/' . $fileName;

            // Move the uploaded file to the public folder
            $file->move(public_path('profiles'), $fileName);
            $validated['profile'] = $filePath;
        }

        // Set role based on designation
        $validated['role'] = ($validated['designation'] == 'Manager') ? '1' : '2';
        $validated['rel_id'] = auth()->user()->id;
        $validated['show_password'] = $validated['password'];



        // Create the user
        User::create($validated);

        // Add the toastr success message to the session
        $request->session()->flash('success', 'New Team Member Added!');

        return redirect()->back();
    }

    public function getTeam($id)
    {
        $user = User::findOrFail($id);

        return response()->json($user);
    }

    // Update team member data
    public function updateTeamMember(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:users,id',
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'gender' => 'required|in:Male,Female',
            'designation' => 'required|in:Manager,Agent',
            'profile' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = User::find($validated['id']);

        if (!$user) {
            // Handle the case where the user with the given ID is not found
            return redirect()->back()->withErrors(['User not found']);
        }

        // Remove the previous profile image if a new image is uploaded
        if ($request->hasFile('profile')) {
            $this->removeProfileImage($user->profile);
        }

        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = 'profiles/' . $fileName;

            // Check if the file already exists, rename if necessary
            while (file_exists(public_path($filePath))) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = 'profiles/' . $fileName;
            }

            $file->move(public_path('profiles'), $fileName);
            $validated['profile'] = $filePath;
        }

        $user->update([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'gender' => $validated['gender'],
            'designation' => $validated['designation'],
            'profile' => $validated['profile'] ?? $user->profile,
        ]);

        $request->session()->flash('success', 'Team Member Updated!');

        return redirect()->back();
    }

    /**
     * Remove the profile image from storage.
     *
     * @param string|null $filePath
     * @return void
     */
    protected function removeProfileImage($filePath)
    {
        if ($filePath && file_exists(public_path($filePath))) {
            unlink(public_path($filePath));
        }
    }


    public function deleteTeamMember(Request $request, $id)
    {
        $user = User::find($id);

        if ($user) {
            // Delete profile image
            if ($user->profile) {
                Storage::delete($user->profile);
            }

            // Delete the user
            $user->delete();

            // Flash a success message
            $request->session()->flash('success', 'Team Member Deleted!');
        } else {
            // Flash an error message if the user is not found
            $request->session()->flash('error', 'User not found!');
        }

        // Redirect back to the previous page
        return redirect()->back();
    }

    public function viewProfile($id)
    {
        $user_id = decrypt($id);
        $user = User::find($user_id);
        $address = address::where('user_id', $user_id)->first();
        $salary = salary::where('user_id', $user_id)->first();
        return view('backend.admin.team.profile', compact('user', 'address', 'salary'));
    }

    public function editProfile($id)
    {
        $user_id = decrypt($id);
        $user = User::find($user_id);
        $address = address::where('user_id', $user_id)->first();
        $salary = salary::where('user_id', $user_id)->first();
        return view('backend.admin.team.edit_profile', compact('user', 'address', 'salary'));
    }

    public function storeAddress(Request $request)
    {
        $validated = $request->validate([
            'address' => 'required',
            'city' => 'required',
            'country' => 'required',
            'zip' => 'required',
        ]);

        // Use first() instead of get() to get a single instance
        $address = Address::where('user_id', $request->id)->first();

        if ($address) {
            // Use update() method to update the existing record
            $address->update($validated);
        } else {
            // Use create() method to create a new record
            Address::create(array_merge($validated, ['user_id' => $request->id]));
        }

        // Flash a success message
        $request->session()->flash('success', 'Address Added/Updated Successfully!');

        // Redirect back or to a specific page
        return redirect()->back();
    }
    public function storeSalary(Request $request)
    {
        $validated = $request->validate([
            'annual' => 'required',
            'monthly' => 'required',
        ]);

        // Use first() instead of get() to get a single instance
        $salary = salary::where('user_id', $request->id)->first();

        if ($salary) {
            // Use update() method to update the existing record
            $salary->update($validated);
        } else {
            // Use create() method to create a new record
            salary::create(array_merge($validated, ['user_id' => $request->id]));
        }

        // Flash a success message
        $request->session()->flash('success', 'Salary Added/Updated Successfully!');

        // Redirect back or to a specific page
        return redirect()->back();
    }

    public function changePassword(Request $request)
    {
        $validated = $request->validate([
            'oldpassword' => 'required',
            'password' => 'required|min:8',
            'cpassword' => 'required|same:password',
        ]);

        $user = User::find($request->id);

        if ($user) {
            if (password_verify($validated['oldpassword'], $user->password)) {
                $user->password = bcrypt($validated['password']);
                $user->save();

                $request->session()->flash('success', 'Password changed successfully!');
            } else {
                $request->session()->flash('error', 'Incorrect old password.');
            }
        } else {
            $request->session()->flash('error', 'User not found.');
        }

        return redirect()->back();
    }
    // Admin Close

    // Manager Open
    public function managerViewTeam()
    {
        $mng_id = auth()->user()->id;
        $teams = User::where('rel_id', $mng_id)->get();
        return view('backend.manager.team.index', compact('teams'));
    }

    public function managerStoreTeam(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'gender' => 'required',
            'phone' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'cpassword' => 'required|same:password',
            'designation' => 'required|in:Manager,Agent',
            'profile' => 'file|mimes:jpeg,png,jpg,gif|max:2048',
            'rel_id' => 'nullable',
        ]);

        // Handle file upload
        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = 'profiles/' . $fileName;

            // Move the uploaded file to the public folder
            $file->move(public_path('profiles'), $fileName);
            $validated['profile'] = $filePath;
        }

        // Set role based on designation
        $validated['role'] = ($validated['designation'] == 'Manager') ? '1' : '2';
        $validated['rel_id'] = auth()->user()->id;
        $validated['show_password'] = $validated['password'];

        // Check if email or phone already exists
        $existingUser = User::where('email', $validated['email'])->orWhere('phone', $validated['phone'])->first();

        if ($existingUser) {
            // User with the same email or phone already exists
            $request->session()->flash('success', 'Email or phone already taken.');
            return redirect()->back();
        }

        // Create the user
        User::create($validated);

        // Add the toastr success message to the session
        $request->session()->flash('success', 'New Team Member Added!');

        return redirect()->back();
    }

    // Manager Close

    // Admin Moniter Team
    public function moniterTeam()
    {
        $users = User::where('designation', '!=', 'admin')->get();
        return view('backend.admin.team.moniter_team', compact('users'));
    }
    public function viewMoniterTeam($id)
    {
        $userId = decrypt($id);
        $datas = login_logout::where('user_id', $userId)->get();
        return view('backend.admin.team.view_moniter_team', compact('datas'));
    }
    public function deleteMoniterTeam(Request $request, $id)
    {
        $userId = decrypt($id);
    
        // Use where clause to fetch records with the specified user_id
        $datas = login_logout::where('user_id', $userId)->get();
    
        if ($datas->count() > 0) {
            // Use delete method on the query builder to delete all matching records
            login_logout::where('user_id', $userId)->delete();
    
            $request->session()->flash('success', 'User login logout time deleted successfully!');
            return redirect()->back();
        }
    
        // If no records found, you might want to handle it accordingly (e.g., show an error message).
        $request->session()->flash('error', 'No records found for the user!');
        return redirect()->back();
    }
    
public function changeStatus(Request $request, $id) {
    $user = User::find($id);

    if ($user) {
        // Toggle the user status
        $user->status = $user->status == '1' ? '0' : '1';
        $user->save();

            $request->session()->flash('success', 'Status changed successfully.');
    } else {
        $request->session()->flash('error', 'User not found.');
    }

    return redirect()->back();
}
    
}
