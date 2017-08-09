<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::get('/', function () {
  if(Auth::user()) {
    return redirect()->route('dashboard');
  }
  return view('welcome');
})->name('home');

Route::post('/signup', [
    'uses' => 'UserController@postSignUp',
    'as' => 'signup'
]);

Route::post('/signin', [
    'uses' => 'UserController@postSignIn',
    'as' => 'signin'
]);

Route::get('/logout', [
    'uses' => 'UserController@getLogout',
    'as' => 'logout',
    'middleware' => 'auth'
]);

Route::get('/account', [
    'uses' => 'UserController@getAccount',
    'as' => 'account',
    'middleware' => 'auth'
]);

Route::post('/upateaccount', [
    'uses' => 'UserController@postSaveAccount',
    'as' => 'account.save',
    'middleware' => 'auth'
]);

Route::get('/userimage/{filename}', [
    'uses' => 'UserController@getUserImage',
    'as' => 'account.image',
    'middleware' => 'auth'
]);

Route::get('/dashboard', [
    'uses' => 'PostController@getDashboard',
    'as' => 'dashboard',
    'middleware' => 'auth'
]);

Route::get('/postimage/{filename}', [
    'uses' => 'PostController@getPostImage',
    'as' => 'post.image',
    'middleware' => 'auth'
]);

Route::get('/users/{user_id}', [
  'uses' => 'PostController@getUserPage',
  'as' => 'userpage',
  'middleware' => 'auth'
]);

Route::post('/createpost', [
    'uses' => 'PostController@postCreatePost',
    'as' => 'post.create',
    'middleware' => 'auth'
]);

Route::get('/delete-post/{post_id}', [
    'uses' => 'PostController@getDeletePost',
    'as' => 'post.delete',
    'middleware' => 'auth'
]);

Route::post('/edit', [
    'uses' => 'PostController@postEditPost',
    'as' => 'edit',
    'middleware' => 'auth'
]);

Route::post('/like', [
    'uses' => 'PostController@postLikePost',
    'as' => 'like',
    'middleware' => 'auth'
]);

Route::post('/createcomment', [
   'uses' => 'PostController@postCreateComment',
   'as' => 'comment.create',
   'middleware' => 'auth'
]);

Route::get('/events', [
   'uses' => 'EventController@getEvent',
   'as' => 'events',
   'middleware' => 'auth'
]);

Route::post('/createevent', [
   'uses' => 'EventController@postcreateEvent',
   'as' => 'event.create',
   'middleware' => 'auth'
]);

Route::get('/delete-event/{event_id}', [
    'uses' => 'EventController@getDeleteEvent',
    'as' => 'event.delete',
    'middleware' => 'auth'
]);

Route::post('/going', [
    'uses' => 'EventController@postGoingEvent',
    'as' => 'going',
    'middleware' => 'auth'
]);

Route::get('/books', [
    'uses' => 'BookController@getBooks',
    'as' => 'books',
    'middleware' => 'auth'
]);

Route::get('/bookimage/{filename}', [
    'uses' => 'BookController@getBookImage',
    'as' => 'book.image',
    'middleware' => 'auth'
]);

Route::post('/createbook', [
    'uses' => 'BookController@postCreateBook',
    'as' => 'book.create',
    'middleware' => 'auth'
]);

Route::get('/delete-book/{book_id}', [
    'uses' => 'BookController@getDeleteBook',
    'as' => 'book.delete',
    'middleware' => 'auth'
]);

Route::get('/opinions', [
   'uses' => 'OpinionController@getOpinions',
   'as' => 'opinions',
   'middleware' => 'auth'
]);

Route::post('/opinion', [
    'uses' => 'OpinionController@postCreateOpinion',
    'as' => 'opinion',
    'middleware' => 'auth'
]);

Route::get('/restaurants', [
   'uses' => 'RestaurantController@getRestaurants',
   'as' => 'restaurants',
   'middleware' => 'auth'
]);

Route::post('/createrestaurant', [
    'uses' => 'RestaurantController@postCreateRestaurant',
    'as' => 'restaurant.create',
    'middleware' => 'auth'
]);

Route::get('/delete-restaurant/{restaurant_id}', [
    'uses' => 'RestaurantController@getDeleteRestaurant',
    'as' => 'restaurant.delete',
    'middleware' => 'auth'
]);
