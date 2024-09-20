<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeeServiceController;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\GraphicController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// главная страница
Route::get('/', [PageController::class, 'welcome'])->name('welcome');

// запись на услугу
Route::get('/choice', [PageController::class, 'ChoicePage'])->name('ChoicePage');
Route::get('/choice/employee', [PageController::class, 'ChoiceEmployeePage'])->name('ChoiceEmployeePage');
Route::get('/choice/services', [PageController::class, 'ChoiceServicePage'])->name('ChoiceServicePage');
Route::get('/choice/employee/services/{employee}', [PageController::class, 'ChoiceEmployeeServicesPage'])->name('ChoiceEmployeeServicesPage');
Route::get('/choice/service/employees/{service}', [PageController::class, 'ChoiceServiceEmployeesPage'])->name('ChoiceServiceEmployeesPage');
Route::get('/choice/date/{employee}/{service}', [PageController::class, 'ChoiceDatePage'])->name('ChoiceDatePage');
Route::post('/choice/date/entries', [PageController::class, 'getTimes'])->name('getTimes');
Route::post('/entry/add', [EntryController::class, 'store'])->name('EntrySave');


// страницы для авторизации администратора
Route::get('/auth', [PageController::class, 'AuthPage'])->name('login');
Route::post('/login', [UserController::class, 'login'])->name('AuthUser');

// оформление заявки на обратный звонок
Route::post('/application/add', [ApplicationController::class, 'store'])->name('ApplicationSave');

// страницы с услугами
Route::get('/category/type/{category}', [PageController::class, 'CategoryServicePage'])->name('CategoryServicePage');
Route::get('/type/services/{type}', [PageController::class, 'ServicesTypePage'])->name('ServicesTypePage');

// страница с сотрудниками студии
Route::get('/employees', [PageController::class, 'EmployeesUserPage'])->name('EmployeesUserPage');
Route::post('/category/employees', [PageController::class, 'getEmployees'])->name('getEmployees');

// страница с контактами студии
Route::get('/contacts', [PageController::class, 'ContactsPage'])->name('ContactsPage');



Route::group(['middleware'=>['auth', 'admin'], 'prefix'=>'admin'], function () {
    // выход из учетной записи администратора
    Route::get('/exit', [UserController::class, 'ExitUser'])->name('ExitUser');

    // страница с категориями и типами
    Route::get('/category', [PageController::class, 'CategoryTypePage'])->name('CategoryTypePage');

    // действия с категориями услуг
    Route::post('/category/add', [CategoryController::class, 'store'])->name('AddCategory');
    Route::delete('/category/delete/{category}', [CategoryController::class, 'destroy'])->name('DeleteCategory');

    // действия с типами услуг
    Route::post('/type/add', [TypeController::class, 'store'])->name('AddType');
    Route::delete('/type/delete/{type?}', [TypeController::class, 'destroy'])->name('DeleteType');

    // страница с услугами
    Route::get('/services', [PageController::class, 'ServicesPage'])->name('ServicesPage');
    Route::post('/service/add', [ServiceController::class, 'store'])->name('AddService');
    Route::get('/service/edit/{service?}', [PageController::class, 'EditServicePage'])->name('EditServicePage');
    Route::put('/service/edit/save/{service}', [ServiceController::class, 'update'])->name('EditServiceSave');
    Route::delete('/service/delete/{service?}', [ServiceController::class, 'destroy'])->name('DeleteService');

    // удаление сотрудника студии, который оказывал выбранную услугу
    Route::delete('/employeeservice/delete/{employeeService}', [EmployeeServiceController::class, 'destroy'])->name('DeleteEmployeeService');

    // страница с сотрудниками студии
    Route::get('/employees', [PageController::class, 'EmployeesPage'])->name('EmployeesPage');
    Route::post('/employee/add', [EmployeeController::class, 'store'])->name('AddEmployee');
    Route::get('/employee/edit/{employee?}', [PageController::class, 'EditEmployeePage'])->name('EditEmployeePage');
    Route::put('/employee/edit/save/{employee}', [EmployeeController::class, 'update'])->name('EditEmployeeSave');
    Route::delete('/employee/delete/{employee?}', [EmployeeController::class, 'destroy'])->name('DeleteEmployee');

    // страница с графиками
    Route::get('/graphics', [PageController::class, 'GraphicsPage'])->name('GraphicsPage');
    Route::post('/graphic/add', [GraphicController::class, 'store'])->name('AddGraphic');
    Route::get('/graphic/edit/{graphic?}', [PageController::class, 'EditGraphicPage'])->name('EditGraphicPage');
    Route::put('/graphic/edit/{graphic}', [GraphicController::class, 'update'])->name('EditGraphicSave');
    Route::delete('/graphic/delete/{graphic?}', [GraphicController::class, 'destroy'])->name('DeleteGraphic');

    // страница с заявками клиентов на обратный звонок
    Route::get('/applications', [PageController::class, 'ApplicationsPage'])->name('ApplicationsPage');
    Route::put('/application/confirmation/{application?}', [ApplicationController::class, 'edit'])->name('ConfirmationApplication');
    Route::delete('/application/delete/{application?}', [ApplicationController::class, 'destroy'])->name('DeleteApplication');

    // страница с записями клиентов на услугу
    Route::get('/entries', [PageController::class, 'EntriesPage'])->name('EntriesPage');
    Route::put('/entry/confirmation/{entry?}', [EntryController::class, 'edit'])->name('ConfirmationEntry');
    Route::delete('/entry/delete/{entry?}', [EntryController::class, 'destroy'])->name('DeleteEntry');
    Route::get('/entries/day', [PageController::class, 'EntriesDay'])->name('EntriesDay');
});
