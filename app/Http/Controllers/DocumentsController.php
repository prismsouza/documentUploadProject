<?php

namespace App\Http\Controllers;

use App\Boletim;
use App\Document;
use App\Http\Requests\DocumentCreateRequest;
use App\Http\Requests\DocumentUpdateRequest;
use App\Tag;
use App\File;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use PhpParser\Node\Stmt\Else_;

include "DocumentsFilterHelper.php";
include "LogsHelper.php";

class DocumentsController extends Controller
{
    public function getMasp()
    {
        return TokenController::$payload->number; // $masp
    }

    public function isUserAdmin()
    {
        $masp = $this->getMasp();
        return app('App\User')->getUserByMasp($masp)['admin']; //isuseradmin
    }

    public function index()
    {
        if (request('tag')) {
            $documents = Tag::where('name', request('tag'))->firstOrFail()->documents;
        } else {
            $documents = Document::orderBy('date', 'desc')->paginate();
        }
        return view('documents.index', ['documents' => $documents, 'category_option' => null, 'admin' => 0]);

    }

    public function index_admin()
    {
        if (request('tag')) {
            $documents = Tag::where('name', request('tag'))->firstOrFail()->documents;
        } else {
            $documents = Document::orderBy('date', 'desc')->paginate();
        }
        return view('documents.index', ['documents' => $documents, 'category_option' => null, 'admin' => $this->isUserAdmin()]);

    }

    public function show(Document $document)
    {

        if (count($document->files->where('alias')->all()) == 0)
            return $this->index();

        $doc = \App\Document::find($document->id);

        $related_documents = $doc->hasdocument;

        $pdf_file = $document->files->whereNotNull('alias')->first();
        $files = $document->files->whereNull('alias')->all();

        return view('documents.show', ['document' => $document, 'related_documents' => $related_documents, 'files' => $files, 'pdf_file' => $pdf_file, 'admin' => 0]);
    }

    public function show_admin(Document $document)
    {
        if (count($document->files->where('alias')->all()) == 0)
            return view('documents.edit', compact('document'),['tags' => Tag::all()]);

        $doc = \App\Document::find($document->id);

        $related_documents = $doc->hasdocument;

        $pdf_file = $document->files->whereNotNull('alias')->first();
        $files = $document->files->whereNull('alias')->all();

        return view('documents.show', ['document' => $document, 'related_documents' => $related_documents, 'files' => $files, 'pdf_file' => $pdf_file, 'admin' => $this->isUserAdmin()]);
    }

    public function home()
    {
        return view('home', ['admin' => $this->isUserAdmin()]);
    }

    public function create()
    {
        $categories = Category::orderBy('name', 'asc')->get()
            ->whereNotIn('id', [1, 2, 3]); // BGBM / BEBM / Separata
        return view('documents.create', ['tags' => Tag::all(), 'categories' => $categories, 'documents' => Document::all()]);
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

        storeLog($document->user_masp, $document->id, "create");

        //return redirect(route('documents_admin.index'))->with('status', "Documento criado com sucesso!");
        return redirect($document->path_admin())->with('status', 'Documento criado com sucesso!');
    }

