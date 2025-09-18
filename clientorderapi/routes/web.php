<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CausalController;
use App\Http\Controllers\ObservationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TechnicianController;
use App\Http\Controllers\TypeActivityController;
use App\Http\Controllers\UsersController;
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

Route::get('/',[AuthController::class,'index']);

Route::get('/index', function () {
    return view('index');
})->name('index');

Route::prefix('auth')->group(function(){
    Route::get('/index',[AuthController::class, 'index'])->name('auth.index');
    Route::post('/login',[AuthController::class, 'login'])->name('auth.login');
    Route::get('/register',[AuthController::class, 'create'])->name('auth.register');
    Route::post('/register',[AuthController::class, 'store'])->name('auth.store');

});

Route::prefix('auth')->group(function(){
    Route::get('/logout',[AuthController::class, 'logout'])->name('auth.logout');
});


// RUTA PARA CAUSAL
Route::prefix('causal')->group(function(){
    Route::get('/index',[CausalController::class, 'index'])->name('causal.index');
    Route::get('/create',[CausalController::class, 'create'])->name('causal.create'); 
    Route::get('/edit/{id}',[CausalController::class, 'edit'])->name('causal.edit');
    Route::post('/store',[CausalController::class, 'store'])->name('causal.store');
    Route::put('/update/{id}',[CausalController::class,'update'])->name('causal.update');
    Route::get('/destroy/{id}',[CausalController::class, 'destroy'])->name('causal.destroy');    
});

// RUTA PARA OBSERVATION
Route::prefix('observation')->group(function(){
    Route::get('/index',[ObservationController::class, 'index'])->name('observation.index');
    Route::get('/create',[ObservationController::class, 'create'])->name('observation.create'); 
    Route::get('/edit/{id}',[ObservationController::class, 'edit'])->name('observation.edit');
    Route::post('/store',[ObservationController::class, 'store'])->name('observation.store');
    Route::put('/update/{id}',[ObservationController::class,'update'])->name('observation.update');
    Route::get('/destroy/{id}',[ObservationController::class, 'destroy'])->name('observation.destroy');    
});


// // RUTA PARA TYPE_ACTIVITY
Route::prefix('typeactivity')->group(function(){
    Route::get('/index',[TypeActivityController::class, 'index'])->name('typeactivity.index');
    Route::get('/create',[TypeActivityController::class, 'create'])->name('typeactivity.create'); 
    Route::get('/edit/{id}',[TypeActivityController::class, 'edit'])->name('typeactivity.edit');
    Route::post('/store',[TypeActivityController::class, 'store'])->name('typeactivity.store');
    Route::put('/update/{id}',[TypeActivityController::class,'update'])->name('typeactivity.update');
    Route::get('/destroy/{id}',[TypeActivityController::class, 'destroy'])->name('typeactivity.destroy');    
});


// // RUTA PARA ACTIVITY
Route::prefix('activity')->group(function(){
    Route::get('/index',[ActivityController::class, 'index'])->name('activity.index');
    Route::get('/create',[ActivityController::class, 'create'])->name('activity.create'); 
    Route::get('/edit/{id}',[ActivityController::class, 'edit'])->name('activity.edit');
    Route::post('/store',[ActivityController::class, 'store'])->name('activity.store');
    Route::put('/update/{id}',[ActivityController::class,'update'])->name('activity.update');
    Route::get('/destroy/{id}',[ActivityController::class, 'destroy'])->name('activity.destroy');    
});


// // RUTA PARA ORDER
Route::prefix('order')->group(function(){
    Route::get('/index',[OrderController::class, 'index'])->name('order.index');
    Route::get('/create',[OrderController::class, 'create'])->name('order.create'); 
    Route::get('/edit/{id}',[OrderController::class, 'edit'])->name('order.edit');
    Route::post('/store',[OrderController::class, 'store'])->name('order.store');
    Route::put('/update/{id}',[OrderController::class,'update'])->name('order.update');
    Route::get('/destroy/{id}',[OrderController::class, 'destroy'])->name('order.destroy');  
    Route::get('/add_activity/{order_id}/{activity_id}',[OrderController::class, 'add_activity'])->name('order.add_activity');
    Route::get('/remove_activity/{order_id}/{activity_id}',[OrderController::class, 'remove_activity'])->name('order.remove_activity');

});


// // RUTA PARA TECHNICIAN
Route::prefix('technician')->group(function(){
    Route::get('/index',[TechnicianController::class, 'index'])->name('technician.index');
    Route::get('/create',[TechnicianController::class, 'create'])->name('technician.create'); 
    Route::get('/edit/{id}',[TechnicianController::class, 'edit'])->name('technician.edit');
    Route::post('/store',[TechnicianController::class, 'store'])->name('technician.store');
    Route::put('/update/{id}',[TechnicianController::class,'update'])->name('technician.update');
    Route::get('/destroy/{id}',[TechnicianController::class, 'destroy'])->name('technician.destroy');    
});

Route::prefix('reports')->group(function(){
    Route::get('/index',[ReportController::class, 'index'])->name('reports.index');
    Route::get('/report_technicians',[ReportController::class, 'export_technicians'])->name('reports.technicians');
    Route::post('/export_activities_by_technician',[ReportController::class, 'export_activities_by_technician'])->name('reports.activities_technician');
    Route::post('/export_orders_by_date',[ReportController::class, 'export_orders_by_date'])->name('reports.orders_by_date');

});

Route::prefix('users')->group(function(){
    Route::get('/index',[UsersController::class, 'index'])->name('users.index');
    Route::post('/send_email',[UsersController::class, 'send_email'])->name('users.send_email');
});