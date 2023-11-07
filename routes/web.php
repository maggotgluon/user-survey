<?php

use App\Livewire\Admin\ManageSurvey;
use App\Livewire\Admin\Report;
use App\Livewire\Survey;
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

Route::view('/', 'welcome')->name('home');


// guest 
// view survey
Route::get('/',Survey::class)->name('home');
// survey selector
Route::get('/{id?}/{?loc}',Survey::class)->name('survey');

// admin
// report view
Route::get('/admin/report',Report::class)
->middleware('auth')->name('admin.report');
// defult survey seletor / survey editor
Route::get('/admin/survey',ManageSurvey::class)
->middleware('auth')->name('admin.survey');

require __DIR__.'/web/auth.php';