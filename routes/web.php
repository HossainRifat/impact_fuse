<?php


use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MediaGalleryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\RoleController;
use App\Http\Middleware\LanguageMiddleware;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleAssignController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\EventCategoryController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RolePermissionAssociationController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SettingController;

Route::get('dash', [UserController::class, 'dashboard'])->name('invoice');

Route::middleware(LanguageMiddleware::class)->group(function () {
    Route::post('switch-language', [DashboardController::class, 'switchLanguage'])->name('dashboard.switch-language');
    Route::group(['middleware' => 'auth'], static function () {
        Route::post('switch-theme', [DashboardController::class, 'switchTheme'])->name('dashboard.switch-theme');
        Route::group(['prefix' => 'my-account'], static function () {
            Route::get('/', [UserController::class, 'create'])->name('profile.create')->middleware('permission:profile.create');
            Route::post('/', [UserController::class, 'store'])->name('profile.store')->middleware('permission:profile.store');
            Route::get('change-password', [PasswordController::class, 'changePassword'])->name('change-password');
            Route::post('update-password', [PasswordController::class, 'updatePassword'])->name('update-password');
        });

        Route::post('get_media_library', [MediaGalleryController::class, 'get_media_library'])->name('get_media_library')->middleware('permission:get_media_library');
        Route::post('create_new_directory', [MediaGalleryController::class, 'create_new_directory'])->name('create_new_directory')->middleware('permission:create_new_directory');
        Route::post('upload_media_library', [MediaGalleryController::class, 'upload_media_library'])->name('upload_media_library')->middleware('permission:upload_media_library');
        Route::post('delete_media_library', [MediaGalleryController::class, 'delete_media_library'])->name('delete_media_library')->middleware('permission:delete_media_library');

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('role', RoleController::class);
        Route::resource('permission', PermissionController::class);
        Route::resource('role-assign', RoleAssignController::class);
        Route::resource('role-permission-association', RolePermissionAssociationController::class);
        Route::resource('menu', MenuController::class);

        Route::resource('user', UserController::class);
        Route::resource('blog-category', BlogCategoryController::class);
        Route::resource('blog', BlogController::class);
        Route::resource('service', ServiceController::class);
        Route::resource('event-category', EventCategoryController::class);
        Route::resource('event', EventController::class);
        Route::resource('page', PageController::class);
        Route::get('web-credentials', [SettingController::class, 'index_credentials'])->name('setting.index_credentials');
        Route::resource('setting', SettingController::class);
    });
});


require __DIR__ . '/auth.php';
