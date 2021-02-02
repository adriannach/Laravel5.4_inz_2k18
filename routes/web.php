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

/*
Route::get('/', function () {
    return view('welcome');
});
*/

Route::get('/', 'TutorialsController@index');
Route::get('tutorials', 'TutorialsController@index')->name('tutorials.index');
Route::post('tutorials', 'TutorialsController@store');

Route::get('/tutorial/{id}', 'TutorialsController@show')->name('tutorials.id');
Route::get('/tutorials/my_tutorials}', 'TutorialsController@my')->name('tutorials.my')->middleware('auth');

Route::get('/tutorials/create_tutorial', 'TutorialsController@addTutorial')->middleware('auth');//post aby przekazywane dane nie były widowczne
Route::get('/tutorial/{id}/edit', 'TutorialsController@edit');
Route::put('/tutorial/{id}', 'TutorialsController@change')->name('tutorials.change');

Route::delete('/tutorial/{id}', 'TutorialsController@deleteT')->name('tutorial.delete');

Route::resource('subscriptions', 'SubscriptionController');
Route::get('/notifictions', 'SubscriptionController@index')->name('tutorials.subscribe');

Route::get('/user_account', 'UserController@user_account')->name('user.account');
Route::put('/user_account', 'UserController@account_edit')->name('user.account.edit')->middleware('auth');
Route::get('/user_show/{id}', 'UserController@show')->name('user.show');

Route::resource('comments', 'CommentsController');
Route::resource('votes', 'VotesController');

Route::get('/tutorials/category/{id}', 'TutorialsController@category')->name('tutorial.category');

Route::get('/zero', function () {
    Auth::user()->unreadNotifications->markAsRead();
});

Route::group(['middleware' => ['auth', 'role:administrator'], 'prefix' => 'admin', 'as' => 'admin.'] , function () {
  Route::get('/users', 'AdminUsersController@index')->name('users.index');
  Route::post('/users/active', 'AdminUsersController@activate')->name('users.activate');
  Route::post('/users/role', 'AdminUsersController@UpdateRole')->name('users.role');
});

Route::get('auth/{provider}', 'Auth\RegisterController@FromTheProvider');
Route::get('auth/{provider}/callback', 'Auth\RegisterController@FeedbackData');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/logout', 'TutorialsController@index');

Route::resource('contact', 'ContactController');
