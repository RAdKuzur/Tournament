<?php

use App\Http\Controllers\SchoolController;
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



Route::get('/', function () {
    return view('welcome');
});
