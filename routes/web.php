<?php

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ProviderProfileController;
use App\Http\Controllers\ReviewController;
use App\Models\Product;
use GuzzleHttp\Middleware;
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

// Route::get('/', function () {
//     return view('welcome');
// });


// Route::group(['prefix' => 'admin',  'middleware' => 'auth'], function(){
Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
Route::get('/teacher/dashboard', [DashboardController::class, 'teacher'])->name('teacher.dashboard');
Route::get('/student/dashboard', [DashboardController::class, 'student'])->name('student.dashboard');

Route::resource('roles', RoleController::class);
Route::resource('users', UserController::class);
Route::get('users/search', [UserController::class, 'search'])->name('users.search');

Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::put('profile/update', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('profile/destroy', [ProfileController::class, 'destroy'])->name('profile.destroy');
Route::resource('product', ProductController::class);
// Route::resource('profile', ProfileController::class);
// });
Route::get('/', [FrontendController::class, 'home'])->name('home');
Route::get('/about-us', [FrontendController::class, 'aboutUs'])->name('about-us');
Route::get('/service', [FrontendController::class, 'Service'])->name('service');
Route::get('/contact', [FrontendController::class, 'Contact'])->name('contact');
Route::get('/collaboration', [FrontendController::class, 'Collaboration'])->name('collaboration');


Route::middleware(['auth', 'role:service provider'])->group(function () {
    // Profile routes
    Route::get('/profile', [ProviderProfileController::class, 'index'])->name('profile.index');
    // Personal Info routes
    Route::get('/profile/personal-info', [ProviderProfileController::class, 'personalInfo'])->name('profile.personal-info');
    Route::post('/profile/personal-info', [ProviderProfileController::class, 'updatePersonalInfo'])->name('profile.update-personal-info');

    // Profile Picture routes
    Route::get('/profile/profile-picture', [ProviderProfileController::class, 'profilePicture'])->name('profile.profile-picture');
    Route::post('/profile/profile-picture', [ProviderProfileController::class, 'updateProfilePicture'])->name('profile.update-profile-picture');

    // Business Info routes
    Route::get('/profile/business-info', [ProviderProfileController::class, 'businessInfo'])->name('profile.business-info');
    Route::post('/profile/business-info', [ProviderProfileController::class, 'updateBusinessInfo'])->name('profile.update-business-info');

    // Review routes
    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::get('/reviews/create/{user}', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/reviews/{user}', [ReviewController::class, 'store'])->name('reviews.store');
});

require __DIR__ . '/auth.php';
