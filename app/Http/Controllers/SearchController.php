<?php

namespace App\Http\Controllers;

use App\Models\ExcelData;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    // Search
    public function search(Request $request)
{
    $searchTerm = $request->input('searchTerm');

    if ($searchTerm) {
        $results = ExcelData::where(function ($query) use ($searchTerm) {
            $query->where('company_name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('phone', 'like', '%' . $searchTerm . '%')
                  ->orWhere('email', 'like', '%' . $searchTerm . '%')
                  ->orWhere('company_rep1', 'like', '%' . $searchTerm . '%')
                  ->orWhere('business_address', 'like', '%' . $searchTerm . '%')
                  ->orWhere('business_city', 'like', '%' . $searchTerm . '%')
                  ->orWhere('business_state', 'like', '%' . $searchTerm . '%')
                  ->orWhere('business_zip', 'like', '%' . $searchTerm . '%')
                  ->orWhere('dot', 'like', '%' . $searchTerm . '%')
                  ->orWhere('mc_docket', 'like', '%' . $searchTerm . '%');
        })->where('click_id',null)->where('status','not_forwarded')->get();
    } else {
        $results = [];
    }

    return response()->json($results);
}

    public function searchData($id){
        $data=ExcelData::find($id);
        return view('backend.leads.search_leads',compact('data'));

    }
}
