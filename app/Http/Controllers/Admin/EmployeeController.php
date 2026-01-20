<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = User::all();
        return view('admin.employees.index', compact('employees'));
    }

    public function create()
    {
        return view('admin.employees.create');
    }

   public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'phone' => 'nullable|string|max:15',
        'password' => 'required|string|min:8',
        'role' => 'required|in:0,1,2',
        'designation' => 'required|string|max:255',
        'gender' => 'required|string|in:male,female',
    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'password' => Hash::make($request->password),
        'role' => $request->role,
        'designation' => $request->designation,
        'gender' => $request->gender,
        'profile' => '',
        'status' => 1,      // ✅ IMPORTANT (1 = agents आपके table comment के अनुसार)
        'is_active' => 1,   // optional but good practice
    ]);

    return redirect()->route('employees')
        ->with('success', 'Employee added successfully.');
}


    public function edit($id)
    {
        $employee = User::findOrFail($id);
        return view('admin.employees.edit', compact('employee'));
    }

    public function update(Request $request, $id)
    {
        $employee = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:15',
            'role' => 'required|in:0,1,2',
            'designation' => 'required|string|max:255',
            'gender' => 'required|string|in:male,female',
        ]);

        $employee->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'designation' => $request->designation,
            'gender' => $request->gender,
        ]);

        return redirect()->route('employees')->with('success', 'Employee updated successfully.');
    }

    public function destroy($id)
    {
        $employee = User::findOrFail($id);
        $employee->delete();
        return redirect()->route('employees')->with('success', 'Employee deleted successfully.');
    }
}
