<?php

use Illuminate\Support\Facades\Route;

/*Route::get('/', function () {
    $categories = \App\Category::all();
    return view('home', ['categories' => $categories]);
})->name('documents.home');*/

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

Route::any('/pesquisa','DocumentsController@filter')->name('documents.filter');
Route::get('/resultados', 'DocumentsController@index')->name('documents.index');
Route::get('/documentos/{document}', 'DocumentsController@show')->name('documents.show');
Route::get('/documentos/{document}/download/{type}', 'DocumentsController@download')->name('documents.download');


/*
Route::get('/admin', function () {
    return view('admin_panel');
})->name('admin_panel');
Route::get('/mensagens', 'MessagesController@index')->name('messages.index');
Route::get('/mensagens/{message}', 'MessagesController@update')->name('messages.update');


Route::get('/documentos/categorias/{category}', 'DocumentsController@showByCategory')->name('documents_category.index');
Route::get('/', 'DocumentsController@index')->name('documents.index');
Route::get('/documentos', 'DocumentsController@index')->name('documents.index');
Route::post('/documentos', 'DocumentsController@store')->name('documents.store');
Route::get('/documentos/novo', 'DocumentsController@create')->name('documents.create');
Route::post('/documentos/categorias/Boletim Geral', 'DocumentsController@store_bgbm')->name('documents.bgbm');
Route::get('/documentos/novo/bgbm', 'DocumentsController@create_bgbm')->name('documents.create_bgbm');
Route::get('/documentos/{document}/download/{type}', 'DocumentsController@download')->name('documents.download');
Route::get('/documentos/{document}/visualizar', 'DocumentsController@viewfile')->name('documents.viewfile');
Route::get('/documentos/{document}', 'DocumentsController@show')->name('documents.show');
Route::get('/documentos/{document}/editar', 'DocumentsController@edit')->name('documents.edit');
Route::put('/documentos/{document}', 'DocumentsController@update')->name('documents.update');
Route::delete('/documentos/delete/{document}', 'DocumentsController@destroy')->name('documents.destroy');

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
*/
function dumpArray($array) {
    echo "<pre>";
    var_dump($array);
    echo "</pre>";
}
