<?php

namespace App\Http\Controllers;

use App\Boletim;
use App\Document;
use App\Helpers\CollectionHelper;
use App\Http\Requests\DocumentCreateRequest;
use App\Http\Requests\DocumentUpdateRequest;
use App\Log;
use App\Tag;
use App\Category;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;

include "DocumentsFilterHelper.php";
include "SortHelper.php";
include "LogsHelper.php";

class DocumentsController extends Controller
{
    public function index(Request $request)
    {
        if (Session::has('admin')) {
            User::setViewAsUser();
        }
        $documents = getFilteredDocuments($request);
        $documents = getOrderedDocuments($request, $documents);
        $documents = CollectionHelper::paginate($documents , count($documents), CollectionHelper::perPage());
        return view('documents.index', ['documents' => $documents, 'category_option' => null, 'admin' => Session::get('admin')]);
    }

    public function sessionRefresh()
    {
        $session_admin = Session::get('admin');
        Session::flush();
        Session::put('admin', $session_admin);
        return redirect(route('documents.index'));
    }

    public function show(Document $document)
    {
        if (count($document->files->where('alias')->all()) == 0) {
            if (User::isAdminView())
                return view('documents.edit', compact('document'), ['tags' => Tag::all()]);
            return $this->index();
        }

        $doc = Document::find($document->id);

        $related_documents = $doc->hasdocument;

        $pdf_file = $document->files->whereNotNull('alias')->first();
        $files = $document->files->whereNull('alias')->all();

        return view('documents.show', ['document' => $document, 'related_documents' => $related_documents, 'files' => $files, 'pdf_file' => $pdf_file, 'admin' => Session::get('admin')]);
    }

    public function home()
    {
        return view('home', ['admin' => User::isUserAdmin()]);
    }

    public function create()
    {
        $categories = Category::getCategoriesExceptBoletim();
        return view('documents.create', ['categories' => $categories]);
    }

    public function store(DocumentCreateRequest $request)
    {
        $request->validated();
        $document = new Document(request(['category_id', 'name', 'description', 'date', 'is_active']));

        $document->user_masp = $this->getMasp();
        $document->save();

        if (request()->has('filesToUpload') && request('filesToUpload')[0] != null) {
            $files = new FilesController();
            $files->uploadMultipleFiles($request, $document, 1);
        }

        if (request()->has('file_name_pdf')) {
            $file_pdf = new FilesController();
            $file_pdf->uploadFile($request, $document, 'pdf', 1);
        }

        if (request()->has('boletim_document_id')) {
            $document->hasboletim()->toggle(request('boletim_document_id'), $document->id);
        }

        if (request()->has('document_has_document')) {
            $document->hasdocument()->toggle(request('document_has_document'));
        }

        if (request()->has('tags')) {
            $document->tags()->attach(request('tags'));
        }

        storeLog($document->user_masp, $document->id, "create", 1);

        return redirect($document->path())->with('status', 'Documento ' . $document->name . ' criado com sucesso!');
    }

    public function viewfile(Document $document, $file_id)
    {
        $file_path = public_path('documents') . '/' . $document->files->where('id', $file_id)->first()->hash_id;
        if (!file_exists($file_path)) {
            $file_path = $file_path . '.pdf';
            if (!file_exists($file_path)) {
                return redirect('/documentos')->with('status', 'Erro ao tentar visualizar o documento ' . $document->name);
            }
        }
        return  Response::make(file_get_contents($file_path), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline'
        ]);
    }

    public function showByCategory(Category $category)
    {
        $this->sessionRefresh();
        if (Category::isCategoryBoletim($category->id)) {
            $documents = Boletim::orderBy('date', 'desc')->where('category_id', $category->id)->paginate();
        } else {
            $documents = Document::orderBy('date', 'desc')->where('category_id', $category->id)->paginate();
        }
        $category_option = $category->name;

        return view('documents.index', ['documents' => $documents, 'category_option' => $category_option, 'admin' => Session::get('admin')]);
    }

    public function showDeletedDocuments()
    {
        $documents = Document::onlyTrashed()->get()->sortBy('deleted_at');
        $documents = CollectionHelper::paginate($documents , count($documents), CollectionHelper::perPage());

        return view('documents.deleted_documents', ['documents' => $documents]);
    }

    public function showFailedDocuments()
    {
        $documents = Document::all();
        $documents = CollectionHelper::paginate($documents , count($documents), CollectionHelper::perPage());
        return view('documents.failed_documents', ['documents' => $documents]);
    }

    public function edit(Document $document)
    {
        return view('documents.edit', compact('document'));
    }

    public function update(DocumentUpdateRequest $request, Document $document)
    {
        $files = new FilesController();
        $document->update($request->validated());

        if (request()->has('to_delete') && (request('to_delete')[0] != null)) {
            $files_id = explode(',', request('to_delete')[0]);
            $files->deleteFile($files_id);
        }

        if (request()->has('filesToUpload') && request('files')) {
            //request('filesToUpload')[0] != null) {
            $files->uploadMultipleFiles($request, $document, 1);
        }

        if (request('file_name_pdf')) {
            if (count($document->files->where('alias')->all()) != 0)
                $document->files->whereNotNull('alias')->first()->delete();
            $files->uploadFile($request, $document, 'pdf', 1);
        }

        $document->hasboletim()->sync(request('boletim_document_id'));
        $document->hasdocument()->sync(request('document_has_document'));
        $document->tags()->sync(request('tags'));

        storeLog($this->getMasp(), $document->id, "update", 1);

        return redirect($document->path())->with('status', 'Documento ' . $document->name . ' atualizado com sucesso!');
    }

    public function download(Document $document, $hash_id)
    {
        if ($hash_id != null) {
            $file_path = public_path('documents') . '/' . $hash_id;
            if (!file_exists($file_path)) {
                $file_path = $file_path . '.pdf';
                if (!file_exists($file_path)) {
                    return redirect('/documentos')->with('status', 'Erro ao tentar fazer download do documento ' . $document->name);
                }
            }

            $file_name = $document->files->where('hash_id', $hash_id)->first()->name;
            return response()->download($file_path, $file_name);
        }
        return 0;
    }

    public function destroy(Document $document)
    {
        $document_name = $document->name;
        $document->delete();
        storeLog($this->getMasp(), $document->id, "delete", 1);
        return redirect(route('documents_admin.index'))->with('status', 'Documento ' . $document_name . ' deletado com sucesso!');
    }

    public function restore(Document $document)
    {
        dd($document);die();
        $document->restore();
        storeLog($document->user_masp, $document->id, "restore", 1);
        //$document->files()->restore();
        //$document->messages()->restore();
        return redirect(route('documents.index'))->with('status', 'Documento restaurado com sucesso!');
    }

    public function logs()
    {
        $logs = Log::orderBy('id', 'DESC')->whereNULL('boletim_id')->get();
        $logs = CollectionHelper::paginate($logs , count($logs), CollectionHelper::perPage());
        return view('documents.logs', ['logs' => $logs]);
    }

    public function dumpArray($array) {
        echo "<pre>";
        var_dump($array);
        echo "</pre>";
    }
}
