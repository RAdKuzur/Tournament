<?php

use App\Http\Controllers\SchoolController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
//SchoolController
Route::get('/school/index', [SchoolController::class, 'index'])->name('school.index');
Route::get('/school/create', [SchoolController::class, 'create'])->name('school.create');
Route::post('/school/store', [SchoolController::class, 'store'])->name('school.store');
Route::get('/school/show/{id}', [SchoolController::class, 'show'])->name('school.show');
Route::get('/school/edit/{id}', [SchoolController::class, 'edit'])->name('school.edit');
Route::put('/school/update/{id}', [SchoolController::class, 'update'])->name('school.update');
Route::delete('/school/destroy/{id}', [SchoolController::class, 'destroy'])->name('school.destroy');


//StudentController
Route::get('/student/index', [StudentController::class, 'index'])->name('student.index');
Route::get('/student/create', [StudentController::class, 'create'])->name('student.create');
Route::post('/student/store', [StudentController::class, 'store'])->name('student.store');
Route::get('/student/show/{id}', [StudentController::class, 'show'])->name('student.show');
Route::get('/student/edit/{id}', [StudentController::class, 'edit'])->name('student.edit');
Route::put('/student/update/{id}', [StudentController::class, 'update'])->name('student.update');
Route::delete('/student/destroy/{id}', [StudentController::class, 'destroy'])->name('student.destroy');


Route::get('/', function () {
    return view('welcome');
});
