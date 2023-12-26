<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BankController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\LeadController;
use App\Http\Controllers\Api\MailController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\SalesController;
//use App\Http\Controllers\Api\WhatsappController;
use App\Http\Controllers\Admin\LeadsController;
use App\Http\Controllers\Api\AutoDialController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\LeadViewController;
use App\Http\Controllers\Api\ContactUsController;
use App\Http\Controllers\Api\RuleMasterController;
use App\Http\Controllers\Api\PermissionsController;
use App\Http\Controllers\Api\RuleDetailsController;
use App\Http\Controllers\Api\SmsTemplateController;
use App\Http\Controllers\Api\SourceMasterController;
use App\Http\Controllers\Api\EmailTemplateController;
//use App\Http\Controllers\UserController;
use App\Http\Controllers\Api\PackageMasterController;
use App\Http\Controllers\Api\ProductMasterController;
use App\Http\Controllers\Api\TelemarketingController;
use App\Http\Controllers\Api\CompanyDetailsController;
use App\Http\Controllers\Api\LeadAssignMentController;
use App\Http\Controllers\Api\UserAssingmentController;
use App\Http\Controllers\Api\RazorpayPaymentController;
use App\Http\Controllers\Api\PushNotificationController;
use App\Http\Controllers\Api\WhatsappTemplateController;
use App\Http\Controllers\Api\DesignationMasterController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('register', [AuthController::class, 'createUser']);
Route::post('login', [AuthController::class, 'loginUser']);

