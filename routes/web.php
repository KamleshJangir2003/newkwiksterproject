<?php

use App\Http\Controllers\Backend\Admin\AdminController;
use App\Http\Controllers\Backend\Agent\AgentController;
use App\Http\Controllers\Backend\Client\ClientController;
use App\Http\Controllers\Backend\Manager\ManagerController;
use App\Http\Controllers\Backend\Other\AttendanceController;
use App\Http\Controllers\Backend\Other\BreakController;
use App\Http\Controllers\Backend\Other\CommentController;
use App\Http\Controllers\Backend\Other\ForwardController;
use App\Http\Controllers\Backend\Other\MasterFileController;
use App\Http\Controllers\Backend\Other\DndController;
use App\Http\Controllers\Backend\Other\UtilityController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\Attendencecontroller;
use App\Http\Controllers\Admin\Ajentcontroller;
use App\Http\Controllers\Admin\Leadcontroller;
use App\Http\Controllers\Admin\loadformscontroller;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ContactUsController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\Morecontroller;
use App\Http\Controllers\Admin\chatboxcontroller;
use App\Http\Controllers\Admin\Samedaycontroller;
use App\Http\Controllers\Admin\Adbreakcontroller;
use App\Http\Controllers\Auth\adminlogincontroller;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Agent\dashboard_agentcontroller;
use App\Http\Controllers\Agent\agentleadcontroller;
use App\Http\Controllers\Agent\Scriptcontroller;
use App\Http\Controllers\Agent\chatcontroller;
use App\Http\Controllers\Agent\agent_attendancecontroller;
use App\Http\Controllers\Agent\agentbreakcontroller;
use App\Http\Controllers\forms\multiformscontroller;
use App\Http\Controllers\forms\loadformcontroller;
use Carbon\Carbon;
use App\adminmodel\ExcelData;
use App\Http\Controllers\Admin\GoalController;



// Route::get('/cleanup-unused-exceldata', function () {
//     $startOfCurrentMonth = Carbon::now()->startOfMonth(); // e.g., "2025-05-01 00:00:00"
    
//     // Delete older records (before current month) with unwanted statuses
//     $deletedCount = ExcelData::where('created_at', '<', $startOfCurrentMonth)
//         ->whereNotIn('form_status', ['Intrested', 'Pipeline'])
//         ->delete();
    
//     return response()->json([
//         'message' => "$deletedCount old records (non-Interested/Pipeline) deleted. Current month data preserved."
//     ]);
// });


Route::get('/config-cache', function () {
    Artisan::call('config:clear');
    return "Configuration config clear cleared deepak and rebuilt successfully!";
});
Route::fallback(function () {
    return response()->view('error', [], 404);
});

Route::get('/send-notification', [Leadcontroller::class, 'sendNotificationToUser']);

//===============================================Forms=============================================
Route::get('/kdausalogistics',[multiformscontroller::class,'page_one_view'])->name('view_page_one');
Route::get('/kdausaloogistics',[multiformscontroller::class,'page_two_view'])->name('view_page_two');
Route::get('/kdausalooogistics/{id?}',[multiformscontroller::class,'page_three_view'])->name('view_page_three');
Route::post('/view/page/three/store/{id?}',[multiformscontroller::class,'page_three_store'])->name('page_three_store');
Route::get('/view/thankyou',[multiformscontroller::class,'view_thankyou'])->name('view_thankyou');
Route::post('/view/page/two/store', [multiformscontroller::class, 'page_two_store'])->name('page_two_store');

