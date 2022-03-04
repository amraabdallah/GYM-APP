<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CityManagerController;
use App\Http\Controllers\GymController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\PackagesController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PurchaseController;

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
    return redirect()->route('dashboard.home');
});

Route::prefix('dashboard')->middleware('auth')->name('dashboard.')->group(function () {

    Route::get('/', function () {return view('home');})->name('home');

    Route::resource('city-managers', CityManagerController::class);

    Route::resource('cities', CityController::class)->middleware('permission:cities');

    Route::get('/cities-form-data', [CityController::class, 'getFormData'])->name('cities.formData');

    Route::resource('gyms', GymController::class)->middleware('permission:gyms');
    Route::get('/gyms-form-data', [GymController::class, 'getFormData'])->name('gyms.formData');

    Route::resource('purchases', PurchaseController::class)->only(['index', 'create', 'store'])->middleware('permission:purchases');

    Route::resource('attendance', AttendanceController::class)->only(['index', 'create', 'update'])->middleware('permission:attendance');

    Route::get('/attendance-form-data', [AttendanceController::class, 'getFormData'])->name('attendance.formData');

    Route::resource('packages', PackagesController::class)->middleware('permission:packages');

    Route::resource('sessions', SessionsController::class)->middleware('permission:sessions');

    Route::resource('users', UserController::class)->middleware('permission:users');

    Route::prefix('account')->name('account.')->group(function () {
        Route::get('/', [ManagerController::class,'index'])->name('index');
        Route::put('/update-basic', [ManagerController::class,'updateBasicInformation'])->name('update-basic');
        Route::put('/update-password', [ManagerController::class,'updatePassword'])->name('update-password');

    });
});

Route::get('storage/{filename}', function ($filename)
{
    $path = storage_path('public/' . $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});


Auth::routes();
