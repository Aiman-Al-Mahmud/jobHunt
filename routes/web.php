<?php
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobsController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/jobs', [JobsController::class, 'index'])->name('jobs');
Route::get('/jobs/detail/{id}', [JobsController::class, 'detail'])->name('jobDetail');
Route::post('/apply-job', [JobsController::class, 'applyJob'])->name('applyJob');
Route::post('/save-job', [JobsController::class, 'saveJob'])->name('saveJob');


Route::group(['prefix' => 'account'], function(){
    // Guest routes 
    Route::group(['middleware' => 'guest'], function(){
        Route::get('register', [AccountController::class, 'registration'])->name('account.registration');
        Route::post('process-register', [AccountController::class, 'processRegistration'])->name('account.processRegistration');
        Route::get('login', [AccountController::class, 'login'])->name('account.login');
        Route::post('authenticate', [AccountController::class, 'authenticate'])->name('account.authenticate');
    });
        
    Route::group(['middleware'=>'auth'], function(){
        Route::get('profile', [AccountController::class, 'profile'])->name('account.profile');
        Route::put('update-profile', [AccountController::class, 'updateProfile'])->name('account.updateProfile');
        Route::post('update-profile-pic', [AccountController::class, 'updateProfilePic'])->name('account.updateProfilePic');
        Route::post('change-password', [AccountController::class, 'changePassword'])->name('account.changePassword');
        Route::get('create-job', [AccountController::class, 'createJob'])->name('account.createJob');
        Route::post('save-job', [AccountController::class, 'saveJob'])->name('account.saveJob');
        Route::get('my-jobs', [AccountController::class, 'myJobs'])->name('account.myJobs');
        Route::get('my-jobs/edit/{jobId}', [AccountController::class, 'editJob'])->name('account.editJob');
        Route::post('update-job/{jobId}', [AccountController::class, 'updateJob'])->name('account.updateJob');
        Route::delete('delete-job', [AccountController::class, 'deleteJob'])->name('account.deleteJob');
        Route::get('my-job-applications', [AccountController::class, 'myJobApplications'])->name('account.myJobApplications');
        Route::delete('remove-job-application', [AccountController::class, 'removeJobs'])->name('account.removeJobs');
        Route::get('saved-jobs', [AccountController::class, 'savedJobs'])->name('account.savedJobs');
        Route::delete('remove-saved-job', [AccountController::class, 'removeSavedJob'])->name('account.removeSavedJob');
        Route::get('logout', [AccountController::class, 'logout'])->name('account.logout');
    });
});
//Route::middleware([App\Http\Middleware\AdminMiddleware::class])->group(function () {
    Route::get('/account/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::delete('/admin/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
    Route::get('/admin/users/{id}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/admin/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/admin/jobs/{id}', [AdminController::class, 'deleteJob'])->name('admin.jobs.delete');
    Route::get('/admin/jobs/{id}/edit', [AdminController::class, 'editJob'])->name('admin.jobs.edit');
    Route::put('/admin/jobs/{id}', [AdminController::class, 'updateJob'])->name('admin.jobs.update');
    


