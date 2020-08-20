<?php

namespace App\Http\Controllers;

use App\Boletim;
use App\Document;
use App\Http\Requests\DocumentCreateRequest;
use App\Tag;
use App\File;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
include "DocumentsFilterHelper.php";

class DocumentsController extends Controller
{
    public function isUserAdmin()
    {
        $masp = TokenController::$payload->number;
        $user = app('App\User')->getUserByMasp($masp)['admin'];
        return $user;
    }

    public function getMasp()
    {
        $masp = TokenController::$payload->number;
        return $masp;
    }

    public function index()
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
        return view('documents.create', ['tags' => Tag::all(), 'categories' => Category::all(), 'documents' => Document::all()]);
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

        return redirect(route('documents.index'));
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

        if ($category->id == 1) {
            $documents = Boletim::where('category_id', 1)->paginate();
        }
        else if ($category->id == 2) {
            $documents = Boletim::where('category_id', 2)->paginate();
        }
        else {
            $documents = Document::where('category_id', $category->id)->paginate();
        }
        $category_option = $category->name;

        return view('documents.index', ['documents' => $documents, 'category_option' => $category_option, 'admin' => $this->isUserAdmin()]);
    }

    public function showDeletedDocuments()
    {
        $documents = Document::onlyTrashed()->get();
        return view('documents.deleted_documents', ['documents' => $documents]);

    }

    public function edit(Document $document)
    {
        return view('documents.edit', compact('document'),['tags' => Tag::all()]);
    }

    public function update(Request $request, Document $document)
    {
        if (request()->has('filesToUpload') && request('files')) {
            //request('filesToUpload')[0] != null) {

            $files = new FilesController();
            $files->uploadMultipleFiles($request, $document, 1);
        }

        if (!request('file_name_pdf')) {
            $document->update($this->validateDocument("dont_update_path"));
        } else {
            $document->update($this->validateDocument(''));
            $document->files->whereNotNull('alias')->first()->delete();
            $file_pdf = new FilesController();
            $file_pdf->uploadFile($request, $document, 'pdf', 1);
        }

        $document->hasboletim()->sync(request('boletim_document_id'));
        $document->hasdocument()->sync(request('document_has_document'));
        $document->tags()->sync(request('tags'));

        return redirect($document->path());
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
        return redirect(route('documents.index'))->with('successMsg', 'Document Successfully Deleted');
        //return view('documents.index');
    }

    public function restore(Document $document)
    {
        $document->restore();
        //$document->files()->restore();
        //$document->messages()->restore();
        return redirect(route('documents.index'))->with('successMsg', 'Document Successfully Restored');
        //return view('documents.index');
    }

    public function validateDocument($option)
    {
        if ($option == "dont_update_path"){
            return request()->validate([
                'category_id' => 'required',
                'name' => 'required',
                'description' => 'required',
                'date' => 'required',
                'is_active' => 'required',
                'tags' => 'exists:tags,id'
            ]);
        }
        return request()->validate([
            'category_id' => 'required',
            'name' => 'required',
            'description' => 'required',
            'date' => 'required',
            'is_active' => 'required',
            'file_name_pdf' => 'required',
            'tags' => 'exists:tags,id'
        ]);
    }

    public function filter(Request $request)
    {
        return getFilteredDocuments($request, $this->isUserAdmin());
    }

    public function dumpArray($array) {
        echo "<pre>";
        var_dump($array);
        echo "</pre>";
    }
}
