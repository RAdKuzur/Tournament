<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DefenceController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DrawController;
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

//AuthController
Route::get('/auth/form', [AuthController::class, 'form'])->name('auth.form');
Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');
Route::get('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::post('/auth/register', [AuthController::class, 'register'])->name('auth.register');
Route::get('/auth/forgot-password', [AuthController::class, 'forgotPassword'])->name('auth.forgot-password');
Route::post('/auth/reset-password', [AuthController::class, 'resetPassword'])->name('auth.reset-password');
Route::get('/auth/new-password/{id}', [AuthController::class, 'newPassword'])->name('auth.new-password');
Route::post('/auth/update-password/{id}', [AuthController::class, 'updatePassword'])->name('auth.update-password');

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

//TournamentController
Route::get('/tournament/index', [TournamentController::class, 'index'])->name('tournament.index');
Route::get('/tournament/create', [TournamentController::class, 'create'])->name('tournament.create');
Route::post('/tournament/store', [TournamentController::class, 'store'])->name('tournament.store');
Route::get('/tournament/show/{id}', [TournamentController::class, 'show'])->name('tournament.show');
Route::get('/tournament/edit/{id}', [TournamentController::class, 'edit'])->name('tournament.edit');
Route::put('/tournament/update/{id}', [TournamentController::class, 'update'])->name('tournament.update');
Route::delete('/tournament/destroy/{id}', [TournamentController::class, 'destroy'])->name('tournament.destroy');

//TeamController
Route::get('/team/index', [TeamController::class, 'index'])->name('team.index');
Route::get('/team/create', [TeamController::class, 'create'])->name('team.create');
Route::post('/team/store', [TeamController::class, 'store'])->name('team.store');
Route::get('/team/show/{id}', [TeamController::class, 'show'])->name('team.show');
Route::get('/team/edit/{id}', [TeamController::class, 'edit'])->name('team.edit');
Route::put('/team/update/{id}', [TeamController::class, 'update'])->name('team.update');
Route::delete('/team/destroy/{id}', [TeamController::class, 'destroy'])->name('team.destroy');
Route::get('/team/by-school/{id}', [TeamController::class, 'getBySchool'])->name('team.getBySchool');

//UserController
Route::get('/user/index', [UserController::class, 'index'])->name('user.index');
Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
Route::get('/user/show/{id}', [UserController::class, 'show'])->name('user.show');
Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
Route::put('/user/update/{id}', [UserController::class, 'update'])->name('user.update');
Route::delete('/user/destroy/{id}', [UserController::class, 'destroy'])->name('user.destroy');

//DefenceController
Route::get('/defence/index', [DefenceController::class, 'index'])->name('defence.index');
Route::get('/defence/create', [DefenceController::class, 'create'])->name('defence.create');
Route::post('/defence/store', [DefenceController::class, 'store'])->name('defence.store');
Route::get('/defence/show/{id}', [DefenceController::class, 'show'])->name('defence.show');
Route::get('/defence/edit/{id}', [DefenceController::class, 'edit'])->name('defence.edit');
Route::put('/defence/update/{id}', [DefenceController::class, 'update'])->name('defence.update');
Route::delete('/defence/destroy/{id}', [DefenceController::class, 'destroy'])->name('defence.destroy');
Route::get('/defence/act-defence/{id}', [DefenceController::class, 'actDefence'])->name('defence.act-defence');
Route::post('/defence/act-defence/{id}', [DefenceController::class, 'actDefence'])->name('defence.act-defence-post');
Route::get('/defence/add-team-participant/{id}', [DefenceController::class, 'addTeamParticipant'])->name('defence.add-team-participant');
Route::post('/defence/add-team-participant/{id}', [DefenceController::class, 'addTeamParticipant'])->name('defence.add-team-participant-post');
Route::delete('/defence/delete-act-participant/{id}', [DefenceController::class, 'deleteActParticipant'])->name('defence.delete-act-participant');
Route::delete('/defence/delete-defence-participant/{id}', [DefenceController::class, 'deleteDefenceParticipant'])->name('defence.delete-defence-participant');
Route::get('/defence/leaderboard/{id}', [DefenceController::class, 'leaderboard'])->name('defence.leaderboard');
Route::get('/defence/score/{id}', [DefenceController::class, 'score'])->name('defence.score');
Route::get('/defence/change-score/{id}/{type}/{score}', [DefenceController::class, 'changeScore'])->name('defence.change-score');
Route::get('/defence/leaderboard-update/{id}', [DefenceController::class, 'leaderboardUpdate'])->name('defence.leaderboard-update');

//DrawController
Route::get('/draw/index/{id}', [DrawController::class, 'index'])->name('draw.index');
Route::get('/draw/edit-score/{id}', [DrawController::class, 'edit-score'])->name('draw.edit-score');
Route::get('/draw/conclude-round/{id}', [DrawController::class, 'edit-score'])->name('draw.edit-score');
Route::get('/', function () {
    return redirect()->route('auth.form');
});
