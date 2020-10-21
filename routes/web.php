<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Auth;
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
Route::view('/', 'home');
Route::get('search', 'SearchController@post')->name('search.posts');
Route::prefix('posts')->middleware('auth')->group(function(){
    Route::get('/', 'PostController@index')->name('posts.index')->withoutMiddleware('auth');
    
    Route::get('/create', 'PostController@create')->name('posts.create');
    Route::post('/store', 'PostController@store');
    
    Route::get('/{post:slug}/edit', 'PostController@edit');
    Route::patch('/{post:slug}/edit', 'PostController@update');

    Route::delete('/{post:slug}/delete', 'PostController@destroy');
    
    Route::get('/{post:slug}', 'PostController@show')->withoutMiddleware('auth');
});
Route::get('categories/{category:slug}','CategoryController@show');

//put = edit seluruh field
//patch = edit sebagian field

Route::view('about', 'about');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
