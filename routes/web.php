<?php


Route::view('/', 'welcome');

// Statuses Routes
Route::get('statuses', 'StatusesController@index')->name('statuses.index');

Route::post('statuses', 'StatusesController@store')->name('statuses.store')->middleware('auth');

//Statuses Routes Likes
Route::post('statuses/{status}/likes', 'StatusLikesController@store')->name('statuses.likes.store')->middleware('auth');
Route::delete('statuses/{status}/likes', 'StatusLikesController@destroy')->name('statuses.likes.destroy')->middleware('auth');

// Routes comments routes

Route::post('statuses/{status}/comments', 'StatusCommentsController@store')->name('statuses.comments.store')->middleware('auth');

// Comments Likes routes
Route::post('comments/{comment}/likes', 'CommentLikesController@store')->name('comments.likes.store')->middleware('auth');
Route::delete('comments/{comment}/likes', 'CommentLikesController@destroy')->name('comments.likes.destroy')->middleware('auth');

//User Routes
Route::get('@{user}', 'UsersController@show')->name('users.show');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
