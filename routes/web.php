<?php
/*
 * WHAT TO DO
 * Improve filter by word/description
 */
use Illuminate\Support\Facades\Route;

Route::get('/manutencao', function () {
    return view('manutencao');
});

#---- ADMIN PANEL ----#
Route::get('/admin', 'UsersController@index')->name('admin.index');
Route::get('/admin/deletados', 'DocumentsController@showDeletedDocuments')->name('documents.deleted_documents');
Route::post('/admin/restaurar/{doc}', 'DocumentsController@restore')->name('documents.restore');
Route::get('/admin/logs', 'DocumentsController@logs')->name('documents.logs');
Route::get('/admin/logs_boletim', 'BoletinsController@logs')->name('boletins.logs');
Route::get('/admin/falhas', 'DocumentsController@showFailedDocuments')->name('documents.failed_documents');
Route::get('/admin/boletins/falhas', 'BoletinsController@showFailedBoletins')->name('boletins.failed_boletins');

Route::delete('/arquivos/delete/{file}', 'FilesController@destroy')->name('files.destroy');

#---- DOCUMENTS ----#
Route::get('/home', 'DocumentsController@home')->name('documents.home');
Route::match(['post', 'get'], '/documentos', 'DocumentsController@index')->name('documents.index');
Route::post('/documentos/save', 'DocumentsController@store')->name('documents.store');
Route::get('/documentos/novo', 'DocumentsController@create')->name('documents.create');
Route::get('/documentos/{document}/download/{type}', 'DocumentsController@download')->name('documents.download');
Route::get('/documentos/{document}/visualizar/{file_id}', 'DocumentsController@viewfile')->name('documents.viewfile');
Route::get('/documentos/{document}', 'DocumentsController@show')->name('documents.show');
Route::get('/documentos/{document}/editar', 'DocumentsController@edit')->name('documents.edit');
Route::put('/documentos/{document}', 'DocumentsController@update')->name('documents.update');
Route::delete('/documentos/delete/{document}', 'DocumentsController@destroy')->name('documents.destroy');

Route::get('refresh', 'DocumentsController@refreshSession')->name('documents.refresh_session');
Route::get('refresh_boletim', 'BoletinsController@refreshSession')->name('boletins.refresh_session');
Route::get('refreshindex', 'DocumentsController@refreshSessionIndex')->name('documents.refresh_session_index');


#---- BOLETINS ----#
Route::match(['post', 'get'], '/boletins', 'BoletinsController@index')->name('boletins.index');
Route::post('/boletins/save', 'BoletinsController@store')->name('boletins.store');
Route::get('/boletins/novo', 'BoletinsController@create')->name('boletins.create');
Route::get('/boletins/{boletim}', 'BoletinsController@show')->name('boletins.show');

Route::get('/boletins/{boletim}/editar', 'BoletinsController@edit')->name('boletins.edit');
Route::put('/boletins/{boletim}', 'BoletinsController@update')->name('boletins.update');
Route::delete('/boletins/delete/{boletim}', 'BoletinsController@destroy')->name('boletins.destroy');
Route::get('/boletins/{boletim}/download/{type}', 'BoletinsController@download')->name('boletins.download');
Route::get('/boletins/{boletim}/visualizar/{file_id}', 'BoletinsController@viewfile')->name('boletins.viewfile');

#---- CATEGORIES ----#
Route::get('/categorias', 'CategoriesController@index')->name('categories.index');
Route::post('/categorias/save', 'CategoriesController@store')->name('categories.store');;
Route::get('/categorias/novo', 'CategoriesController@create')->name('categories.create');
Route::get('/categorias/{category}', 'CategoriesController@show')->name('categories.show');
Route::get('/categorias/{category}/editar', 'CategoriesController@edit')->name('categories.edit');
Route::put('/categorias/{category}', 'CategoriesController@update')->name('categories.update');
Route::delete('/categorias/delete/{category}', 'CategoriesController@destroy')->name('categories.destroy');

Route::get('/ementario/editar','EmentarioController@edit')->name('ementario.edit');
Route::post('/ementario', 'EmentarioController@update')->name('ementario.update');
Route::get('/ementario/download', 'EmentarioController@download')->name('ementario.download');
Route::get('/ementario/visualizar', 'EmentarioController@viewfile')->name('ementario.view');

#---- ADMIN ----#
Route::get('/setViewAsAdmin', 'UsersController@setViewAsAdmin')->name('admin.view');
Route::get('/setViewAsUser', 'UsersController@setViewAsUser')->name('user.view');
Route::post('/admin/save', 'UsersController@store')->name('admin.store');
Route::get('/admin/novo', 'UsersController@create')->name('admin.create');
Route::delete('/admin/delete/{user}', 'UsersController@destroy')->name('admin.destroy');

#---- TAGS ----#
Route::get('/tags', 'TagsController@index')->name('tags.index');
Route::post('/tags/save', 'TagsController@store')->name('tags.store');
Route::get('/tags/novo', 'TagsController@create')->name('tags.create');
Route::get('/tags/{tag}', 'TagsController@show')->name('tags.show');
Route::get('/tags/{tag}/editar', 'TagsController@edit')->name('tags.edit');
Route::put('/tags/{tag}', 'TagsController@update')->name('tags.update');
Route::delete('/tags/delete/{tag}', 'TagsController@destroy')->name('tags.destroy');

#---- MESSAGES ----#
Route::match(['post', 'get'],'/admin/mensagens', 'MessagesController@index')->name('messages.index');
Route::get('/admin/mensagens/{message}', 'MessagesController@update')->name('messages.update');
Route::any('/mensagens/pesquisa','MessagesController@filter')->name('messages.filter');
Route::post('/documentos/mensagem/save','MessagesController@store')->name('message.store');
Route::get('/documentos/mensagem', 'MessagesController@create')->name('message.create');

#---- CONTACT US ----#
Route::get('/admin/contato', 'ContactController@index')->name('contacts.index');
Route::post('/admin/contato/save', 'ContactController@store')->name('contacts.store');
Route::get('/admin/contato/novo', 'ContactController@create')->name('contacts.create');
