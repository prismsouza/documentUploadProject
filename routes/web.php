<?php

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

Route::get('/documents', function () {
    return view('home');
});

Route::get('/home', function () {
    return view('home');
});

Route::get('/documents', 'DocumentsController@index');//->name('documents.index');
Route::post('/documents', 'DocumentsController@store');
Route::get('/documents/create', 'DocumentsController@create');
Route::get('/documents/{document}', 'DocumentsController@show');//->name('articles.show');
Route::get('/documents/{document}/edit', 'DocumentsController@edit');
Route::put('/documents/{document}', 'DocumentsController@update');

