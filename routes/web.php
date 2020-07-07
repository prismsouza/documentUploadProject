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

Route::get('/upload', 'UploadController@uploadForm');
Route::post('/upload', 'UploadController@uploadSubmit');

Route::get('/admin', function () {
    return view('admin_panel');
})->name('admin_panel');
Route::get('/mensagens', 'MessagesController@index')->name('messages.index');
Route::get('/mensagens/{message}', 'MessagesController@update')->name('messages.update');

Route::get('/usuario/documentos', 'DocumentsController@index_user')->name('documents_user.index');
Route::get('/usuario/documentos/{document}', 'DocumentsController@showUser')->name('documents_user.show');
Route::get('/admin/deletados', 'DocumentsController@showDeletedDocuments')->name('documents.deleted_documents');


Route::get('/boletins/categorias/{category}', 'DocumentsController@showByCategory')->name('documents_category.index');
Route::get('/boletins', 'BoletinsController@index')->name('boletins.index');
Route::get('/boletins/novo', 'BoletinsController@create')->name('boletins.create');
Route::post('/boletins', 'BoletinsController@store')->name('boletins.store');
Route::get('/boletins/{boletim}', 'BoletinsController@show')->name('boletins.show');
Route::get('/boletins/{boletim}/editar', 'BoletinsController@edit')->name('boletins.edit');
Route::put('/boletins/{boletim}', 'BoletinsController@update')->name('boletins.update');
Route::delete('/boletins/delete/{boletim}', 'BoletinsController@destroy')->name('boletins.destroy');
Route::get('/boletins/{boletim}/download/{type}', 'BoletinsController@download')->name('boletins.download');
Route::get('/boletins/{boletim}/visualizar/{file_id}', 'BoletinsController@viewfile')->name('boletins.viewfile');




Route::get('/documentos/categorias/{category}', 'DocumentsController@showByCategory')->name('documents_category.index');
Route::get('/', 'DocumentsController@home')->name('home');
Route::get('/usuario', 'DocumentsController@home_user')->name('home_user');
Route::get('/documentos', 'DocumentsController@index')->name('documents.index');
Route::post('/documentos', 'DocumentsController@store')->name('documents.store');
Route::get('/documentos/novo', 'DocumentsController@create')->name('documents.create');
//Route::post('/documentos/categorias/BGBM', 'DocumentsController@store_boletim')->name('documents.boletim');
//Route::get('/documentos/novo/BGBM', 'DocumentsController@create_boletim')->name('documents.create_boletim');
Route::get('/documentos/{document}/download/{type}', 'DocumentsController@download')->name('documents.download');
Route::get('/documentos/{document}/visualizar/{file_id}', 'DocumentsController@viewfile')->name('documents.viewfile');
Route::get('/documentos/{document}', 'DocumentsController@show')->name('documents.show');
Route::get('/documentos/{document}/editar', 'DocumentsController@edit')->name('documents.edit');
Route::put('/documentos/{document}', 'DocumentsController@update')->name('documents.update');
//Route::get('/documentos/boletim/{document}/editar', 'DocumentsController@edit_boletim')->name('documents_boletim.edit');
//Route::put('/documentos/boletim/{document}', 'DocumentsController@update_boletim')->name('documents_boletim.update');
Route::delete('/documentos/delete/{document}', 'DocumentsController@destroy')->name('documents.destroy');
Route::get('home', 'DocumentsController@restore')->name('documents.restore');

Route::get('/categorias', 'CategoriesController@index')->name('categories.index');
Route::post('/categorias', 'CategoriesController@store')->name('categories.store');;
Route::get('/categorias/novo', 'CategoriesController@create')->name('categories.create');
Route::get('/categorias/{category}', 'CategoriesController@show')->name('categories.show');
Route::get('/categorias/{category}/edit', 'CategoriesController@edit')->name('categories.edit');
Route::put('/categorias/{category}', 'CategoriesController@update')->name('categories.update');
Route::delete('/categorias/delete/{category}', 'CategoriesController@destroy')->name('categories.destroy');

Route::get('/tags', 'TagsController@index')->name('tags.index');
Route::post('/tags', 'TagsController@store')->name('tags.store');
Route::get('/tags/novo', 'TagsController@create')->name('tags.create');
Route::get('/tags/{tag}', 'TagsController@show')->name('tags.show');
Route::get('/tags/{tag}/edit', 'TagsController@edit')->name('tags.edit');
Route::put('/tags/{tag}', 'TagsController@update')->name('tags.update');
Route::delete('/tags/delete/{tag}', 'TagsController@destroy')->name('tags.destroy');

Route::any('/documentos/pesquisa','DocumentsController@filter')->name('documents.filter');
Route::any('/mensagens/pesquisa','MessagesController@filter')->name('messages.filter');

Route::post('/documentos/{document}','MessagesController@store')->name('message.store');
Route::get('/documentos/mensagem', 'MessagesController@create')->name('message.create');



/*
Route::get('/versao2', function () {
    return view('search.searchview');
})->name('searchview');

Route::get('/versao2/pesquisa', function () {
    return view('search.search');
})->name('search');

Route::get('/versao2/pesquisa_tema', function () {
    return view('search.search-theme');
})->name('search-theme');

Route::get('/versao2/pesquisa_avancada', function () {
    return view('search.search-advanced');
})->name('search-advanced');

*/
