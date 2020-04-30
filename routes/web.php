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

Route::get('/', function () {
    $themes = \App\Theme::all();
    return view('home', ['themes' => $themes]);
})->name('documents.home');

Route::get('/documents/themes/{theme}', 'DocumentsController@showByTheme')->name('documents_theme.index');
Route::get('/documents', 'DocumentsController@index')->name('documents.index');
Route::post('/documents', 'DocumentsController@store');
Route::get('/documents/upload', 'DocumentsController@create');
Route::get('/documents/{document}', 'DocumentsController@show')->name('documents.show');
Route::get('/documents/{document}/edit', 'DocumentsController@edit');
Route::put('/documents/{document}', 'DocumentsController@update');
Route::delete('/documents/{document}', 'DocumentsController@destroy');

Route::get('/themes', 'ThemesController@index')->name('themes.index');
Route::post('/themes', 'ThemesController@store');
Route::get('/themes/create', 'ThemesController@create');
Route::get('/themes/{theme}', 'ThemesController@show')->name('themes.show');
Route::get('/themes/{theme}/edit', 'ThemesController@edit');
Route::put('/themes/{theme}', 'ThemesController@update');

