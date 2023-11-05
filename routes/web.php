<?php

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

Route::get('/companies', [\App\Http\Controllers\EmployerController::class, 'index'])->name('company.index');
Route::get('/company/{company}', [\App\Http\Controllers\EmployerController::class, 'show'])->name('company.show');
Route::get('/register', [\App\Http\Controllers\RegisterController::class, 'create'])->name('register.create');
Route::post('/register/store', [\App\Http\Controllers\RegisterController::class, 'store'])->name('register.store');
Route::get('/login', [\App\Http\Controllers\LoginController::class, 'create'])->name('login.create');
Route::post('/login', [\App\Http\Controllers\LoginController::class, 'store'])->name('login.store');
Route::post('/logout', [\App\Http\Controllers\LoginController::class, 'destroy'])->name('login.destroy');

Route::get('/user-profile/{user}', [\App\Http\Controllers\ViewUserProfile::class, 'index'])->name('user.info');
Route::get('/', [\App\Http\Controllers\JobController::class, 'index'])->name('jobs.index');

//Notifications

Route::middleware('auth')->group(function(){
//User
    Route::middleware('role:0')->group(function(){
        Route::get('/profile', [\App\Http\Controllers\UserController::class, 'index'])->name('user.index');
        Route::post('/profile/upload-picture', [\App\Http\Controllers\UserController::class, 'upload'])->name('user.upload');
        Route::post('/profile/description', [\App\Http\Controllers\UserDescriptionController::class, 'store'])->name('description.store');
        Route::get('/profile/update', [\App\Http\Controllers\UserDescriptionController::class, 'edit'])->name('user.edit');
        Route::post('/jobs/{job}/apply', \App\Http\Controllers\ApplyForJob::class)->name('jobs.apply');

    });
    Route::resource('notifications', \App\Http\Controllers\NotificationController::class)->only(['index', 'update']);

    //Recruiter
    Route::middleware('role:1')->group(function (){
        Route::get('/company', [\App\Http\Controllers\RecruiterController::class, 'index'])->name('company.profile');
        Route::get('/company/{employer}/edit', [\App\Http\Controllers\EmployerController::class, 'edit'])->name('company.edit');
        Route::resource('jobs', \App\Http\Controllers\JobController::class)->only([
            'create', 'store', 'show', 'destroy', 'edit', 'update'
        ]);
        Route::post('/company/info', [\App\Http\Controllers\EmployerController::class, 'update'])->name('company.update');
        Route::get('/invite-to-interview/{userId}/{application}', [\App\Http\Controllers\ApplicationController::class, 'index'])->name('application.accept');
        Route::post('/invitation/accepted', [\App\Http\Controllers\ApplicationController::class, 'store'])->name('application.invite');
        Route::post('application/response/{application}/{type}', \App\Actions\ResponseJobApplication::class)->name('application.response');
    });

});
