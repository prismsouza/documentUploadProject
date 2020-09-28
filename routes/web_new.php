<?php
/*
 * WHAT TO DO
 * Restore deleted files
 * Improve filter by word/description
 * Super admin access
 */
use Illuminate\Support\Facades\Route;

Route::get('/', 'DocumentsController@index');

Route::get('/admin', 'UsersController@getAdminUsers')->middleware('AuthenticateAdminUser')->name('admin_panel');

Route::match(['post', 'get'],'/admin/mensagens', 'MessagesController@index')->name('messages.index');
Route::get('/admin/mensagens/{message}', 'MessagesController@update')->name('messages.update');

//Route::get('/usuario/documentos', 'DocumentsController@index_user')->name('documents_user.index');
//Route::get('/usuario/documentos/{document}', 'DocumentsController@showUser')->name('documents_user.show');
Route::get('/admin/deletados', 'DocumentsController@showDeletedDocuments')->name('documents.deleted_documents');
Route::post('/admin/deletados/{document}', 'DocumentsController@restore')->name('documents.restore');
Route::get('/admin/logs', 'DocumentsController@logs')->name('documents.logs');
Route::get('/admin/logs_boletim', 'BoletinsController@logs')->name('boletins.logs');
Route::get('/admin/falhas', 'DocumentsController@showFailedDocuments')->name('documents.failed_documents');
Route::get('/admin/boletins/falhas', 'BoletinsController@showFailedBoletins')->name('boletins.failed_boletins');

Route::get('/admin/contato', 'ContactController@index')->name('contacts.index');
Route::post('/admin/contato/save', 'ContactController@store')->name('contacts.store');
Route::get('/admin/contato/novo', 'ContactController@create')->name('contacts.create');

Route::get('/boletins/categorias/{category}', 'DocumentsController@showByCategory')->name('documents_category.index');
//Route::get('/boletins', 'BoletinsController@index')->name('boletins.index');
Route::match(['post', 'get'], '/boletins', 'BoletinsController@index')->name('boletins.index');
Route::post('/boletins/save', 'BoletinsController@store')->name('boletins.store');
Route::get('/boletins/novo', 'BoletinsController@create')->name('boletins.create');
Route::get('/boletins/{boletim}', 'BoletinsController@show')->name('boletins.show');

Route::get('/boletins/{boletim}/editar', 'BoletinsController@edit')->name('boletins.edit');
Route::put('/boletins/{boletim}', 'BoletinsController@update')->name('boletins.update');
Route::delete('/boletins/delete/{boletim}', 'BoletinsController@destroy')->name('boletins.destroy');
Route::get('/boletins/{boletim}/download/{type}', 'BoletinsController@download')->name('boletins.download');
Route::get('/boletins/{boletim}/visualizar/{file_id}', 'BoletinsController@viewfile')->name('boletins.viewfile');

Route::delete('/arquivos/delete/{file}', 'FilesController@destroy')->name('files.destroy');

Route::get('/documentos/categorias/{category}', 'DocumentsController@showByCategory')->name('documents_category.index');

//Route::get('/', 'DocumentsController@index')->name('documents.index');
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
Route::get('/setViewAsAdmin', 'UsersController@setViewAsAdmin')->name('admin.view');
Route::get('/setViewAsUser', 'UsersController@setViewAsUser')->name('user.view');


Route::get('/categorias/ementario/editar', function(){
    return view ('categories.ementario_edit');
})->name('categories.ementario_edit');
Route::put('/', 'FilesController@uploadDetachedFile')->name('categories.ementario_update');
Route::get('/categorias/download/ementario', 'FilesController@download')->name('files.download');
Route::get('/categorias/visualizar/ementario', 'FilesController@viewfile')->name('files.view');

Route::get('/categorias', 'CategoriesController@index')->name('categories.index');
Route::post('/categorias', 'CategoriesController@store')->name('categories.store');;
Route::get('/categorias/novo', 'CategoriesController@create')->name('categories.create');
Route::get('/categorias/{category}', 'CategoriesController@show')->name('categories.show');
Route::get('/categorias/{category}/edit', 'CategoriesController@edit')->name('categories.edit');
Route::put('/categorias/{category}', 'CategoriesController@update')->name('categories.update');
Route::delete('/categorias/delete/{category}', 'CategoriesController@destroy')->name('categories.destroy');

Route::get('/admin', 'UsersController@index')->name('admins.index');
Route::post('/admin', 'UsersController@store')->name('admins.store');;
Route::get('/admin/novo', 'UsersController@create')->name('admins.create');
Route::delete('/admin/delete/{user}', 'UsersController@destroy')->name('admins.destroy');

Route::get('/tags', 'TagsController@index')->name('tags.index');
Route::post('/tags', 'TagsController@store')->name('tags.store');
Route::get('/tags/novo', 'TagsController@create')->name('tags.create');
Route::get('/tags/{tag}', 'TagsController@show')->name('tags.show');
Route::get('/tags/{tag}/edit', 'TagsController@edit')->name('tags.edit');
Route::put('/tags/{tag}', 'TagsController@update')->name('tags.update');
Route::delete('/tags/delete/{tag}', 'TagsController@destroy')->name('tags.destroy');

//Route::any('/documentos','DocumentsController@sort')->name('documents.sort');
Route::any('/mensagens/pesquisa','MessagesController@filter')->name('messages.filter');
Route::post('/documentos/{document}','MessagesController@store')->name('message.store');
Route::get('/documentos/mensagem', 'MessagesController@create')->name('message.create');

Route::get('https://intranet.bombeiros.mg.gov.br')->name('intranet');
