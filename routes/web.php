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

Route::get('/', function () {
    return view('welcome');
})->name('welcome');
Route::get('/create', 'App\Http\Controllers\PassController@create')->name('createpass');
Route::post('/print', 'App\Http\Controllers\PassController@print')->name('printpass');

Auth::routes();

//Dashboard
Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');
Route::get('/home/{bus}/load', 'App\Http\Controllers\HomeController@loadbus')->name('loadbus');
Route::get('/home/{bus}/setoff', 'App\Http\Controllers\HomeController@setoffbus')->name('setoffbus');
Route::get('/home/{bus}/park', 'App\Http\Controllers\HomeController@parkbus')->name('parkbus');

//Routes and stops
Route::get('/routes', 'App\Http\Controllers\RoutesController@index')->name('routes');
Route::post('/routes/add', 'App\Http\Controllers\RoutesController@add')->name('addroute');
Route::post('/routes/{route}/update', 'App\Http\Controllers\RoutesController@update')->name('updateroute');
Route::get('/routes/{route}/delete', 'App\Http\Controllers\RoutesController@delete')->name('deleteroute');
Route::get('/routes/{route}/stops', 'App\Http\Controllers\StopsController@index')->name('stops');
Route::post('/routes/{route}/stops/add', 'App\Http\Controllers\StopsController@add')->name('addstop');
Route::post('/routes/{route}/stops/{stop}/update', 'App\Http\Controllers\StopsController@update')->name('updatestop');
Route::get('/routes/{route}/stops/{stop}/delete', 'App\Http\Controllers\StopsController@delete')->name('deletestop');

//Buses
Route::get('/buses', 'App\Http\Controllers\BusesController@index')->name('buses');
Route::post('/buses/add', 'App\Http\Controllers\BusesController@add')->name('addbus');
Route::get('/buses/{plate}/delete', 'App\Http\Controllers\BusesController@delete')->name('deletebus');
Route::post('/buses/{plate}/update', 'App\Http\Controllers\BusesController@update')->name('updatebus');

//staff
Route::get('/staff', 'App\Http\Controllers\StaffController@index')->name('staff');
Route::post('/staff/add', 'App\Http\Controllers\StaffController@add')->name('addstaff');
Route::get('/staff/{staff}/delete', 'App\Http\Controllers\StaffController@delete')->name('deletestaff');
Route::post('/staff/{staff}/update', 'App\Http\Controllers\StaffController@update')->name('updatestaff');

//Passes
Route::get('/pass', 'App\Http\Controllers\PassesController@index')->name('passes');


Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});

Route::group(['middleware' => 'auth'], function () {
	Route::get('{page}', ['as' => 'page.index', 'uses' => 'App\Http\Controllers\PageController@index']);
});

