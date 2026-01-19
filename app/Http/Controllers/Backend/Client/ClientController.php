<?php

namespace App\Http\Controllers\Backend\Client;

use App\Http\Controllers\Controller;
use App\Models\client;
use App\Models\ClientEvents;
use App\Models\clientForm;
use App\Models\comment;
use App\Models\ExcelData;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class ClientController extends Controller
{
    // Client All Form
    public function allForm()
    {
        $userId = auth()->user()->id;

        // Get agent IDs for the manager
        $agentIds = User::where('rel_id', $userId)->pluck('id');

        // Initialize an empty collection to store agent customers
        $agentcustomers = collect();

        // Retrieve customers for each agent
        foreach ($agentIds as $agentId) {
            $agentCustomers = ExcelData::where('click_id', $agentId)
                ->where('form_status', 'Intrested')
                ->get();

            // Concatenate the agent customers to the collection
            $agentcustomers = $agentcustomers->concat($agentCustomers);
        }

        // Retrieve manager customers
        $managerCustomers = ExcelData::where('click_id', $userId)
            ->where('form_status', 'Intrested')
            ->get();

        // Concatenate manager and agent customers
        $customers = $managerCustomers->concat($agentcustomers);

        if (auth()->user()->designation == 'Manager') {
            $agentIds = User::where('rel_id', $userId)->pluck('id');
            $agentClientForms = clientForm::whereIn('user_id', $agentIds)->get();
            $managerClientForm = clientForm::where('user_id', $userId)->get();

            $client_form = $managerClientForm->concat($agentClientForms)->sortByDesc('id');
        } else {
            $client_form = clientForm::where('user_id', $userId)->orderBy('id', 'DESC')->get();
        }

        return view('backend.client.all_form', compact('customers', 'client_form'));
    }

    // Admin Client All Form
    public function adminAllForm()
    {
        $userId = auth()->user()->id;

        if (auth()->user()->designation == 'Admin') {
            // Get manager IDs under the admin
            $managerIds = User::where('rel_id', $userId)->pluck('id');

            // Get agent IDs under those managers
            $agentIds = User::whereIn('rel_id', $managerIds)->pluck('id');

            // Get client forms for agents and managers
            $client_form = clientForm::whereIn('user_id', $agentIds)
                ->orWhereIn('user_id', $managerIds)
                ->orderBy('id', 'DESC')
                ->get();
        } else {
            // If not admin, get client forms for the current user
            $client_form = clientForm::where('user_id', $userId)->orderBy('id', 'DESC')->get();
        }

        // Rest of your code...

        return view('backend.client.all_form', compact('client_form'));
    }

    // Store Client Form 
    public function storeClientForm(Request $request)
{
    $validated = $request->validate([
        'india_agent_name' => 'required',
        'customer_name' => 'required',
        'phone' => 'required', // Check uniqueness in the client_forms table
        'company_name' => 'required',
        'pdf.*' => 'nullable|mimes:pdf', // Use "pdf.*" for array validation
        'customer_id' => 'required',
        'comment' => 'required',
    ]);

    if ($request->agentId) {
        $validated['user_id'] = $request->agentId;
    } else {
        $validated['user_id'] = auth()->user()->id;
    }
    $validated['upload_date'] = now();

    // Handle file upload
    $pdfPaths = [];
    if ($request->hasFile('pdf')) {
        $pdfFiles = $request->file('pdf');

        foreach ($pdfFiles as $key => $pdfFile) {
            $fileName = time() . '_' . $pdfFile->getClientOriginalName();
            $filePath = 'pdf/' . $fileName;
            $pdfFile->move(public_path('pdf'), $fileName);
            $pdfPaths[] = $filePath;
        }
    }

    $validated['pdf'] = json_encode($pdfPaths);

    // Check if the phone number already exists
    if (clientForm::where('phone', $validated['phone'])->exists()) {
        $request->session()->flash('error', 'Phone number already exists. Cannot submit the form.');
        return redirect()->back();
    } else {
        // Create the clientForm record
        $clientForm = clientForm::create($validated);
        if ($clientForm) {
            $comment = new comment();
            $comment->data_id = $clientForm->id;
            $comment->comment = auth()->user()->designation . ':- ' . $validated['comment'];
            $comment->save();
        }

        $request->session()->flash('success', 'New client form added successfully!');
        return redirect()->back();
    }
}



    // Change Step Status
    public function changeStepStatus(Request $request, $data_id, $step, $step_value)
    {

        $clientForm = clientForm::find($data_id);
        if ($clientForm) {
            $clientForm->step = $step;
            $clientForm->step_value = $step_value;
            $clientForm->save();
            $request->session()->flash('success', "Step status changed to $step");
            return redirect()->back();
        }
    }

    // Login
    public function login()
    {
        return view('backend.client.login');
    }

    public function logout()
    {
        Session::forget('client_id');
        return view('backend.client.login');
    }

    // Signup
    public function signup()
    {
        return view('backend.client.signup');
    }

    // Client Register
    public function clientRegister(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required',
            'email' => 'required|email|unique:clients,email',
            'password' => 'required|min:6',
        ]);
        $validated['password'] = Hash::make($validated['password']);
        $client = Client::create($validated);
        $request->session()->flash('success', 'Registration Successful!');
        return redirect()->back();
    }

    // Login Check
    public function loginCheck(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $client = Client::where('email', $validated['email'])->first();

        if ($client && Hash::check($validated['password'], $client->password)) {
            session(['client_id' => $client->id]);
            return redirect()->route('client.panel.dashboard');
        }

        // Handle invalid login
        return redirect()->back()->with('error', 'Invalid email or password');
    }

    // Client Panel
    public function clientPanelDashboard()
    {
        $total_forms = clientForm::all();
        $total_pipeline = clientForm::where('status', 'Pipeline')->get();
        $total_sold = clientForm::where('status', 'Sold')->get();
        $total_lost = clientForm::where('status', 'Lost')->get();
        $total_cancel = clientForm::where('status', 'Cancel')->get();
        if (session('client_id')) {
            return view('backend.client.dashboard', compact('total_forms', 'total_pipeline', 'total_sold', 'total_lost', 'total_cancel'));
        } else {
            return view('backend.client.login');
        }
    }
    // Client Panel
    public function clientPanel()
    {
        $client_form = ClientForm::orderBy('priority', 'DESC')
            ->orderBy('id', 'DESC')
            ->get();
        if (session('client_id')) {
            return view('backend.client.client_panel', compact('client_form'));
        } else {
            return view('backend.client.login');
        }
    }

    // Get Customer Details
    public function getCustomerDetails($id)
    {
        $data = ExcelData::find($id);
        return response()->json($data);
    }

    // Store CLient Action Form
    public function storeClientActionForm(Request $request)
    {
        $priority = $request->input('priority', 0);;
        $estimate_closing_date = $request->estimate_closing_date;
        $estimate_closing_amount = $request->estimate_closing_amount;
        $estimate_closing_probability = $request->estimate_closing_probability;
        $status = $request->status;
        $pipeline_reminder = $request->pipeline_reminder;
        $sold_amount = $request->sold_amount;
        $lost_reason = $request->lost_reason;
        $cancel_reason = $request->cancel_reason;
        $data_id = $request->data_id;

        $clientForm = clientForm::find($data_id);
        if ($clientForm) {
            $clientForm->priority = $priority;
            $clientForm->estimate_closing_date = $estimate_closing_date;
            $clientForm->estimate_closing_amount = $estimate_closing_amount;
            $clientForm->estimate_closing_probability = $estimate_closing_probability;
            $clientForm->status = $status;

            if ($request->status == 'Pipeline') {
                $clientForm->pipeline_reminder = $pipeline_reminder;
                $clientForm->sold_amount = 'NULL';
                $clientForm->lost_reason = 'NULL';
                $clientForm->cancel_reason = 'NULL';
            } elseif ($request->status == 'Sold') {
                $clientForm->sold_amount = $sold_amount;
                $clientForm->pipeline_reminder = 'NULL';
                $clientForm->lost_reason = 'NULL';
                $clientForm->cancel_reason = 'NULL';
            } elseif ($request->status == 'Lost') {
                $clientForm->lost_reason = $lost_reason;
                $clientForm->sold_amount = 'NULL';
                $clientForm->pipeline_reminder = 'NULL';
                $clientForm->cancel_reason = 'NULL';
            } elseif ($request->status == 'Cancel') {
                $clientForm->cancel_reason = $cancel_reason;
                $clientForm->lost_reason = 'NULL';
                $clientForm->sold_amount = 'NULL';
                $clientForm->pipeline_reminder = 'NULL';
            }

            $clientForm->save();
            return redirect()->back();
        }
    }

    public function clientPanelFormData($id)
    {
        // Assuming 'clientForm' is your Eloquent model
        $data = clientForm::find($id);

        if ($data) {
            // If data is found, return it as a JSON response
            return response()->json(['data' => $data]);
        } else {
            // If data is not found, return an error response
            return response()->json(['error' => 'Data not found'], 404);
        }
    }

    // Check Pipeline Reminder
    public function getPipelineReminder($id)
    {
        // Fetch the data from the database based on the provided ID
        $data = clientForm::find($id); // Replace YourModel with the actual model name

        // Check if the pipeline_reminder value is not NULL before returning the response
        if ($data && $data->pipeline_reminder !== null) {
            return response()->json(['pipeline_reminder' => $data->pipeline_reminder, 'phone' => $data->phone]);
        } else {
            return response()->json(['pipeline_reminder' => null, 'message' => null]);
        }
    }


    // Holidays Calendar
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ClientEvents::whereDate('start', '>=', $request->start)
                ->whereDate('end',   '<=', $request->end)
                ->get(['id', 'title', 'start', 'end']);
            return response()->json($data);
        }
        if (session('client_id')) {
            return view('backend.client.client_calendar');
        } else {
            return view('backend.client.login');
        }
    }

    public function action(Request $request)
    {
        if ($request->ajax()) {
            if ($request->type == 'add') {
                $event = ClientEvents::create([
                    'title'        =>    $request->title,
                    'start'        =>    $request->start,
                    'end'        =>    $request->end
                ]);

                return response()->json($event);
            }

            if ($request->type == 'update') {
                $event = ClientEvents::find($request->id)->update([
                    'title'        =>    $request->title,
                    'start'        =>    $request->start,
                    'end'        =>    $request->end
                ]);

                return response()->json($event);
            }

            if ($request->type == 'delete') {
                $event = ClientEvents::find($request->id)->delete();

                return response()->json($event);
            }
        }
    }
    // Holidays Calendar

    // Get Agent Customer Data
    public function getAgentCustomerData($id)
    {
        $dataId = $id;
        $excelData = ExcelData::find($dataId);
        if (!$excelData) {
            return response()->json(['error' => 'ExcelData not found']);
        }
        $user = User::find($excelData->click_id);
        if (!$user) {
            return response()->json(['error' => 'User not found']);
        }
        $data = [
            'user' => $user,
            'excelData' => $excelData,
        ];
        return response()->json($data);
    }

    // /Get Agent Customer Data


    // Delete CLient Form
    public function deleteClientForm(Request $request, $id)
    {
        $data = clientForm::find($id);

        if ($data) {
            // Get the PDF file path
            $pdfFilePath = public_path($data->pdf);

            // Check if the file exists before attempting to delete
            if (file_exists($pdfFilePath)) {
                // Delete the PDF file
                unlink($pdfFilePath);
            }

            // Delete the client form record
            $data->delete();

            $request->session()->flash('success', 'Client Form Deleted Successfully!');
            return redirect()->back();
        } else {
            $request->session()->flash('error', 'Client Form not found!');
            return redirect()->back();
        }
    }
    
   // Update PDF
   public function updateClientPdf(Request $request)
   {
    // Handle file upload
    $pdfPaths = [];

    if ($request->hasFile('pdf')) {
        $pdfFiles = $request->file('pdf');

        foreach ($pdfFiles as $key => $pdfFile) {
            $fileName = time() . '_' . $pdfFile->getClientOriginalName();
            $filePath = 'pdf/' . $fileName;
            $pdfFile->move(public_path('pdf'), $fileName);
            $pdfPaths[] = $filePath;
        }
    }

    $c = clientForm::find($request->input('id'));
    $existingPdf = json_decode($c->pdf, true) ?? [];

    // Merge existing PDF paths with newly uploaded paths
    $pdfPaths = array_merge($existingPdf, $pdfPaths);

    $c->pdf = json_encode($pdfPaths);
    $c->save();

    $request->session()->flash('success', 'Client form pdf added successfully!');
    return redirect()->back();
   }
}
