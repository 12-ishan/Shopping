<?php

use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\ProgramController;
use App\Http\Controllers\admin\SubjectController;
use App\Http\Controllers\admin\TopicController;
use App\Http\Controllers\admin\TimeSlotController;
use App\Http\Controllers\admin\QuestionCategoryController;
use App\Http\Controllers\admin\QuestionController;
use App\Http\Controllers\admin\MeetingController;
use App\Http\Controllers\admin\ContactController;
use App\Http\Controllers\admin\RoleController;
use App\Http\Controllers\admin\PermissionHeadController;
use App\Http\Controllers\admin\GenderController;
use App\Http\Controllers\admin\BloodGroupController;
use App\Http\Controllers\admin\CityController;
use App\Http\Controllers\admin\StateController;
use App\Http\Controllers\admin\SalutationController;
use App\Http\Controllers\admin\UniversityController;
use App\Http\Controllers\admin\DegreeController;
use App\Http\Controllers\admin\ModeController;
use App\Http\Controllers\admin\BoardController;
use App\Http\Controllers\admin\StreamController;
use App\Http\Controllers\admin\ProficiencyLevelController;
use App\Http\Controllers\frontend\RegistrationController;
use App\Http\Controllers\frontend\StudentController;
use App\Http\Controllers\frontend\StudentDashboardController;
use App\Http\Controllers\admin\StudentManagerController;
use App\Http\Controllers\admin\ApplicationController;
use App\Http\Controllers\admin\CouponController;
use App\Http\Controllers\admin\PaymentHistoryController;
use App\Http\Controllers\admin\AwardsLevelController;

use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\ProductCategoryController;
use App\Http\Controllers\admin\ProductAttributesController;
use App\Http\Controllers\admin\AttributeOptionsController;
use App\Http\Controllers\admin\OrderController;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Registration Routing
Route::get('/registration', [RegistrationController::class, 'index'])->name('studentRegistration');
Route::post('/doRegistration', [RegistrationController::class, 'insert'])->name('doRegistration');

Route::get('/student/logout', [StudentController::class, 'logout'])->name('studentLogout');



Route::group(['middleware' => ['auth:student']], function () {

Route::get('/student/dashboard', [StudentDashboardController::class, 'index'])->name('studentDashboard');



});



//Registration Routing ends

//Login Routing
Route::get('/login', [StudentController::class, 'index'])->name('studentLogin');

Route::post('/doStudentLogin',[StudentController::class, 'doStudentLogin'])->name('doStudentLogin');
//Login Routing ends

Route::get('/admin/login',[AdminController::class, 'login'])->name('adminLogin');
Route::get('/admin/logout',[AdminController::class, 'logout'])->name('adminLogout');
Route::get('/admin/register',[AdminController::class, 'register'])->name('adminRegister');
Route::post('register',[AdminController::class, 'createUser'])->name('adminRegisterPost');
Route::post('login',[AdminController::class, 'doLogin'])->name('doLogin');


