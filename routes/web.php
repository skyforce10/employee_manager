<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;

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

Route::get('/', function () {
    return view('auth.login');
});


//================accepted by admin only
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/company', [CompanyController::class, 'showCompManageForm'])->name('company');
    Route::get('/company/edit/{comp_id}', [CompanyController::class, 'showCompEditForm'])->name('companyedit');
    Route::get('/company/delete/{comp_id}', [CompanyController::class, 'deletecompany'])->name('companydelete');
    Route::post('/company', [CompanyController::class, 'saveCompanyInfo'])->name('savecompinfo');
    Route::get('/employee/delete/{emp_id}', [EmployeeController::class, 'deleteemployee'])->name('deleteemployee');
});

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/company/list', [CompanyController::class, 'showcompanylist'])->name('companylist');
Route::get('/company/getlist', [CompanyController::class, 'getcopanies'])->name('getcopanies');
Route::get('/company/statistic', [CompanyController::class, 'showcompanystatistic'])->name('statistic');
Route::get('/company/getstatistic', [CompanyController::class, 'getcompemployeenb'])->name('getstatistic');

Route::get('/employeemanager', [EmployeeController::class, 'showEmployeeManagerForm'])->name('employeemanager');
Route::get('/employee/list', [EmployeeController::class, 'showEmployeeList'])->name('employeelist');
Route::get('/employee/edit/{emp_id}', [EmployeeController::class, 'showEmpEditForm'])->name('employeeedit');
Route::get('/getemployees', [EmployeeController::class, 'getemployees'])->name('getemployees');
Route::post('/employee', [EmployeeController::class, 'saveemployee'])->name('saveemployee');
