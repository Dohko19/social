<?php


Route::view('/', 'welcome');

// Statuses Routes
Route::get('statuses', 'StatusesController@index')->name('statuses.index');
Route::get('statuses/{status}', 'StatusesController@show')->name('statuses.show');
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

//User statuses route
Route::get('users/{user}/statuses', 'UsersStatusController@index')->name('users.statuses.index');

// Friends routes
Route::get('friends', 'FriendsController@index')->name('friends.index')->middleware('auth');

//Rutas Amistades
Route::get('friendships/{recipient}', 'FriendShipsController@show')->name('friendships.show')->middleware('auth');
Route::post('friendship/{recipient}', 'FriendShipsController@store')->name('friendships.store')->middleware('auth');
Route::delete('friendship/{user}', 'FriendShipsController@destroy')->name('friendships.destroy')->middleware('auth');

//Accept Friendship routes
Route::get('friends/requests', 'AcceptFriendshipsController@index')->name('accept-friendships.index')->middleware('auth');
Route::post('accept-friendships/{sender}', 'AcceptFriendshipsController@store')->name('accept-friendships.store')->middleware('auth');
Route::delete('accept-friendships/{sender}', 'AcceptFriendshipsController@destroy')->name('accept-friendships.destroy')->middleware('auth');

//Notification Routes
Route::get('notifications', 'NotificationsController@index')->name('notifications.index')->middleware('auth');

//Read Notification Routes
Route::post('read-notifications/{notification}', 'ReadNotificationsController@store')->name('read-notifications.store')->middleware('auth');
Route::delete('read-notifications/{notification}', 'ReadNotificationsController@destroy')->name('read-notifications.destroy')->middleware('auth');

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