Route::group(['middleware' => ['auth']], function () {
    // demo for role based API
    Route::get('admin/emp-role', [EmployeeController::class, 'index'])->name('emp-role')->middleware('can:add.blog');
    Route::get('admin/user/{id}/edit',[UserController::class, 'edit'])->name('user.edit');
    Route::put('admin/user/{id}',[UserController::class, 'update'])->name('user.update');
    Route::get('/admin/dashboard',[DashboardController::class, 'home'])->name('dashboard');


      //Program Routings
    
      Route::post('admin/product/updateSortorder',[ProductController::class, 'updateSortorder']);
      Route::post('admin/product/destroyAll',[ProductController::class, 'destroyAll']);
      Route::post('admin/product/updateStatus',[ProductController::class, 'updateStatus']);
      Route::resource('admin/product', ProductController::class);
      Route::post('admin/product/getAttributeOptions',[ProductController::class, 'getAttributeOptions']);
     Route::post('admin/product/add-more',[ProductController::class, 'addVariation']);
      //Program Routings 
      

       //order Routings
    
       Route::post('admin/order/updateSortorder',[OrderController::class, 'updateSortorder']);
       Route::post('admin/order/destroyAll',[OrderController::class, 'destroyAll']);
       Route::post('admin/order/updateStatus',[OrderController::class, 'updateStatus']);
       Route::resource('admin/order', OrderController::class);
       //Route::post('admin/product/getAttributeOptions',[ProductController::class, 'getAttributeOptions']);
      //Route::post('admin/product/add-more',[ProductController::class, 'addVariation']);
       //Program Routings ends

    

     //Product Category Routings
         
     Route::post('admin/product-category/updateSortorder', [ProductCategoryController:: class, 'updateSortorder']);
     Route::post('admin/product-category/destroyAll', [ProductCategoryController:: class, 'destroyAll']);
     Route::post('admin/product-category/updateStatus', [ProductCategoryController:: class, 'updateStatus']);
     Route::resource('admin/product-category', ProductCategoryController::class);
 
     //Product Category Routings ends

     //Attributes Routings
    
     Route::post('admin/product-attributes/updateSortorder',[ProductAttributesController:: class, 'updateSortorder']);
     Route::post('admin/product-attributes/destroyAll',[ProductAttributesController:: class, 'destroyAll']);
     Route::post('admin/product-attributes/updateStatus',[ProductAttributesController:: class, 'updateStatus']);
     Route::resource('admin/product-attributes', ProductAttributesController::class);
 
     //Attributes  Routings ends


      //Attributes Routings
    
      Route::post('admin/attribute-options/updateSortorder',[AttributeOptionsController:: class, 'updateSortorder']);
      Route::post('admin/attribute-options/destroyAll',[AttributeOptionsController:: class, 'destroyAll']);
      Route::post('admin/attribute-options/updateStatus',[AttributeOptionsController:: class, 'updateStatus']);
      Route::resource('admin/attribute-options', AttributeOptionsController::class);
  
      //Attributes  Routings ends
 



      //Gender Routings
    
      Route::post('admin/gender/updateSortorder',[ GenderController::class, 'updateSortorder']);
      Route::post('admin/gender/destroyAll',[ GenderController::class, 'destroyAll']);
      Route::post('admin/gender/updateStatus',[ GenderController::class, 'updateStatus']);
      Route::resource('admin/gender', GenderController::class);
  
      //Gender Routings ends

       //BloodGroup Routings
    
       Route::post('admin/bloodGroup/updateSortorder',[ BloodGroupController::class, 'updateSortorder']);
       Route::post('admin/bloodGroup/destroyAll',[ BloodGroupController::class, 'destroyAll']);
       Route::post('admin/bloodGroup/updateStatus',[ BloodGroupController::class, 'updateStatus']);
       Route::resource('admin/bloodGroup', BloodGroupController::class);
   
       //BloodGroup Routings ends

        //City Routings
        Route::post('admin/city/updateSortorder',[ CityController::class, 'updateSortorder']);
        Route::post('admin/city/destroyAll',[ CityController::class, 'destroyAll']);
        Route::post('admin/city/updateStatus',[ CityController::class, 'updateStatus']);
        Route::resource('admin/city', CityController::class);
         //City Routings ends

          //State Routings
          Route::post('admin/state/updateSortorder',[ StateController::class, 'updateSortorder']);
          Route::post('admin/state/destroyAll',[ StateController::class, 'destroyAll']);
          Route::post('admin/state/updateStatus',[ StateController::class, 'updateStatus']);
          Route::resource('admin/state', StateController::class);
           //State Routings ends

             //Salutation Routings
          Route::post('admin/salutation/updateSortorder',[ SalutationController::class, 'updateSortorder']);
          Route::post('admin/salutation/destroyAll',[ SalutationController::class, 'destroyAll']);
          Route::post('admin/salutation/updateStatus',[ SalutationController::class, 'updateStatus']);
          Route::resource('admin/salutation', SalutationController::class);
           //Salutation Routings ends

          //University Routings
          Route::post('admin/university/updateSortorder',[ UniversityController::class, 'updateSortorder']);
          Route::post('admin/university/destroyAll',[ UniversityController::class, 'destroyAll']);
          Route::post('admin/university/updateStatus',[ UniversityController::class, 'updateStatus']);
          Route::resource('admin/university', UniversityController::class);
          //University Routings ends

           //Degree Routings
           Route::post('admin/degree/updateSortorder',[ DegreeController::class, 'updateSortorder']);
           Route::post('admin/degree/destroyAll',[ DegreeController::class, 'destroyAll']);
           Route::post('admin/degree/updateStatus',[ DegreeController::class, 'updateStatus']);
           Route::resource('admin/degree', DegreeController::class);
           //Degree Routings 

           //Level of Awards and recognition Routings
           Route::post('admin/awardsLevel/updateSortorder',[ AwardsLevelController::class, 'updateSortorder']);
           Route::post('admin/awardsLevel/destroyAll',[ AwardsLevelController::class, 'destroyAll']);
           Route::post('admin/awardsLevel/updateStatus',[ AwardsLevelController::class, 'updateStatus']);
           Route::resource('admin/awardsLevel', AwardsLevelController::class);
           //Level of Awards and recognition Routings 
           
            //Mode Routings
            Route::post('admin/mode/updateSortorder',[ ModeController::class, 'updateSortorder']);
            Route::post('admin/mode/destroyAll',[ ModeController::class, 'destroyAll']);
            Route::post('admin/mode/updateStatus',[ ModeController::class, 'updateStatus']);
            Route::resource('admin/mode', ModeController::class);
            //Mode Routings ends

              //Board Routings
              Route::post('admin/board/updateSortorder',[ BoardController::class, 'updateSortorder']);
              Route::post('admin/board/destroyAll',[ BoardController::class, 'destroyAll']);
              Route::post('admin/board/updateStatus',[ BoardController::class, 'updateStatus']);
              Route::resource('admin/board', BoardController::class);
              //Board Routings ends

               //Stream Routings
               Route::post('admin/stream/updateSortorder',[ StreamController::class, 'updateSortorder']);
               Route::post('admin/stream/destroyAll',[ StreamController::class, 'destroyAll']);
               Route::post('admin/stream/updateStatus',[ StreamController::class, 'updateStatus']);
               Route::resource('admin/stream', StreamController::class);
               //Stream Routings ends

                // //Profile Routings
                // Route::post('admin/profile/updateSortorder',[ ProfileController::class, 'updateSortorder']);
                // Route::post('admin/profile/destroyAll',[ ProfileController::class, 'destroyAll']);
                // Route::post('admin/profile/updateStatus',[ ProfileController::class, 'updateStatus']);
                // Route::resource('admin/profile', ProfileController::class);
                // //Profile Routings ends

               //ProficiencyLevel Routings
               Route::post('admin/proficiencyLevel/updateSortorder',[ ProficiencyLevelController::class, 'updateSortorder']);
               Route::post('admin/proficiencyLevel/destroyAll',[ ProficiencyLevelController::class, 'destroyAll']);
               Route::post('admin/proficiencyLevel/updateStatus',[ ProficiencyLevelController::class, 'updateStatus']);
               Route::resource('admin/proficiencyLevel', ProficiencyLevelController::class);
               //ProficiencyLevel Routings ends

                 //Coupon Routings
                 Route::post('admin/coupon/updateSortorder',[ CouponController::class, 'updateSortorder']);
                 Route::post('admin/coupon/destroyAll',[ CouponController::class, 'destroyAll']);
                 Route::post('admin/coupon/updateStatus',[ CouponController::class, 'updateStatus']);
                 Route::resource('admin/coupon', CouponController::class);
                 //Coupon Routings ends

                   //Payment History Routings
                   Route::post('admin/paymentHistory/destroyAll',[ PaymentHistroyController::class, 'destroyAll']);
                   Route::post('admin/paymentHistory/updateSortorder',[ PaymentHistroyController::class, 'updateSortorder']);
                   Route::post('admin/paymentHistory/updateStatus',[ PaymentHistroyController::class, 'updateStatus']);
                   Route::get('admin/paymentHistory', [PaymentHistoryController::class, 'index'])->name('index');
                   Route::post('admin/paymentHistory', [PaymentHistoryController::class, 'store'])->name('store');
                   //Payment History Routings ends
     
   
 
 
     //Question Catgory Routings
    
     Route::post('admin/question-category/updateSortorder',[QuestionCategoryController:: class, 'updateSortorder']);
     Route::post('admin/question-category/destroyAll',[QuestionCategoryController:: class, 'destroyAll']);
     Route::post('admin/question-category/updateStatus',[QuestionCategoryController:: class, 'updateStatus']);
     Route::resource('admin/question-category',QuestionCategoryController::class);
 
     //QUestion Category Routings ends

     //Question Routings

     Route::post('admin/question/updateSortorder',[QuestionController:: class, 'updateSortorder']);
     Route::post('admin/question/destroyAll',[QuestionController:: class, 'destroyAll']);
     Route::post('admin/question/updateStatus',[QuestionController:: class, 'updateStatus']);
     Route::resource('admin/question',QuestionController::class);
 
     //Question Routings ends

           //Meeting Routings

           Route::post('admin/topic/getTopicBySubjectId',[MeetingController:: class, 'getTopicBySubjectId']);
           Route::post('admin/topic/getTeacherByProgramIDSubjectId',[MeetingController:: class, 'getTeacherByProgramIDSubjectId']);
           Route::post('admin/meeting/updateSortorder',[MeetingController:: class, 'updateSortorder']);
           Route::post('admin/meeting/destroyAll',[MeetingController:: class, 'destroyAll']);
           Route::post('admin/meeting/updateStatus',[MeetingController:: class, 'updateStatus']);
           Route::get('admin/meeting/activate/{id}',[MeetingController:: class, 'meetingActivate']);
       //    Route::post('/meeting/activate/update/{id}', ['as' => 'meeting.meetingActivateUpdate','uses' => 'admin\MeetingController@meetingActivateUpdate']);
           Route::resource('admin/meeting',MeetingController::class);
       
          //Meeting Routings ends



         //Contact Routings

    
         Route::post('admin/contact/updateSortorder',[ContactController:: class,  'updateSortorder']);
         Route::post('admin/contact/destroyAll',[ContactController:: class,  'destroyAll']);
         Route::post('admin/contact/updateStatus',[ContactController:: class,  'updateStatus']);
         Route::resource('admin/contact',ContactController::class);
     
         //Contact Routings ends

         //Role Routings
         Route::post('admin/role/updateSortorder',[RoleController::class,  'updateSortorder']);
         Route::post('admin/role/destroyAll',[RoleController::class,  'destroyAll']);
         Route::post('admin/role/updateStatus',[RoleController::class,'updateStatus']); 
         Route::resource('admin/role',RoleController::class);
         //Role Routings ends

          //PermissionHead Routings
          Route::post('admin/permissionHead/updateSortorder',[PermissionHeadController::class,  'updateSortorder']);
          Route::post('admin/permissionHead/destroyAll',[PermissionHeadController::class,  'destroyAll']);
          Route::post('admin/permissionHead/updateStatus',[PermissionHeadController::class,'updateStatus']); 
          Route::resource('admin/permissionHead',PermissionHeadController::class);
          //PermissionHead Routings ends
 
           //Student Manager Routings
           Route::post('admin/studentManager/updateSortorder',[StudentManagerController::class,  'updateSortorder']);
           Route::post('admin/studentManager/destroyAll',[StudentManagerController::class,  'destroyAll']);
           Route::post('admin/studentManager/updateStatus',[StudentManagerController::class,'updateStatus']); 
           Route::resource('admin/studentManager',StudentManagerController::class);
           //Student Manager Routings ends

             //Application Manager Routings
             Route::post('admin/application/updateSortorder',[ApplicationController::class,  'updateSortorder']);
             Route::post('admin/application/destroyAll',[ApplicationController::class,  'destroyAll']);
             Route::post('admin/application/updateStatus',[ApplicationController::class,'updateStatus']); 
             Route::post('admin/application/updateOrder',[ApplicationController::class,'updateOrder']); 
             Route::resource('admin/application',ApplicationController::class);
             //Application Manager Routings ends
  

});


// Route::get('/admin/dashboard', 'admin\DashboardController@home');


//Route::get('/admin/login', 'admin\AdminController@login')->name('adminLogin');
// Route::post('login', 'admin\AdminController@doLogin')->name('customeLogin');
//Route::get('/admin/register', 'admin\AdminController@register');
//Route::post('register', 'admin\AdminController@createUser');

Route::get('/', function () {
    return view('welcome');
});
