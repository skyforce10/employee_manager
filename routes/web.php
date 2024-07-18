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


Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/company', [CompanyController::class, 'showCompManageForm'])->name('company');
Route::get('/company/list', [CompanyController::class, 'showcompanylist'])->name('companylist');
Route::post('/company', [CompanyController::class, 'saveCompanyInfo'])->name('savecompinfo');
Route::get('/company/getlist', [CompanyController::class, 'getcopanies'])->name('getcopanies');

Route::get('/employeemanager', [EmployeeController::class, 'showEmployeeManagerForm'])->name('employeemanager');
Route::get('/employee/list', [EmployeeController::class, 'showEmployeeList'])->name('employeelist');
Route::get('/getemployees', [EmployeeController::class, 'getemployees'])->name('getemployees');


