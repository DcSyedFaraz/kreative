<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerReviewController;
use App\Http\Controllers\CustomPackageController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProviderProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServiceProviderConditionController;
use App\Http\Controllers\PackageOptionController;
use App\Http\Controllers\ChatRoomController;
use App\Http\Controllers\ChatMessageController;
use App\Http\Controllers\ServicesController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use Tighten\Ziggy\Ziggy;

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

Route::get('/ziggy', function () {
    return new Ziggy();
});

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

    Route::resource('packages', PackageController::class);

    Route::post('/booking/store', [PaymentController::class, 'datastore'])->name('booking.store');
    Route::post('/create-payment-intent', [PaymentController::class, 'createPaymentIntent'])->name('payment.intent');
    Route::any('/create-custom-payment-intent', [PaymentController::class, 'createCustomPaymentIntent'])->name('payment.custom.intent');
    // Route::get('/payments/get', [PaymentController::class, 'getPayments'])->name('payments.get');
    Route::get('/payments/{id}', [PaymentController::class, 'show'])->name('payments.show');

    Route::get('/provider/conditions', [ServiceProviderConditionController::class, 'index'])->name('provider.conditions.edit');
    Route::post('/provider/conditions', [ServiceProviderConditionController::class, 'store'])->name('provider.conditions.update');
    // Routes to manage custom package options
    Route::get('/provider/package-options', [PackageOptionController::class, 'index'])->name('package-options.edit');
    Route::post('/provider/package-options', [PackageOptionController::class, 'store'])->name('package-options.update');

    Route::get('/providers/{provider}/custom-packages/create', [CustomPackageController::class, 'create'])->name('custom-packages.create');
    Route::post('/providers/{provider}/custom-packages', [CustomPackageController::class, 'store'])->name('custom-packages.store');
    Route::get('/custom-packages', [CustomPackageController::class, 'index'])->name('custom-packages.index');
    Route::get('/custom-packages/{customPackage}', [CustomPackageController::class, 'show'])->name('custom-packages.show');
    Route::put('/custom-packages/{customPackage}', [CustomPackageController::class, 'update'])->name('custom-packages.update');
    Route::delete('/custom-packages/{customPackage}', [CustomPackageController::class, 'destroy'])->name('custom-packages.destroy');
    Route::post('/custom-packages/{customPackage}/pay', [CustomPackageController::class, 'pay'])->name('custom-packages.pay');

    Route::get('/chat', [ChatRoomController::class, 'index'])->name('chat.index');
    Route::get('/chat/create/{user}', [ChatRoomController::class, 'createWithUser'])->name('chat.create');
    Route::get('/chat/{uuid}', [ChatRoomController::class, 'show'])->name('chat.show');
    Route::post('/chat/messages', [ChatMessageController::class, 'store'])->name('chat.messages.store');
    Route::post('/chat/{room}/mark-read', [ChatMessageController::class, 'markAsRead'])->name('chat.messages.mark-read');

});

Route::get('/', [FrontendController::class, 'home'])->name('home');
Route::get('/about-us', [FrontendController::class, 'aboutUs'])->name('about-us');
Route::get('/service', [FrontendController::class, 'Service'])->name('service');
Route::get('/contact', [FrontendController::class, 'Contact'])->name('contact');
Route::get('/service-providers', [ServiceController::class, 'searchProviders'])->name('service-providers.search');
Route::get('/service-providers/{id}', [ServiceController::class, 'show'])->name('provider.detail');

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
