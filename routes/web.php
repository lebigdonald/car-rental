<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

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

Route::get('/fix-storage', function () {
    Artisan::call('storage:link');
    return 'Storage link created';
});


Route::get('/migrate-seed', function () {
    Artisan::call('migrate:refresh --seed');
    return 'Migration and Seeders created';
});

Route::get('/', [PageController::class, 'home'])->name('home.index');

// Car(s) routes
Route::get('/voitures', [CarController::class, 'index'])->name('car.index');
Route::get('/voitures/{id}', [CarController::class, 'show'])->name('car.show');

// About route
Route::view('/a-propos', 'apropos')->name('about.show');

// Contact route
Route::view('/contacts', 'contacts')->name('contacts.show');
Route::post('/contacts', [ContactController::class, 'send'])->name('contacts.send');

Route::group(['middleware' => ['guest']], function () {
    // Register routes
    Route::get('/inscription', [AuthController::class, 'show_register'])->name('register.show');
    Route::post('/inscription', [AuthController::class, 'register'])->name('register.perform');

    // Login routes
    Route::get('/connexion', [AuthController::class, 'show_login'])->name('login.show');
    Route::post('/connexion', [AuthController::class, 'login'])->name('login.perform');
});

Route::group(['middleware' => ['auth']], function () {

    // Logout routes
    Route::get('/deconnexion', [AuthController::class, 'logout'])->name('logout.perform');

    // Users routes
    Route::get('/profil', [UserController::class, 'show'])->name('user.show');
    Route::put('/profil', [UserController::class, 'update'])->name('user.update');

    // Rent routes
    Route::get('/historique', [RentController::class, 'index'])->name('rent.index');
    Route::post('/voitures/{id}/louer', [RentController::class, 'store'])->name('rent.store');
    Route::delete('/location/supprimer/{id}', [RentController::class, 'destroy'])->name('rent.destroy');
    Route::get('/facture/{id}', [RentController::class, 'invoice'])->name('rent.invoice');
});


Route::group(['prefix' => 'admin'], function () {
    // Register routes
    Route::get('/inscription', [AdminAuthController::class, 'show_register'])->name('admin.register.show');
    Route::post('/inscription', [AdminAuthController::class, 'register'])->name('admin.register.perform');

    // Login routes
    Route::get('/connexion', [AdminAuthController::class, 'show_login'])->name('admin.login.show');
    Route::post('/connexion', [AdminAuthController::class, 'login'])->name('admin.login.perform');

    Route::group(['middleware' => ['adminauth']], function () {
        // Logout routes
        Route::get('/deconnexion', [AdminAuthController::class, 'logout'])->name('admin.logout.perform');

        // Admin home
        Route::get('/', [AdminController::class, 'index'])->name('admin.home');
        Route::get('/create', [AdminController::class, 'createAdmin'])->name('admin.create');
        Route::post('/create', [AdminController::class, 'storeAdmin'])->name('admin.store');

        //Admin cars
        Route::get('/voitures', [CarController::class, 'index'])->name('admin.car.index');
        Route::get('/voitures/{id}', [CarController::class, 'show'])->where('id', '[0-9]+')->name('admin.car.show');
        Route::get('/voitures/create', [CarController::class, 'create'])->name('admin.car.create');
        Route::post('/voitures/create', [CarController::class, 'store'])->name('admin.car.store');
        Route::get('/voitures/edit/{id}', [CarController::class, 'edit'])->name('admin.car.edit');
        Route::put('/voitures/edit/{id}', [CarController::class, 'update'])->name('admin.car.update');
        Route::delete('/voitures/delete/{id}', [CarController::class, 'destroy'])->name('admin.car.destroy');

        //Admin rents
        Route::get('/locations', [RentController::class, 'index'])->name('admin.rent.index');
        Route::get('/locations/{id}', [RentController::class, 'show'])->where('id', '[0-9]+')->name('admin.rent.show');
        Route::get('/locations/edit/{id}', [RentController::class, 'edit'])->where('id', '[0-9]+')->name('admin.rent.edit');
        Route::put('/locations/edit/{id}', [RentController::class, 'update'])->where('id', '[0-9]+')->name('admin.rent.update');
        Route::delete('/locations/destroy/{id}', [RentController::class, 'destroy'])->where('id', '[0-9]+')->name('admin.rent.destroy');
        Route::post('/locations/approve/{id}', [RentController::class, 'approve'])->where('id', '[0-9]+')->name('admin.rent.approve');
        Route::post('/locations/reject/{id}', [RentController::class, 'reject'])->where('id', '[0-9]+')->name('admin.rent.reject');
        Route::get('/locations/facture/{id}', [RentController::class, 'invoice'])->where('id', '[0-9]+')->name('admin.rent.invoice');


        //Admin users
        Route::get('/utilisateurs', [UserController::class, 'index'])->name('admin.user.index');
        Route::get('/utilisateurs/{id}', [UserController::class, 'show'])->name('admin.user.show');
        Route::get('/utilisateurs/edit/{id}', [UserController::class, 'edit'])->name('admin.user.edit');
        Route::put('/utilisateurs/edit/{id}', [UserController::class, 'update'])->name('admin.user.update');
    });
});