//=============================================Frontend=============================================
Route::get('/',[HomeController::class,'index'])->name('home');
Route::post('/popup_store',[HomeController::class,'popup_store'])->name('popup_store');
Route::get('/onlinerater',[HomeController::class,'onlinerater'])->name('onlinerater');
Route::get('/load',[HomeController::class,'load'])->name('load');
Route::get('payment',[HomeController::class,'payment'])->name('payment');
Route::get('trucking-insurance-quote',[HomeController::class,'trucking'])->name('trucking');
Route::get('workers-compensation-quote',[HomeController::class,'compensation'])->name('compensation');
Route::get('general-liability-quote',[HomeController::class,'liability'])->name('liability');
Route::get('insurance-bond-quote',[HomeController::class,'bond'])->name('bond');
Route::get('proofinsurance',[HomeController::class,'proofinsurance'])->name('proofinsurance');
Route::get('freeconsultation',[HomeController::class,'freeconsultation'])->name('freeconsultation');
Route::get('truckinginsurance',[HomeController::class,'truckinginsurance'])->name('truckinginsurance');
Route::get('liabilityinsurance',[HomeController::class,'liabilityinsurance'])->name('liabilityinsurance');
Route::get('autoinsurancequote',[HomeController::class,'autoinsurancequote'])->name('autoinsurancequote');
Route::get('autoinsurance',[HomeController::class,'autoinsurance'])->name('autoinsurance');
Route::get('bondinsurance',[HomeController::class,'bondinsurance'])->name('bondinsurance');
Route::get('about',[HomeController::class,'about'])->name('about');
Route::get('privacy-policy',[HomeController::class,'privacypolicy'])->name('privacypolicy');
Route::get('terms-and-conditions',[HomeController::class,'tc'])->name('tc');
Route::get('carrier-insurance',[HomeController::class,'carrierinsurance'])->name('carrierinsurance');
Route::get('refer-to-friend',[HomeController::class,'refer'])->name('refer');
Route::get('contact',[HomeController::class,'contact'])->name('contact');
Route::get('quotes',[HomeController::class,'quotes'])->name('quotes');
Route::get('service',[HomeController::class,'service'])->name('service');
Route::get('insurance',[HomeController::class,'insurance'])->name('insurance');
Route::get('workers-compensation',[HomeController::class,'workerscompensation'])->name('workerscompensation');
Route::get('agency-gallery',[HomeController::class,'agencygallery'])->name('agencygallery');
Route::get('/generate-sitemap', [HomeController::class, 'generateSitemap']);
Route::post('contact-mail',[FormController::class,'contactmail'])->name('contactmail');
Route::post('trucking-mail',[FormController::class,'truckingmail'])->name('truckingmail');
Route::post('trucking-insurance-quote',[FormController::class,'truckingquote'])->name('truckingquote');
Route::post('workers-compensation-quote',[FormController::class,'workercomp'])->name('workercomp');
Route::post('general-liability-quote',[FormController::class,'general'])->name('general');
Route::post('insurance-bond-quote',[FormController::class,'bondquote'])->name('bondquote');
Route::post('refer-friend-quote',[FormController::class,'referfriend'])->name('referfriend');
Route::post('auto-insurance-quote',[FormController::class,'autoform'])->name('autoform');
Route::post('/trucking-insurance',[FormController::class,'truckingForm'])->name('truckingForm');

//=========================================== Ajent =====================================================

