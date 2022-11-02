<?php

use Illuminate\Support\Facades\Route;
use app\Models\User;  //ดึงโมเดลเข้ามาใช้งาน
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ServiceController;




Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'),'verified'])->group(function () {
    
    Route::get('/dashboard', function () {
        //ข้อมูลมาจาก Model User
       $user= User::all();
        return view('dashboard',compact('user'));
    })->name('dashboard');  
});

Route::middleware(['auth:sanctum','verified'])->group(function(){
     //Department
    Route::get('/department/all',[DepartmentController::class,'index'])->name('department');
    Route::post('/department/add',[DepartmentController::class,'store'])->name('addDepartment');
    Route::get('/department/edit/{id}',[DepartmentController::class,'edit']);
    Route::post('/department/update/{id}',[DepartmentController::class,'update']);

    //SoftDelete
    Route::get('/department/softdelete/{id}',[DepartmentController::class,'softdelete']);
    Route::get('/department/restore/{id}',[DepartmentController::class,'restore']);
    Route::get('/department/delete/{id}',[DepartmentController::class,'delete']);

    //Service
    Route::get('/service/all',[ServiceController::class,'index'])->name('service');
    Route::post('/service/add',[ServiceController::class,'store'])->name('addService');

    Route::get('/service/edit/{id}',[ServiceController::class,'edit']);
    Route::post('/service/update/{id}',[ServiceController::class,'update']);
    Route::get('/service/delete/{id}',[ServiceController::class,'delete']);
});


