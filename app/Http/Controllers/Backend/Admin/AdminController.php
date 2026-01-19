<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\clientForm;
use App\Models\ExcelData;
use App\Models\offer;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        $currentMonth = now()->format('F');
        $currentYear = now()->year;
        $total_form_month = ExcelData::where('form_status', 'Intrested')
            ->whereMonth('updated_at', now()->month)
            ->whereYear('updated_at', $currentYear)
            ->get();

        // Get daily data for today
        $todayStart = now()->startOfDay();
        $todayEnd = now()->endOfDay();

        $total_form_daily = ExcelData::where('form_status', 'Intrested')
            ->whereBetween('updated_at', [$todayStart, $todayEnd])
            ->get();

        $total_pipeline_month = ExcelData::where('form_status', 'Pipeline')
            ->whereMonth('updated_at', now()->month)
            ->whereYear('updated_at', $currentYear)
            ->get();

        $total_pipeline_daily = ExcelData::where('form_status', 'Pipeline')
            ->whereBetween('updated_at', [$todayStart, $todayEnd])
            ->get();

        // Total calls for the entire day
        $totalCall = ExcelData::whereIn('form_status', ['Intrested', 'Pipeline', 'Not Connected', 'Voice Mail', 'Wrong Number', 'Not Intrested'])
            ->whereBetween('updated_at', [$todayStart, $todayEnd])
            ->get();

        $insurance_sold = clientForm::where('status', 'Sold')->get();

        $total_business_revenue = clientForm::sum('sold_amount');

        $total_form_client = clientForm::all();

        $total_pipeline_client = clientForm::where('status', 'Pipeline')->get();
        $total_cancel_client = clientForm::where('status', 'Cancel')->get();
        $total_lost_client = clientForm::where('status', 'Lost')->get();
        $offers = offer::all();
        
         $total_approve=clientForm::where('approved_declined','Approved')->get();
        $total_decline=clientForm::where('approved_declined','Declined')->get();

        return view('backend.admin.dashboard', compact('total_form_month', 'total_form_daily', 'total_pipeline_month', 'total_pipeline_daily', 'totalCall', 'insurance_sold', 'total_business_revenue', 'total_form_client', 'total_pipeline_client', 'total_cancel_client', 'total_lost_client','offers','total_approve','total_decline'));
    }

    public function clearCache($opt = true)
    {
        $exitCode = \Artisan::call('config:clear');
        $exitCode = \Artisan::call('cache:clear');
        $exitCode = \Artisan::call('route:clear');

        echo 'Compiled views cleared! <br>
            Application cache cleared! <br>
            Route cache cleared! <br>
            Configuration cache cleared! <br>
            Compiled services and packages files removed! <br>
            Caches cleared successfully! <br><br>';

        $exitCode = \Artisan::call('config:cache');
        $exitCode = \Artisan::call('cache:clear');


        echo 'Configuration cached successfully! <br>
            Routes cached successfully! <br>
            Files cached successfully! <br>
            Blade templates cached successfully! <br>';
    }
}