Route::group(['prefix' => 'agent'], function () {
    Route::group(['middleware'=>'agent.guest'],function(){

        Route::get('/Agent/login', [adminlogincontroller::class, 'ajent_login'])->name('ajent_login');
        Route::post('/agent/login_process', [adminlogincontroller::class, 'ajent_login_process'])->name('ajent_login_process');

    });
    Route::group(['middleware'=>'agent.auth'],function(){

        Route::get('/agent_dashboard', [dashboard_agentcontroller::class, 'agent_dashboard'])->name('agent_dashboard');
        Route::get('/agent_logout', [adminlogincontroller::class, 'agent_logout'])->name('agent_logout');
        Route::get('/agent_time_logout', [adminlogincontroller::class, 'agent_time_logout'])->name('agent_time_logout');
        Route::get('/agent_change_pass', [adminlogincontroller::class, 'agent_change_pass'])->name('agent_change_pass');
        Route::post('/agent_change_password', [adminlogincontroller::class, 'agent_change_password'])->name('agent_change_password');
        Route::post('/agent/updatemode', [dashboard_agentcontroller::class, 'updateUser_modes'])->name('updateUser_modes');
        Route::post('/agent/search_all', [dashboard_agentcontroller::class, 'agent_global_search'])->name('agent_global_search');
        Route::post('/agent/update_profile', [dashboard_agentcontroller::class, 'update_profile_pic'])->name('update_profile_pic');
        Route::get('/agent/clear_notification', [dashboard_agentcontroller::class, 'clear_notifications'])->name('clear_notifications');
        Route::get('/agent/comming_soon', [dashboard_agentcontroller::class, 'comming_soon'])->name('comming_soon');
        //---------------------profile-----------------------------------------
        Route::get('/agent_profile', [adminlogincontroller::class, 'agent_profile'])->name('agent_profile');

        //------------------- leads ----------------------------------------
        Route::get('/agent_incoming/leads/{n?}', [agentleadcontroller::class, 'agent_incoming_leads'])->name('agent_incoming_leads');
        Route::get('/agent_view_data/leads/{id}', [agentleadcontroller::class, 'agent_view_data'])->name('agent_view_data');
                Route::get('/viewdatatimezone/{timezone}/{id}', [AgentLeadController::class, 'viewDataTimezone'])->name('viewDataTimezone');
        Route::post('/agent_status_update/leads/', [agentleadcontroller::class, 'agent_status_update'])->name('agent_status_update');
        Route::post('/agent_mailstatus_update/leads/', [agentleadcontroller::class, 'agent_mailstatus_update'])->name('agent_mailstatus_update');
        Route::post('/agent_singleleads', [agentleadcontroller::class, 'storeSingleData'])->name('storeSingleData');
        Route::post('/agent_leads_update', [agentleadcontroller::class, 'updateData'])->name('agent_update_leads');
        Route::get('/agent/intersted/view', [agentleadcontroller::class, 'agent_intersted_data'])->name('agent_intersted_data');
        Route::get('/agent/pipeline/view/{n?}', [agentleadcontroller::class, 'agent_pipeline_data'])->name('agent_pipeline_data');
        Route::get('/agent/won/view', [agentleadcontroller::class, 'agent_won_data'])->name('agent_won_data');
        Route::get('/agent/voicemail/view', [agentleadcontroller::class, 'agent_voicemail_data'])->name('agent_voicemail_data');
        Route::get('/agent/search/view{id?}/{n?}', [agentleadcontroller::class, 'agent_search_data'])->name('agent_search_data');
        Route::post('/agent_reminder_noti', [agentleadcontroller::class, 'reminder_notif'])->name('agent_reminder_notif');
         Route::post('/agent_email_form', [agentleadcontroller::class, 'agent_email_form'])->name('agent_email_form');
         Route::get('/show_email_inrsted', [agentleadcontroller::class, 'show_email_inrsted'])->name('show_email_inrsted');
        Route::get('/view_lead_history/{id}', [agentleadcontroller::class, 'view_lead_history'])->name('view_lead_history');
        
        //----------------------------------auto forward ---------------------------------------
Route::get('/add_auto_forward', [Leadcontroller::class, 'add_auto_forward'])->name('add_auto_forward');
Route::post('/store_auto_forward', [Leadcontroller::class, 'store_auto_forward'])->name('store_auto_forward');
Route::get('/forward-change-status/{team}', [Leadcontroller::class, 'changeStatusforward'])->name('changeStatusforward');


          //---------------------------------- Verified ---------------------------------------
        Route::get('/verified_agent_manage', [agentleadcontroller::class, 'verified_agent_manage'])->name('verified_agent_manage');
        Route::get('/leads/getVerifiedLeadsagent', [agentleadcontroller::class, 'getVerifiedLeadsagent'])->name('leads.getVerifiedLeadsagent');
        Route::get('/getLeadByIdagent/{id?}', [agentleadcontroller::class, 'getLeadByIdagent'])->name('getLeadByIdagent');






        //--------------------------------script-----------------------------------------
        Route::get('/agent/submit_report', [Scriptcontroller::class, 'Submit_daily_report'])->name('Submit_daily_report');
        Route::get('/agent/attendence', [Scriptcontroller::class, 'attendence'])->name('attendence');
        Route::get('/agent/passcode/{n?}', [Scriptcontroller::class, 'passcode'])->name('passcode');
        Route::post('/agent/passcodestore', [Scriptcontroller::class, 'passcodestore'])->name('passcodestore');
        Route::get('/agent/clear-passcode', function () {
            session()->put('agent_passcode',2);
            return response()->json(['message' => 'Passcode cleared']);
        })->name('clearpasscode');
        Route::get('/agent/Todo', [Scriptcontroller::class, 'todo'])->name('todo');
        Route::get('/agent/getTodo', [Scriptcontroller::class, 'get_todo'])->name('get_todo');
        Route::post('/agent/store_Todo', [Scriptcontroller::class, 'store_todo'])->name('store_todo');
        Route::post('/agent/delete_Todo', [Scriptcontroller::class, 'delete_todo'])->name('delete_todo');
        Route::post('/agent/store_mynotes', [Scriptcontroller::class, 'store_mynotes'])->name('agent.store_mynotes');
        Route::post('/agent/store_docs', [Scriptcontroller::class, 'update_identety_ajent'])->name('agent.update_identety_ajent');

        //------------------------------ Submit form =--------------------------------------------
        Route::get('/agent/submit_form', [Scriptcontroller::class, 'submit_form'])->name('submit_form');
        Route::get('/agent/email_script', [Scriptcontroller::class, 'email_script'])->name('agent.email_script');
        Route::get('/agent/text_script', [Scriptcontroller::class, 'text_script'])->name('agent.text_script');
        Route::get('/agent/call_script', [Scriptcontroller::class, 'call_script'])->name('agent.call_script');
        Route::get('/agent/credential', [Scriptcontroller::class, 'credential'])->name('agent.credential');
        Route::post('/agent/store_submit_form', [Scriptcontroller::class, 'store_submit_form'])->name('store_submit_form');
        Route::post('/agent/store_all_script', [Scriptcontroller::class, 'store_script'])->name('store_all_script');
        Route::post('/agent/store_notes_script', [Scriptcontroller::class, 'store_notes'])->name('store_notes_script');
        Route::post('/agent/store_credential', [Scriptcontroller::class, 'store_credential'])->name('agent.store_credential');
        Route::get('/agent/training_material', [Scriptcontroller::class, 'training_material'])->name('agent.training_material');
           Route::get('/agent/req_data', [Scriptcontroller::class, 'req_data'])->name('agent.req_data');

        //-------------------------------------leavs--------------------------------------------------------------
        Route::post('/agent/store_leaves', [Scriptcontroller::class, 'agent_store_leaves'])->name('agent.store_leaves');
        Route::get('/agent/calculateSalary', [Scriptcontroller::class, 'calculateSalary'])->name('agent.calculateSalary');
         Route::get('/agent/view_intrested_load', [Scriptcontroller::class, 'view_load'])->name('agent.intrested.view_load');

        //----------------------------------- Chat box-------------------------------------------------------------
        Route::get('/agent/chat_box', [chatcontroller::class, 'agent_chat'])->name('agent_chat');
        Route::post('/send-message', [chatcontroller::class, 'sendMessage'])->name('send.message');
        Route::post('/create_group', [chatcontroller::class, 'create_group'])->name('create_group');
        Route::post('/edit_group', [chatcontroller::class, 'edit_group'])->name('edit_group');
        Route::get('/delete_group/{id}', [chatcontroller::class, 'delete_group'])->name('delete_group');
        Route::get('/delete_message/{id}', [chatcontroller::class, 'delete_message'])->name('delete_message');
        Route::post('/forward_message/{id?}', [chatcontroller::class, 'forward_message'])->name('forward_message');
        Route::post('/seen_message', [chatcontroller::class, 'chat_read_status'])->name('chat_read_status');
           //-------------------------------------- Attendance----------------------------------------------------------
        Route::get('/view_calender', [agent_attendancecontroller::class, 'agent_view_calender'])->name('agent_view_calender');
        Route::post('/agent_get_attendance', [agent_attendancecontroller::class, 'agent_get_attendance'])->name('agent_get_attendance');
        Route::get('/agent/attendence', [agent_attendancecontroller::class, 'attendence'])->name('attendence');
        
                //---------------------------------------Breaks--------------------------------------------------
        Route::get('/agent_break', [agentbreakcontroller::class, 'agent_break'])->name('agent_break');
        Route::post('/complete_break_process', [agentbreakcontroller::class, 'complete_break_process'])->name('complete_break_process');
        Route::post('/start_break_process', [agentbreakcontroller::class, 'start_break'])->name('start_break');
                Route::get('/view_agent_task', [agentbreakcontroller::class, 'view_agent_task'])->name('view_agent_task');
        Route::get('/statu_agent_task/{idd}', [agentbreakcontroller::class, 'statu_agent_task'])->name('statu_agent_task');

        //---------------------------------------loads leads--------------------------------------------------
        Route::get('/view_load', [loadcontroller::class, 'view_load'])->name('view_load');
        Route::get('/delete_load_leads/{id}', [loadcontroller::class, 'delete_load_leads'])->name('delete_load_leads');
        Route::post('/store_load_lead', [loadcontroller::class, 'store_load_lead'])->name('store_load_lead');






    });


});

