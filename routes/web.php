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

Route::get('/', function () {
  return view('welcome');
});

Route::get('/test', function () {
  return 'Esta es nuestra nueva ruta';
});

Route::get('/usuario/{nombre}', function ($nombre) {
  return 'El nombre de usuario es '.$nombre;
});

Route::get('/posts', 'PostsController@index')->name('posts.index');
Route::get('/post/{id}', 'PostsController@show')->name('posts.show');
Route::post('/posts', 'PostsController@store');
Route::get('/post/{id}/edit', 'PostsController@edit');
Route::patch('/post/{id}', 'PostsController@update')->name('posts.update');
Route::delete('/post/{id}', 'PostsController@destroy');

Route::get('/profile', 'UserController@profile')->name('user.profile');
Route::patch('/profile', 'UserController@update_profile')->name('user.profile.update');

// Route::post('/comments', 'CommentsController@store')->name('comments.store');
Route::resource('comments', 'CommentsController');

Route::group(['middleware' => ['auth', 'role:administrator'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
  Route::get('/users', 'Admin\UsersController@index')->name('users.index');
  Route::post('/users/active_deactive', 'Admin\UsersController@activeDeactive')->name('users.active_deactive');
  Route::post('/users/change_role', 'Admin\UsersController@changeRole')->name('users.change_role');
});

Route::get('lang/{lang}', function($lang) {
  \Session::put('lang', $lang);
  return \Redirect::back();
})->middleware('web')->name('change_lang');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
