<?php

use App\Http\Controllers\HouseController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Guest\PageController as GuestPageController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\SponsorshipController;

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

Route::get('/', [GuestPageController::class, 'index'])->name('guest.home');


Route::middleware(['auth', 'verified'])
  ->prefix('admin')
  ->name('admin.')
  ->group(function () {

    Route::get('/', [AdminPageController::class, 'index'])->name('home');
    Route::get('/houses/trash', [HouseController::class, 'trash'])->name('houses.trash.index');
    Route::patch('/houses/trash/{house}/restore', [HouseController::class, 'restore'])->name('houses.trash.restore');
    Route::delete('/houses/trash/{house}', [HouseController::class, 'forceDestroy'])->name('houses.trash.force-destroy');
    Route::resource('houses', HouseController::class);
  
  Route::get('/houses/{house}/sponsorship', [SponsorshipController::class, 'selectSponsorship'])->name('houses.sponsorship');
  Route::post('/houses/{house}/sponsorship/payment', [SponsorshipController::class, 'payment'])->name('sponsorship.payment');

    Route::get('/houses/{house}/gallery', [GalleryController::class, 'index'])->name('gallery.index');
  });

require __DIR__ . '/auth.php';
