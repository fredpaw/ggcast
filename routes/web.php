<?php

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

Auth::routes();

Route::get('/', 'FrontendController@welcome');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/series/{series}', 'FrontendController@series')->name('series');
Route::get('/register/confirm', 'ConfirmEmailController@index')->name('confirm-email');
Route::get('/series', 'FrontendController@showAllseries')->name('all-series');

Route::middleware('auth')->group(function() {
	Route::post('/card/update', 'ProfilesController@updateCard');
	Route::post('/subscribe', 'SubscriptionsController@subscribe');
	Route::post('/subscription/change', 'SubscriptionsController@change')->name('subscriptions.change');
	Route::get('/profile/{user}', 'ProfilesController@index')->name('profile');
	Route::get('/subscribe', 'SubscriptionsController@showSubscriptionForm');
	Route::get('/watch-series/{series}', 'WatchSeriesController@index')->name('series.learning');
	Route::get('/series/{series}/lesson/{lesson}', 'WatchSeriesController@showLesson')->name('series.watch');
	Route::post('/series/complete_lesson/{lesson}', 'WatchSeriesController@completeLesson'); 
	Route::get('/logout', function() { auth()->logout(); return redirect('/'); });
});
