<?php

use Illuminate\Support\Facades\Route;
use Request;

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
    $categories = \App\Category::all();
    return view('home', ['categories' => $categories]);
})->name('documents.home');

Route::any('/documentos/pesquisar/{word}','DocumentsController@search')->name('documents.search');

Route::get('/documentos/categorias/{category}', 'DocumentsController@showByCategory')->name('documents_category.index');
Route::get('/documentos', 'DocumentsController@index')->name('documents.index');
Route::post('/documentos', 'DocumentsController@store');
Route::get('/documentos/novo', 'DocumentsController@create');
Route::get('/documentos/{document}/download', 'DocumentsController@download')->name('documents.download');
Route::get('/documentos/{document}/visualizar', 'DocumentsController@viewfile')->name('documents.viewfile');
Route::get('/documentos/{document}', 'DocumentsController@show')->name('documents.show');
Route::get('/documentos/{document}/editar', 'DocumentsController@edit');
Route::put('/documentos/{document}', 'DocumentsController@update');
Route::delete('/documentos/{document}', 'DocumentsController@destroy');

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

function dumpArray($array) {
    echo "<pre>";
    var_dump($array);
    echo "</pre>";
}

/*Route::any('/search',function(){
    $word = Request::get('word');
    $documents = App\Document::where('name','LIKE','%'.$word.'%')->get();
    return view('documents.index', ['documents' => $documents, 'category_option' => null])->withDetails($documents)->withQuery($word);
    //return view ('documents.index')->withMessage("Nada foi encontrado.<br>Tente pesquisar novamente");
});*/
