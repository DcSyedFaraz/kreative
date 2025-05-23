<?php

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerReviewController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ProviderProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServicesController;
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


Route::group(['middleware' => 'auth', 'role:admin'], function () {
    Route::post('/admin/approve/{id}', [AdminController::class, 'approve'])->name('admin.approve');
    Route::post('/admin/reject/{id}', [AdminController::class, 'reject'])->name('admin.reject');

    Route::resource('product', ProductController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
});
Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/teacher/dashboard', [DashboardController::class, 'teacher'])->name('teacher.dashboard');
    Route::get('/student/dashboard', [DashboardController::class, 'student'])->name('student.dashboard');

    Route::resource('available-services', ServicesController::class);
    Route::get('users/search', [UserController::class, 'search'])->name('users.search');

    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('profile/destroy', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Route::resource('profile', ProfileController::class);
    Route::get('/registration-pending', [FrontendController::class, 'registration_pending'])->name('registration-pending');
});

Route::get('/', [FrontendController::class, 'home'])->name('home');
Route::get('/about-us', [FrontendController::class, 'aboutUs'])->name('about-us');
Route::get('/service', [FrontendController::class, 'Service'])->name('service');
Route::get('/contact', [FrontendController::class, 'Contact'])->name('contact');
Route::get('/service-providers', [ServiceController::class, 'searchProviders'])->name('service-providers.search');

Route::get('/collaboration', [FrontendController::class, 'Collaboration'])->name('collaboration');


Route::middleware(['auth', 'role:service provider', 'approved'])->group(function () {
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

    Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
    Route::post('/services', [ServiceController::class, 'update'])->name('services.update');

    // Customer reviews routes
    Route::get('/customer-reviews', [CustomerReviewController::class, 'index'])->name('customer-reviews.index');
    Route::get('/customer-reviews/{customer}', [CustomerReviewController::class, 'create'])->name('customer-reviews.create');
    Route::post('/customer-reviews/{customer}', [CustomerReviewController::class, 'store'])->name('customer-reviews.store');
    Route::get('/customer-review/received', [CustomerReviewController::class, 'show'])->name('customer-reviews.show');
});

require __DIR__ . '/auth.php';
