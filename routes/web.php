<?php

use Illuminate\Support\Facades\Route;

/*Route::get('/', function () {
    $categories = \App\Category::all();
    return view('home', ['categories' => $categories]);
})->name('documents.home');*/

Route::get('/admin', function () {
    return view('admin_panel');
})->name('admin_panel');
Route::get('/admin/mensagens', 'MessagesController@index')->name('messages.index');
Route::get('/admin/mensagens/{message}', 'MessagesController@update')->name('messages.is_checked');


Route::get('/documentos/categorias/{category}', 'DocumentsController@showByCategory')->name('documents_category.index');
Route::get('/', 'DocumentsController@index')->name('documents.index');
Route::get('/documentos', 'DocumentsController@index')->name('documents.index');
Route::post('/documentos', 'DocumentsController@store');
Route::get('/documentos/novo', 'DocumentsController@create');
Route::post('/documentos/categorias/Boletim Geral', 'DocumentsController@store_bgbm')->name('documents.bgbm');;
Route::get('/documentos/novo/bgbm', 'DocumentsController@create_bgbm');
Route::get('/documentos/{document}/download/{type}', 'DocumentsController@download')->name('documents.download');
Route::get('/documentos/{document}/visualizar', 'DocumentsController@viewfile')->name('documents.viewfile');
Route::get('/documentos/{document}', 'DocumentsController@show')->name('documents.show');
Route::get('/documentos/{document}/editar', 'DocumentsController@edit')->name('documents.edit');
Route::put('/documentos/{document}', 'DocumentsController@update');
Route::delete('/documentos/delete/{document}', 'DocumentsController@destroy')->name('documents.destroy');

Route::get('/categorias', 'CategoriesController@index')->name('categories.index');
Route::post('/categorias', 'CategoriesController@store');
Route::get('/categorias/novo', 'CategoriesController@create');
Route::get('/categorias/{category}', 'CategoriesController@show')->name('categories.show');
Route::get('/categorias/{category}/edit', 'CategoriesController@edit');
Route::put('/categorias/{category}', 'CategoriesController@update');

Route::get('/tags', 'TagsController@index')->name('tags.index');
Route::post('/tags', 'TagsController@store');
Route::get('/tags/novo', 'TagsController@create');
Route::get('/tags/{tag}', 'TagsController@show')->name('tags.show');

Route::any('/documentos/pesquisa','DocumentsController@filter')->name('documents.filter');

Route::post('/documentos/{document}','MessagesController@store')->name('message.report');
Route::get('/documentos/mensagem', 'MessagesController@create');



function dumpArray($array) {
    echo "<pre>";
    var_dump($array);
    echo "</pre>";
}