//======================================= ADMIN ===================================================
Route::group(['prefix' => 'admin'], function () {
    Route::group(['middleware'=>'admin.guest'],function(){

        Route::get('/login', [adminlogincontroller::class, 'admin_login'])->name('admin_login');
        Route::post('/login_process', [adminlogincontroller::class, 'admin_login_process'])->name('admin_login_process');

    });
Route::group(['middleware'=>'admin.auth'],function(){

 Route::get('/index', [TeamController::class, 'admin_index'])->name('admin_index');
 Route::get('/logout', [adminlogincontroller::class, 'admin_logout'])->name('admin_logout');
 Route::get('/profile', [adminlogincontroller::class, 'admin_profile'])->name('admin_profile');
 Route::get('/view_change_password', [adminlogincontroller::class, 'admin_change_pass_view'])->name('view_change_password');
 Route::post('/admin_change_password', [adminlogincontroller::class, 'admin_change_password'])->name('admin_change_password');

// ---------------------Admin Team ------------------------

Route::get('/view_team', [TeamController::class, 'view_team'])->name('view_team');
Route::get('/add_team_view', [TeamController::class, 'add_team_view'])->name('add_team_view');
Route::post('/add_team_process', [TeamController::class, 'add_team_process'])->name('add_team_process');
Route::get('/UpdateTeamStatus/{status}/{id}', [TeamController::class, 'UpdateTeamStatus'])->name('UpdateTeamStatus');
Route::get('/deleteTeam/{id}', [TeamController::class, 'deleteTeam'])->name('deleteTeam');
Route::get('/update_team/{id}', [TeamController::class, 'update_team'])->name('update_team');
Route::post('/update_team_process', [TeamController::class, 'update_team_process'])->name('update_team_process');
Route::post('/update_current_process', [TeamController::class, 'update_current_process'])->name('update_current_process');
Route::post('/update_identety_process', [TeamController::class, 'update_identety_process'])->name('update_identety_process');
Route::post('/update_salary_process', [TeamController::class, 'update_salary_process'])->name('update_salary_process');
Route::get('/editTeam/{id}', [TeamController::class, 'edit_team'])->name('edit_team');
Route::post('/edit_store/{id}', [TeamController::class, 'edit_store'])->name('edit_store');

//=================================manager team ===================================
Route::get('/add_manager_team', [TeamController::class, 'add_manager_team'])->name('add_manager_team');
Route::get('/view_manager_team', [TeamController::class, 'view_manager_team'])->name('view_manager_team');
Route::get('/edit_manager_team/{id}', [TeamController::class, 'edit_manager_team'])->name('edit_manager_team');
Route::post('/addmanager_team_process', [TeamController::class, 'addmanager_team_process'])->name('addmanager_team_process');
Route::post('/editmanagerteam_store/{id}', [TeamController::class, 'editmanagerteam_store'])->name('editmanagerteam_store');
Route::get('/deletemanagerteam/{id}', [TeamController::class, 'deletemanagerteam'])->name('deletemanagerteam');



//---------------------------- Ajent ------------------------------

Route::get('/view_ajent', [Ajentcontroller::class, 'view_ajent'])->name('view_ajent');
Route::get('/add_ajent_view', [Ajentcontroller::class, 'add_ajent_view'])->name('add_ajent_view');
Route::post('/add_ajent_process', [Ajentcontroller::class, 'add_ajent_process'])->name('add_ajent_process');
Route::get('/UpdateajentStatus/{status}/{id}', [Ajentcontroller::class, 'UpdateajentStatus'])->name('UpdateajentStatus');
Route::get('/deleteajent/{id}', [Ajentcontroller::class, 'deleteajent'])->name('deleteajent');
Route::get('/update_ajent/{id}', [Ajentcontroller::class, 'update_ajent'])->name('update_ajent');
Route::post('/update_ajent_process', [Ajentcontroller::class, 'update_ajent_process'])->name('update_ajent_process');
Route::post('/update_current_ajent', [Ajentcontroller::class, 'update_current_ajent'])->name('update_current_ajent');
Route::post('/update_identety_ajent', [Ajentcontroller::class, 'update_identety_ajent'])->name('update_identety_ajent');
Route::post('/update_salary_ajent', [Ajentcontroller::class, 'update_salary_ajent'])->name('update_salary_ajent');
Route::post('/update_bank_ajent', [Ajentcontroller::class, 'update_bank_ajent'])->name('update_bank_ajent');
Route::get('/editAgent/{id}', [Ajentcontroller::class, 'edit_agent'])->name('edit_agent');
Route::post('/editAgent_store/{id}', [Ajentcontroller::class, 'edit_agent_store'])->name('edit_agent_store');

//---------------------------------- Leads ------------------------------------------------
Route::get('/all_lead',[Leadcontroller::class, 'all_lead'])->name('all_lead');
Route::get('/all_tab_view',[Leadcontroller::class, 'all_tab_view'])->name('all_tab_view');
Route::get('/all_tab_view_data/{id}/{batch}',[Leadcontroller::class, 'all_tab_view_data'])->name('all_tab_view_data');
Route::get('/import_leads',[Leadcontroller::class, 'import_leads'])->name('import_leads');
Route::get('/delete_lead/{id}', [Leadcontroller::class, 'delete_lead'])->name('delete_lead');
Route::get('/update_lead_status/{id}/{status}', [Leadcontroller::class, 'update_lead_status'])->name('update_lead_status');
Route::post('/import', [ExcelController::class, 'import'])->name('import');
Route::get('/delete_duplicate/leads', [Leadcontroller::class, 'deleteDuplicateEntry'])->name('deleteDuplicateEntry');
Route::get('/deleteDuplicateEntryBatch/{batch}', [Leadcontroller::class, 'deleteDuplicateEntryBatch'])->name('deleteDuplicateEntryBatch');
Route::get('/deleteAllbatchData/{batch}', [Leadcontroller::class, 'deleteAllbatchData'])->name('deleteAllbatchData');
Route::get('/delete_dnd_batch/{batch}', [Leadcontroller::class, 'deleteDNDEntryBatch'])->name('deleteDNDEntryBatch');
Route::post('/forword/leads', [Leadcontroller::class, 'forword_leads'])->name('forword_leads');
Route::post('/bluck_delete/leads', [Leadcontroller::class, 'bluckdelete'])->name('bluckdelete');
Route::get('/assigned/leads', [Leadcontroller::class, 'assigned_leads'])->name('assigned_leads');
Route::get('/assigned/leads_view', [Leadcontroller::class, 'assigned_leads_view'])->name('assigned_leads_view');
Route::get('/assigned/leads_delete/{id}', [Leadcontroller::class, 'assigned_leads_delete'])->name('assigned_leads_delete');
Route::post('/intrested_check/leads', [Leadcontroller::class, 'intrested_check'])->name('intrested_check');
Route::post('/bluck_delete_assign', [Leadcontroller::class, 'bluck_delete_assign'])->name('bluck_delete_assign');
Route::get('/deleteoldintrested', [Leadcontroller::class, 'deleteoldintrested'])->name('deleteoldintrested');
Route::get('/admin_global_search/{id}', [Leadcontroller::class, 'admin_global_search'])->name('admin_global_search');
Route::get('/view_lead_details/{id}', [Leadcontroller::class, 'view_lead_details'])->name('view_lead_details');

//---------------------------------- Verified ---------------------------------------
Route::get('/verified_lead_manage', [Leadcontroller::class, 'verified_lead_manage'])->name('verified_lead_manage');
Route::get('/leads/verified', [LeadController::class, 'getVerifiedLeads'])->name('leads.verified');
Route::post('/leads/update-status', [LeadController::class, 'updateLeadStatus'])->name('leads.update-status');
Route::get('/leads/{id?}', [LeadController::class, 'getLeadById'])->name('getLeadById');




//-------------------------------- discompostion---------------------------------------------
Route::get('/intersted/leads/{data?}/{n?}', [Leadcontroller::class, 'interstedleads'])->name('interstedleads');
Route::get('/newintersted/leads/{data?}/{n?}', [Leadcontroller::class, 'newinterstedleads'])->name('newinterstedleads');
Route::get('/Pipeline/leads', [Leadcontroller::class, 'Pipelineleads'])->name('Pipelineleads');
Route::get('/VoiceMail/leads', [Leadcontroller::class, 'VoiceMailleads'])->name('VoiceMailleads');
Route::get('/WrongNumber/leads', [Leadcontroller::class, 'WrongNumberleads'])->name('WrongNumberleads');
Route::get('/NotInterested/leads', [Leadcontroller::class, 'NotInterestedleads'])->name('NotInterestedleads');
Route::get('/NotConnected/leads', [Leadcontroller::class, 'NotConnectedleads'])->name('NotConnectedleads');
Route::get('/InsuredLeads/leads', [Leadcontroller::class, 'InsuredLeadsleads'])->name('InsuredLeadsleads');
Route::get('/WON/leads', [Leadcontroller::class, 'WONleads'])->name('WONleads');
Route::get('/DND/leads', [Leadcontroller::class, 'DNDleads'])->name('DNDleads');
Route::get('/coverwhale/leads', [Leadcontroller::class, 'coverwhaleleads'])->name('coverwhaleleads');
Route::get('/Submitedforms/leads', [Leadcontroller::class, 'Submitedforms'])->name('Submitedforms');
Route::post('/submitformstore/leads', [Leadcontroller::class, 'submitformstore'])->name('submitformstore');
Route::get('/Download/intersted/{date1?}/{date2?}', [Leadcontroller::class, 'instersted_download'])->name('instersted_download');

Route::get('/first_level/leads/{data?}/{n?}', [Leadcontroller::class, 'level_first'])->name('level_first');
Route::get('/second_level/leads/{data?}/{n?}', [Leadcontroller::class, 'second_level'])->name('second_level');
Route::get('/view_email_intrestred', [Leadcontroller::class, 'view_email_intrestred'])->name('view_email_intrestred');
Route::get('/update_emailintre_status/{id?}/{status?}', [Leadcontroller::class, 'update_emailintre_status'])->name('update_emailintre_status');
Route::get('/delete_emailintre/{id?}/', [Leadcontroller::class, 'delete_emailintre'])->name('delete_emailintre');
//---------------------------------- forward ---------------------------------------
Route::get('/add_auto_forward', [Leadcontroller::class, 'add_auto_forward'])->name('add_auto_forward');
Route::post('/store_auto_forward', [Leadcontroller::class, 'store_auto_forward'])->name('store_auto_forward');
Route::get('/forward-change-status/{team}', [Leadcontroller::class, 'changeStatusforward'])->name('changeStatusforward');


Route::get('/dashboard_intrested/{id?}/', [Leadcontroller::class, 'dashboard_intrested'])->name('dashboard_intrested');
Route::get('/remove_intrested/{id?}/{user?}', [Leadcontroller::class, 'remove_intrested'])->name('remove_intrested');




//---------------------------------- More ---------------------------------------
Route::get('/email_script',[Morecontroller::class, 'email_script'])->name('email_script');
Route::get('/calling_script',[Morecontroller::class, 'calling_script'])->name('calling_script');
Route::get('/text_script',[Morecontroller::class, 'text_script'])->name('text_script');
Route::get('/my_note',[Morecontroller::class, 'my_note'])->name('my_note');
Route::post('/store_script',[Morecontroller::class, 'store_script'])->name('store_script');
Route::get('/credentials',[Morecontroller::class, 'credentials'])->name('credentials');
Route::get('/delete_credentials/{id}',[Morecontroller::class, 'delete_credentials'])->name('delete_credentials');
Route::post('/store_credentials',[Morecontroller::class, 'store_credentials'])->name('store_credentials');
Route::post('/store_bonus',[Morecontroller::class, 'store_bonus'])->name('store_bonus');
Route::get('/submit_report',[Morecontroller::class, 'view_submint_report'])->name('view_submint_report');


//-------------------------------- calander -----------------------------------
Route::get('/Training_metarial',[Morecontroller::class, 'Training_metarial'])->name('Training_metarial');
Route::post('/store_Training_metarial',[Morecontroller::class, 'store_Training_metarial'])->name('store_Training_metarial');
Route::get('/delete_Training_metarial/{id?}',[Morecontroller::class, 'delete_Training_metarial'])->name('delete_Training_metarial');
Route::get('/view_form_submit',[Morecontroller::class, 'view_form_submit'])->name('view_form_submit');

//---------------------------------- Attendence ------------------------------------------------
Route::get('/admin/view_holidays',[Attendencecontroller::class, 'view_holidays'])->name('view_holidays');
Route::get('/admin/view_calender',[Attendencecontroller::class, 'view_calender'])->name('view_calender');
Route::post('/admin/store_holidays',[Attendencecontroller::class, 'store_holidays'])->name('store_holidays');
Route::get('/admin/delete_holidays/{id}',[Attendencecontroller::class, 'delete_holidays'])->name('delete_holidays');
Route::get('/admin/time_credit',[Attendencecontroller::class, 'view_time_credit'])->name('view_time_credit');
Route::post('/admin/store_time_credit',[Attendencecontroller::class, 'store_time_credit'])->name('store_time_credit');
Route::get('/admin/delete_time_credit/{id}',[Attendencecontroller::class, 'delete_time_credit'])->name('delete_time_credit');

Route::get('/admin/leave_request/{n?}',[Attendencecontroller::class, 'view_leave_request'])->name('admin.view_leave_request');
Route::get('/admin/leave_request_status/{id?}/{status}',[Attendencecontroller::class, 'leave_request_status'])->name('leave_request_status');

Route::post('/get_attendance',[Attendencecontroller::class, 'get_attendance'])->name('get_attendance');
Route::post('/get_attendence_count',[Attendencecontroller::class, 'get_attendence_count'])->name('get_attendence_count');
Route::post('/update_attendence_calender',[Attendencecontroller::class, 'update_attendence_calender'])->name('update_attendence_calender');
Route::post('/store_salary_cycle',[Attendencecontroller::class, 'store_salary_cycle'])->name('store_salary_cycle');
Route::post('/edit_salary_datas',[Attendencecontroller::class, 'edit_salary_datas'])->name('edit_salary_datas');
 //----------------------------------- Chat box-------------------------------------------------------------
 Route::get('/chat_box', [chatboxcontroller::class, 'agent_chat'])->name('admin_chat');
 Route::get('/admin/chat_box/load-chat/{id}', [chatboxcontroller::class, 'loadChat']);
 Route::post('/send-message', [chatboxcontroller::class, 'sendMessage'])->name('admin_sendmessage');
 Route::post('/create_group', [chatboxcontroller::class, 'create_group'])->name('admin_create_group');
 Route::post('/edit_group', [chatboxcontroller::class, 'edit_group'])->name('admin_edit_group');
 Route::get('/delete_group/{id}', [chatboxcontroller::class, 'delete_group'])->name('admin_delete_group');
 Route::get('/delete_message/{id}', [chatboxcontroller::class, 'delete_message'])->name('admin_delete_message');
 Route::post('/forward_message/{id?}', [chatboxcontroller::class, 'forward_message'])->name('admin_forward_message');
  Route::post('/read_maerk_message', [chatboxcontroller::class, 'read_mark'])->name('read_mark');
  
   //-----------------------------------------------break----------------------------------------------------------
 Route::get('/add_break', [Adbreakcontroller::class, 'add_break_view'])->name('add_break_view');
 Route::get('/break_view', [Adbreakcontroller::class, 'break_view'])->name('break_view');
 Route::get('/active_break', [Adbreakcontroller::class, 'active_break'])->name('active_break');
 Route::get('/daily_record_break', [Adbreakcontroller::class, 'daily_record_break'])->name('daily_record_break');
 Route::post('/add_break_process', [Adbreakcontroller::class, 'add_break_process'])->name('add_break_process');
 Route::get('/UpdatebreakStatus/{status}/{id}', [Adbreakcontroller::class, 'UpdatebreakStatus'])->name('UpdatebreakStatus');
 Route::get('/deletebreak/{id}', [Adbreakcontroller::class, 'deletebreak'])->name('deletebreak');
  Route::post('/updatetask', [Adbreakcontroller::class, 'updatetask'])->name('updatetask');
    //----------------------------------- Task-------------------------------------------------------------
  Route::get('/viewsave_task', [Adbreakcontroller::class, 'viewsave_task'])->name('viewsave_task');
  Route::post('/store_task', [Adbreakcontroller::class, 'task_store'])->name('store_task');
  Route::get('/viewgived_task', [Adbreakcontroller::class, 'viewgived_task'])->name('viewgived_task');
  Route::get('/viewmy_task', [Adbreakcontroller::class, 'viewmy_task'])->name('viewmy_task');
  Route::get('/delete_task/{idd}', [Adbreakcontroller::class, 'delete_task'])->name('delete_task');
   //----------------------------------- Information-------------------------------------------------------------
 Route::get('/view_information', [Adbreakcontroller::class, 'view_information'])->name('view_information');
 Route::post('/store_information', [Adbreakcontroller::class, 'store_information'])->name('store_information');
 Route::get('/Updateinformation/{status}/{id}', [Adbreakcontroller::class, 'Updateinformation'])->name('Updateinformation');
  Route::get('/view_all_attendance/{id}', [Adbreakcontroller::class, 'view_all_attendance'])->name('view_all_attendance');

 
  //----------------------------------- Load forms-------------------------------------------------------------
 Route::get('/view_load_forms', [loadformscontroller::class, 'view_load_forms'])->name('view_load_forms');
  Route::get('/delete_load_forms/{id}', [loadformscontroller::class, 'delete_load_forms'])->name('delete_load_forms');
 Route::get('/delete_load_docs/{id}', [loadformscontroller::class, 'delete_load_docs'])->name('delete_load_docs');
  Route::post('/update-comment_load_forms', [loadformscontroller::class, 'comment_load_forms'])->name('comment_load_forms');
  Route::get('/view_load_docs', [loadformscontroller::class, 'view_load_docs'])->name('view_load_docs');
 Route::get('/view_load_pdfs/{id}', [loadformscontroller::class, 'view_load_pdfs'])->name('view_load_pdfs');
  Route::get('/update_agentid_load_forms/{id?}/{formid?}', [loadformscontroller::class, 'agentid_load_forms'])->name('agentid_load_forms');
   Route::get('/Update_loadform_Status/{status}/{id}', [loadformscontroller::class, 'Update_loadform_Status'])->name('Update_loadform_Status');
   //-----------------------------------Kwik Load forms-------------------------------------------------------------
  Route::get('/view_kwikload_forms', [loadformscontroller::class, 'view_kwikload_forms'])->name('view_kwikload_forms');
  Route::get('/view_kwikload_pdfs/{id}', [loadformscontroller::class, 'view_kwikload_pdfs'])->name('view_kwikload_pdfs');
   //-----------------------------------Kwik Load forms-------------------------------------------------------------
  Route::get('/view_sameday_forms', [Samedaycontroller::class, 'view_sameday_forms'])->name('view_sameday_forms');
  Route::get('/view_sameday_pdfs/{id}', [Samedaycontroller::class, 'view_sameday_pdfs'])->name('view_sameday_pdfs');

    });

});

//------------------------------same day loads--------------------------
Route::get('/same-day-loads', [Samedaycontroller::class, 'samedayload'])->name('samedayload');
Route::get('/same-day-link', [Samedaycontroller::class, 'samedayload_link'])->name('samedayload_link');
Route::post('/sameday_process', [Samedaycontroller::class, 'sameday_process'])->name('sameday_process');
Route::post('/agent/send-group-message', [chatcontroller::class, 'sendGroupMessage'])->name('agent_send_group_message');
Route::post('/agent/upload-profile', [adminlogincontroller::class, 'uploadAgentProfile'])
    ->name('agent.upload.profile');
Route::post('/admin/create-chat', [chatboxcontroller::class, 'createChat']);
//------------------------------goals--------------------------
Route::get('/goals-target', function () {
    return view('admin.goals_target.goals');
})->name('goals_target');

Route::get('/employees', function () {
    return view('admin.employees.index');
})->name('employees');
Route::get('/goals-target', [GoalController::class, 'index'])->name('goals_target');
Route::post('/save-goal', [GoalController::class, 'store'])->name('goal.store');