    public function viewfile(Document $document, $file_id)
    {
        //$file_path = public_path('documents') . '/' . $document->files->whereNotNull('alias')->first()->hash_id;
        $file_path = public_path('documents') . '/' . $document->files->where('id', $file_id)->first()->hash_id;

        return  Response::make(file_get_contents($file_path), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline'
        ]);
    }

    public function showByCategory(Category $category)
    {
        if ($category->id == 1 || $category->id == 2 || $category->id == 3) {
            $documents = Boletim::orderBy('date', 'desc')->where('category_id', $category->id)->paginate();
        } else {
            $documents = Document::orderBy('date', 'desc')->where('category_id', $category->id)->paginate();
        }
        $category_option = $category->name;

        return view('documents.index', ['documents' => $documents, 'category_option' => $category_option, 'admin' => 0]);
    }

    public function showByCategoryAdmin(Category $category)
    {
        if ($category->id == 1 || $category->id == 2 || $category->id == 3) {
            $documents = Boletim::orderBy('date', 'desc')->where('category_id', $category->id)->paginate();
        } else {
            $documents = Document::orderBy('date', 'desc')->where('category_id', $category->id)->paginate();
        }
        $category_option = $category->name;

        return view('documents.index', ['documents' => $documents, 'category_option' => $category_option, 'admin' => $this->isUserAdmin()]);
    }

    public function showDeletedDocuments()
    {
        $documents = Document::onlyTrashed()->get()->sortBy('deleted_at');
        return view('documents.deleted_documents', ['documents' => $documents]);
    }

    public function showFailedDocuments()
    {
        $documents = Document::all();
        return view('documents.failed_documents', ['documents' => $documents]);
    }

    public function edit(Document $document)
    {
        return view('documents.edit', compact('document'),['tags' => Tag::all()]);
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

        storeLog($this->getMasp(), $document->id, "update");

        return redirect($document->path_admin())->with('status', 'Documento atualizado com sucesso!');
    }

    public function download(Document $document, $hash_id)
    {
        if ($hash_id != null) {
            $file_path = public_path('documents') . '/' . $hash_id;
            $file_name = $document->files->where('hash_id', $hash_id)->first()->name;
            return response()->download($file_path, $file_name);
        }
        return 0;
    }

    public function destroy(Document $document)
    {
        $document->delete();
        storeLog($this->getMasp(), $document->id, "delete");
        return redirect(route('documents_admin.index'))->with('status', 'Documento deletado com sucesso!');
    }

    public function restore(Document $document)
    {
        dd($document);die();
        $document->restore();
        storeLog($document->user_masp, $document->id, "restore");
        //$document->files()->restore();
        //$document->messages()->restore();
        return redirect(route('documents.index'))->with('status', 'Documento restaurado com sucesso!');
    }

    public function filter(Request $request)
    {
        return getFilteredDocuments($request, 0);
    }

    public function filter_admin(Request $request)
    {
        return getFilteredDocuments($request, $this->isUserAdmin());
    }

    public function sortDocuments() {
        if (request('option') == 'nomeAsc') {
            $documents = Document::orderBy('name', 'ASC')->get();;
            //$documents = $sorted->values()->all();
        } elseif (request('option') == 'nomeDesc') {
            $documents = Document::orderBy('name', 'DESC')->get();//->paginate();
        } elseif (request('option') == 'dataAsc') {
            $documents = Document::orderBy('date', 'ASC')->get();//->paginate();
        } elseif (request('option') == 'dataDesc') {
            $documents = Document::orderBy('date', 'DESC')->get();//->paginate();
        } elseif (request('option') == 'dataCreatedAtAsc') {
            $documents = Document::orderBy('created_at', 'ASC')->get();//->paginate();
        } elseif (request('option') == 'dataCreatedAtDesc') {
            $documents = Document::orderBy('created_at', 'DESC')->get();//->paginate();} else {
        } else {
            $documents = Document::all();//->paginate();
        }
        return $documents;
    }
    public function sort(Request $request)
    {
        //dd($request);
        $documents = $this->sortDocuments();
        return view('documents.index', ['documents' => $documents, 'category_option' => null, 'admin' => 0]);
    }

    public function sort_admin()
    {
        $documents = $this->sortDocuments();
        return view('documents.index', ['documents' => $documents, 'category_option' => null, 'admin' => $this->isUserAdmin()]);
    }

    public function logs()
    {
        $logs = \App\Log::orderBy('id', 'DESC')->get();
        return view('documents.logs', ['logs' => $logs]);
    }

    public function dumpArray($array) {
        echo "<pre>";
        var_dump($array);
        echo "</pre>";
    }
}