//miidleware apply on route
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('roles_list',[RoleController::class,'roleList']);
   // Route::apiResource('users', UserController::class);
   
    Route::apiResource('roles', RoleController::class);
    Route::apiResource('permissions',PermissionsController::class);

    //nikita add telemarketing user display and lead view
    Route::post('users/display', [UserController::class,'display']);
    Route::apiResource('designation', DesignationMasterController::class);
    Route::apiResource('ruledetails', RuleDetailsController::class);
    Route::post('profile', [TelemarketingController::class, 'profile']);
    Route::post('lead-detail',[LeadViewController::class,'Leadview']);
    Route::apiResource('rules',RuleMasterController::class);
    Route::apiResource('lead-assign',LeadAssignMentController::class);
    Route::apiResource('package', PackageMasterController::class);
    Route::apiResource('userassingment', UserAssingmentController::class);
    Route::apiResource('leadview',LeadViewController::class);
    Route::get('leadstatus',[LeadViewController::class,'leadstatus']);
    Route::post('flag_update',[PushNotificationController::class,'flagUpdate']);
    Route::get('update_sales',[SalesController::class,'updatesale']);
    Route::get('sales_lead',[SalesController::class,'show']);
    Route::get('oppurtunity_lead',[LeadViewController::class ,'oppurtunityLead']);
    Route::get('login-status-update',[LeadViewController::class,'loginstatusupdate']);
    Route::apiResource('send-sms',SmsTemplateController::class);
    Route::post('whatsapp-template',[WhatsappTemplateController::class,'index']);
    Route::post('whatsapp-template-store',[WhatsappTemplateController::class,'store']);
    Route::post('whatsapp-template-show/{id}',[WhatsappTemplateController::class,'show']);
    Route::post('whatsapp-template-update/{id}',[WhatsappTemplateController::class,'update']);
    Route::apiResource('company_details',CompanyDetailsController::class);

    //api for dashboard

    Route::post('lead-sanction',[LeadViewController::class,'leadsanction']);
    Route::post('lead-rejected',[LeadViewController::class,'leadrejected']);
    Route::post('lead-login',[LeadViewController::class,'leadlogin']);
    Route::post('lead-disburse',[LeadViewController::class,'leaddisburse']);
    Route::post('dashboard-top-count',[LeadViewController::class,'dashboardTopCount']);

    Route::post('top-employee',[LeadViewController::class,'TopEmployees']);
    Route::post('count-summary',[LeadViewController::class,'dashboardCountSummary']);
    Route::post('dashboard-footer-count',[LeadViewController::class,'dashboardFooterCount']);

    Route::get('designation_master',[AuthController::class,'designationMaster']);
    Route::get('role_master',[AuthController::class,'roleMaster']);
    Route::get('reporting_master',[AuthController::class,'reportingMaster']);
    Route::post('team/add_update_team_user', [UserController::class,'addUpdateTeamUser']);
    Route::delete('team/users/{id}', [UserController::class,'destroy']);
    Route::post('lead-list',[LeadViewController::class,'index']);
    Route::get('leadview/{id}',[LeadViewController::class,'show']);
    Route::post('lead-reassignment',[LeadAssignMentController::class,'leadReassignment']);
    Route::post('get-all-reassignment-leads',[LeadAssignMentController::class,'getAllReassignmentLeads']);
    Route::post('multiple-lead-assign',[LeadAssignMentController::class,'multipleLeadAssign']);
    Route::post('lead-follow-up',[LeadAssignMentController::class,'leadFollowUp']);
    

    //api for Teams
    Route::post('show-users', [UserController::class,'index']);
    Route::post('team-view', [LeadViewController::class,'teamView']);
    Route::post('data-allocation-view', [LeadViewController::class,'dataAllocation']);
    Route::post('call-logs', [LeadViewController::class,'callLogs']);


    //api for sms and whatup
    Route::post('show-sms-template', [SmsTemplateController::class,'index']);
    Route::post('store-sms-template', [SmsTemplateController::class,'store']);
    Route::post('update-sms-template/{id}', [SmsTemplateController::class,'update']);

    //api for call log 
    Route::post('add-calllog-template', [LeadViewController::class,'index']);
    Route::post('show-calllog', [LeadViewController::class,'store']);
    Route::get('status-master',[LeadViewController::class,'statusMaster']);
    Route::post('lead-import',[LeadViewController::class,'leadImport'])->name('lead-import');
    

    // Bank Api 
    Route::get('bank_list', [BankController::class, 'index']);

    // Auto Dial Configuration Api
    Route::post('auto-dial-configuration-list', [AutoDialController::class, 'index']);
    Route::get('edit-auto-dial-configuration/{id}',[AutoDialController::class,'edit'])->name('edit');
    Route::post('add-auto-dial-configuration',[AutoDialController::class,'store'])->name('store');
    Route::post('update-auto-dial-configuration',[AutoDialController::class,'update'])->name('update');
    Route::get('delete-auto-dial-configuration/{id}',[AutoDialController::class,'destroy'])->name('delete');

    //Email-template api
    Route::post('list-email-template',[EmailTemplateController::class,'index']);
    Route::post('add-email-template',[EmailTemplateController::class,'store']);
    Route::get('edit-email-template/{id}',[EmailTemplateController::class,'edit']);
    Route::post('update-email-template',[EmailTemplateController::class,'update']);
    Route::get('delete-email-template/{id}',[EmailTemplateController::class,'destroy']);
    Route::get('email-template-title-list',[EmailTemplateController::class,'emailtemplatetitle']);
    Route::get('email-template-type-list',[EmailTemplateController::class,'emailtemplatetype']);
    
    // Mail Send Test API
    Route::get('sendtxtmailQueue',[MailController::class,'txtMailQueue']);
    Route::get('sendtxtmail',[MailController::class,'txtMail']);
    Route::get('sendhtmlmail',[MailController::class,'htmlMail']);
    Route::get('sendattachedemail',[MailController::class,'attachedEmail']);
    // Route::get('sendtxtmail','MailController@txt_mail');
    // Route::get('sendhtmlmail','MailController@html_mail');
    // Route::get('sendattachedemail','MailController@attached_email');


    //Contact Us
    Route::post('contact-us',[ContactUsController::class,'store']);
    Route::post('forgot-password', [UserController::class,'forgotPassword']);
    Route::post('change-password', [UserController::class,'updatePassword']);

   // Product-Master and Source-Master api
   Route::post('list-product',[ProductMasterController::class,'index']);
   Route::post('add-product',[ProductMasterController::class,'store']);
   Route::get('get-product-record/{id}',[ProductMasterController::class,'edit']);
   Route::post('update-product',[ProductMasterController::class,'update']);
   Route::get('delete-product/{id}',[ProductMasterController::class,'destroy']);

   Route::post('list-source',[SourceMasterController::class,'index']);
   Route::post('add-source',[SourceMasterController::class,'store']);
   Route::get('get-source-record/{id}',[SourceMasterController::class,'edit']);
   Route::post('update-source',[SourceMasterController::class,'update']);
   Route::get('delete-source/{id}',[SourceMasterController::class,'destroy']);

   //Customer lead api
   Route::post('customer-lead-list',[CustomerController::class,'index']);
   Route::post('add-customer',[CustomerController::class,'store']);
   Route::get('call-history',[CustomerController::class,'callHistory']);

});


Route::get('lead-download',[LeadViewController::class,'getLeadData'])->name('lead-download');


Route::apiResource('orders', OrderController::class);
Route::get('cart', [CartController::class, 'cartList'])->name('cart.list');
Route::post('cart', [CartController::class, 'addToCart'])->name('cart.store');
// Route::post('update-cart', [CartController::class, 'updateCart'])->name('cart.update');
// Route::post('remove', [CartController::class, 'removeCart'])->name('cart.remove');
// Route::post('clear', [CartController::class, 'clearAllCart'])->name('cart.clear');

Route::get('payment', [RazorpayPaymentController::class, 'index']);
Route::post('payment', [RazorpayPaymentController::class, 'store'])->name('razorpay.payment.store');

//nikita added
Route::get('data', [TelemarketingController::class, 'index']);
Route::post('telemarketing/login', [TelemarketingController::class, 'login']);
Route::get('lead',[LeadViewController::class,'index']);

//Route::post('salesRegister',[SalesController::class,'salesRegister']);
//Route::post('sales',[SalesController::class,'store']);





















