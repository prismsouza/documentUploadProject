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

Route::get('/documentos/categorias/{theme}', 'DocumentsController@showByTheme')->name('documents_theme.index');
Route::get('/documentos', 'DocumentsController@index')->name('documents.index');
Route::post('/documentos', 'DocumentsController@store');
Route::get('/documentos/upload', 'DocumentsController@create');
Route::get('/documentos/{document}/download', 'DocumentsController@download')->name('documents.download');
Route::get('/documentos/{document}', 'DocumentsController@show')->name('documents.show');
Route::get('/documentos/{document}/edit', 'DocumentsController@edit');
Route::put('/documentos/{document}', 'DocumentsController@update');
Route::delete('/documentos/{document}', 'DocumentsController@destroy');

Route::get('/categorias', 'ThemesController@index')->name('themes.index');
Route::post('/categorias', 'ThemesController@store');
Route::get('/categorias/create', 'ThemesController@create');
Route::get('/categorias/{theme}', 'ThemesController@show')->name('themes.show');
Route::get('/categorias/{theme}/edit', 'ThemesController@edit');
Route::put('/categorias/{theme}', 'ThemesController@update');

