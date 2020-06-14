<?php

namespace App\Http\Controllers;

use App\Document;
use App\Http\Requests\BoletimDocumentCreateRequest;
use App\Http\Requests\DocumentCreateRequest;
use App\Tag;
use App\File;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
include "DocumentsFilterHelper.php";

class DocumentsController extends Controller
{
    public function index()
    {
        if (request('tag')) {
            $documents = Tag::where('name', request('tag'))->firstOrFail()->documents;
        } else {
            $documents = Document::orderBy('date', 'desc')->paginate();
        }
        return view('documents.index', ['documents' => $documents, 'category_option' => null]);

    }

    public function index_user()
    {
        if (request('tag')) {
            $documents = Tag::where('name', request('tag'))->firstOrFail()->documents;
        } else {
            $documents = Document::orderBy('date', 'desc')->paginate();
        }
        return view('documents.index_user', ['documents' => $documents, 'category_option' => null]);

    }

    public function show(Document $document)
    {
        $doc = \App\Document::find($document->id);

        $related_documents = $doc->hasdocument;

        $pdf_file = $document->files->whereNotNull('alias')->first();
        $files = $document->files->whereNull('alias')->all();
        return view('documents.show', ['document' => $document, 'related_documents' => $related_documents, 'files' => $files, 'pdf_file' => $pdf_file]);
    }

    public function home()
    {
        return view('home');
    }

    public function create()
    {
        return view('documents.create', ['tags' => Tag::all(), 'categories' => Category::all(), 'documents' => Document::all()]);
    }

    public function store(DocumentCreateRequest $request)
    {
        $request->validated();
        $document = new Document(request(['category_id', 'name', 'description', 'date', 'is_active']));
        $document->user_id = 1;


        if (request()->has('boletim_document_id')) {
            $document->boletim_document_id = request('boletim_document_id');
        } else {
            $document->boletim_document_id = 0;
        }
        $document->save();

        if (request()->has('files')) {
                $files = new FilesController();
                $files->uploadMultipleFiles($request, $document);
        }

        $file_pdf = new FilesController();
        $file_pdf->uploadFile($request, $document, 'pdf');

        if (request()->has('document_has_document')) {
            $document->hasdocument()->toggle(request('document_has_document'));
        }

        if (request()->has('tags')) {
            $document->tags()->attach(request('tags'));
        }

        return redirect(route('documents.index'));
    }

    public function create_boletim()
    {
        return view('documents.create_boletim');
    }

    public function store_boletim(BoletimDocumentCreateRequest $request)
    {
        $request->validated();
        $document = new Document(request(['category_id', 'name', 'description', 'date']));
        $document->user_id = 1;
        $document->boletim_document_id = 0;
        $document->save();

        if (request()->has('files')) {
            $files = new FilesController();
            $files->uploadMultipleFiles($request, $document);
        }

        $file_pdf = new FilesController();
        $file_pdf->uploadFile($request, $document, 'pdf');


        return redirect(route('documents.boletim'));
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
            $documents = Document::where('category_id', 1)
                ->orWhere('category_id', 2)->paginate();
        }
        else {
            $documents = Document::where('category_id', $category->id)->paginate();
        }
        $category_option = $category->name;
        return view('documents.index', ['documents' => $documents, 'category_option' => $category_option]);
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
        if (!request('file_name')) {
            $this->validateDocument("dont_update_path");
        } else {
            $this->validateDocument('');
        }


        if (request()->has('boletim_document_id')) {
            $document->boletim_document_id = request('boletim_document_id');
        }

        if (request()->has('tags')) {
            $document->tags()->attach(request('tags'));
        }

        if (!request('file_name'))
            $document->update($this->validateDocument("dont_update_path"));
        else
            $document->update($this->validateDocument(''));

        return redirect($document->path());
    }

    public function edit_boletim(Document $document)
    {
        return view('documents.edit_boletim', compact('document'),['tags' => Tag::all()]);
    }

    public function update_boletim(Request $request, Document $document)
    {
        $document->update($request->all());
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
        return getFilteredDocuments($request);
    }

    public function dumpArray($array) {
        echo "<pre>";
        var_dump($array);
        echo "</pre>";
    }
}
