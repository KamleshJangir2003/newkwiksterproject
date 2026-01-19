<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Goal;
use App\adminmodel\ExcelData;


class GoalController extends Controller
{
  public function index()
{
    $latestGoal = Goal::latest()->first();

    // ✅ Correct model use (ExcelData, not Lead)
    $completedLeads = ExcelData::where('form_status', 'Intrested')->count();

    $targetValue = $latestGoal->target_value ?? 0;

    $progressPercent = $targetValue > 0
        ? round(($completedLeads / $targetValue) * 100)
        : 0;

    if ($progressPercent > 100) {
        $progressPercent = 100;
    }

    $totalMilestones = 10;
    $milestonesDone = $targetValue > 0
        ? min(10, round(($completedLeads / $targetValue) * 10))
        : 0;

    // ✅ Live transfers (Pipeline / Live leads)
    $liveTransfers = ExcelData::where('form_status', 'Live')->count();

    return view('admin.goals_target.goals', compact(
        'latestGoal',
        'completedLeads',
        'progressPercent',
        'totalMilestones',
        'milestonesDone',
        'liveTransfers'
    ));
}


    public function store(Request $request)
    {
        $request->validate([
            'target_month' => 'required',
            'target_value' => 'required|numeric',
            'notes' => 'nullable'
        ]);

        Goal::create([
            'target_month' => $request->target_month,
            'target_value' => $request->target_value,
            'notes' => $request->notes,
        ]);

        return back()->with('success', 'Goal saved successfully!');
    }
}
