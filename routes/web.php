<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

// Statuses Routes
Route::get('statuses', 'StatusesController@index')->name('statuses.index');

Route::post('statuses', 'StatusesController@store')->name('statuses.store')->middleware('auth');

//Statuses Routes Likes
Route::post('statuses/{status}/likes', 'StatusLikesController@store')->name('statuses.likes.store')->middleware('auth');
Route::delete('statuses/{status}/likes', 'StatusLikesController@destroy')->name('statuses.likes.destroy')->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
