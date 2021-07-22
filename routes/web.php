<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{AdminUsersController, ComuniController,
    FilesComuniController,
    InfoPointController,
    FilesInfopointController,
    LuoghiInteresseController,
    StruttureRicettiveController,
    ApertureLuoghiInteresseController,
    ApertureStruttureRicettiveController,
    DashboardController,
    EventiController,
    FotoLuoghiInteresseController, 
    FotoStruttureRicettiveController, 
    LingueUserController, NewsController};
use Illuminate\Support\Facades\Auth;

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
/*
Route::get('/', function () {
    return view('welcome');
});
*/

Route::options('/{path}', function(){ 
    return '';
})->where('path', '.*');


Route::get('/comuni/{comuni}/filescomuni', 
[ComuniController::class, 'getComuniFiles'])
    ->name('comuni.getcomunifiles')
    ->where('comuni', '[0-9]+');

Route::get('/comuni/{comuni}/infopoint', 
[ComuniController::class, 'getInfopoint'])
    ->name('comuni.getinfopoint')
    ->where('comuni', '[0-9]+');

Route::get('/infopoint/{infopoint}/filesinfopoint', 
[InfoPointController::class, 'getFilesInfopoint'])
    ->name('infopoint.getfilesinfopoint')
    ->where('comuni', '[0-9]+');

Route::resource('comuni', ComuniController::class)->middleware(['auth', 'VerifyIsAdmin']);
Route::resource('filescomuni', FilesComuniController::class)->middleware(['auth', 'VerifyIsAdmin']);
Route::resource('infopoint', InfoPointController::class);
Route::resource('filesinfopoint', FilesInfopointController::class);
Route::resource('luoghiinteresse', LuoghiInteresseController::class);
Route::resource('strutturericettive', StruttureRicettiveController::class);
Route::resource('apertureluoghiinteresse', ApertureLuoghiInteresseController::class);
Route::resource('fotoluoghiinteresse', FotoLuoghiInteresseController::class);
Route::resource('aperturestrutturericettive', ApertureStruttureRicettiveController::class);
Route::resource('fotostrutturericettive', FotoStruttureRicettiveController::class);
Route::resource('eventi', EventiController::class);
Route::resource('lingueusers', LingueUserController::class);
Route::resource('news', NewsController::class);

/*
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');
*/

Route::resource('dashboard', DashboardController::class)->middleware(['auth']);

require __DIR__.'/auth.php';

Route::resource('users', AdminUsersController::class)->middleware(['auth', 'VerifyIsAdmin']);


Addchat::routes();
