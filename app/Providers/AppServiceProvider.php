<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;
use App\Models\Goal;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();

        // ✅ Send latest goal to admin.index automatically
        View::composer('admin.index', function ($view) {
            $view->with('latestGoal', Goal::latest()->first());
        });

        // ✅ Agent Sidebar Notification Counts (GLOBAL)
    View::composer('Agent.common.sidebar', function ($view) {

    $agentId = session('agent_id');

    $verifiedNotificationCount = 0;
    $pipelineNotificationCount = 0;

    if ($agentId) {

        $user = DB::table('users')->where('id', $agentId)->first();

      // ✅ VERIFIED – only NEW after last_seen
$verifiedNotificationCount = DB::table('excel_data')
    ->where('click_id', $agentId)
    ->where('form_status', 'Intrested')
    ->where(function ($q) use ($user) {
        if ($user->last_verified_seen) {
            $q->where('updated_at', '>', $user->last_verified_seen);
        }
    })
    ->count();

// ✅ PIPELINE – only NEW after last_seen
// ✅ PIPELINE – only NEW after last_seen
$pipelineNotificationCount = DB::table('excel_data')
    ->where('click_id', $agentId)
    ->where('form_status', 'Pipeline')
    ->where(function ($q) use ($user) {
        if ($user->last_pipeline_seen) {
            $q->where('updated_at', '>', $user->last_pipeline_seen);
        }
    })
    ->count();


    }

    $view->with(compact(
        'verifiedNotificationCount',
        'pipelineNotificationCount'
    ));
});



    }
}
