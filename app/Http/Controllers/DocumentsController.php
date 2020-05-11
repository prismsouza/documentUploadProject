<?php

namespace App\Http\Controllers;

use App\Document;
use App\Tag;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
include "File.php";
include "Filters.php";


class DocumentsController extends Controller
{

    public function index()
    {
        if (request('tag')) {
            $documents = Tag::where('name', request('tag'))->firstOrFail()->documents;
        } else {
            $documents = Document::latest()->get();
        }
        return view('documents.index', ['documents' => $documents, 'category_option' => null]);
    }

    public function home()
    {
        $documents = Document::latest();
        return view('documents.home', ['documents' => $documents]);
    }

    public function create()
    {
        return view('documents.create', ['tags' => Tag::all(), 'categories' => Category::all(), 'documents' => DOcument::all()]);
    }

    public function store(Request $request)
    {
        $this->validateDocument('');
        $document = new Document(request(['category_id', 'name', 'description', 'date', 'is_active']));

        $document->user_id = 1;
        $document->save();

        uploadFile($request, $document, 'pdf');
        uploadFile($request, $document, 'doc');

        if (request()->has('document_has_document')) {
            $document->hasdocument()->attach(request('document_has_document'));
        }

        if (request()->has('tags')) {
            $document->tags()->attach(request('tags'));
        }

        return redirect(route('documents.index'));
    }

    public function show(Document $document)
    {
        $doc = \App\Document::find($document->id);

        $related_documents = $doc->hasdocument;

        $pdf_file = $document->files->where('extension','pdf')->first();
        $doc_file = $document->files->where('extension','doc')->first();

        return view('documents.show', ['document' => $document, 'related_documents' => $related_documents, 'doc_file' => $doc_file, 'pdf_file' => $pdf_file]);
    }

    public function viewfile(Document $document)
    {
        $file_path = public_path('documents') . '/' . $document->files->where('extension','pdf')->first()->alias;
        return  Response::make(file_get_contents($file_path), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline'
        ]);
    }

    public function showByCategory(Category $category)
    {
        $documents = $category->documents;
        $category_option = $category->name;
        return view('documents.index', ['documents' => $documents, 'category_option' => $category_option]);
    }

    public function edit(Document $document)
    {
        return view('documents.edit', compact('document'),['tags' => Tag::all()]);
    }

    public function update(Request $request, Document $document)
    {
        if (!request('file_name')) {
            $this->validateDocument("dont_update_path");
            //$this->update(request(['category_id', 'name', 'description', 'user_id']));
        } else {
            $this->validateDocument('');
            //$this->update(request(['category_id', 'name', 'description', 'file_name', 'user_id']));
        }

        if (request()->has('tags')) {
            $document->tags()->attach(request('tags'));
        }

        return redirect($document->path());

        /*if (!request('file_name'))
            $document->update($this->validateDocument("dont_update_path"));
        else
            $document->update($this->validateDocument(''));
        return redirect($document->path());*/
    }

    public function download(Document $document, $type)
    {
        $file = $document->files->where('extension', $type)->first();
        $file_alias = $file->alias;
        $filemimetype = $file->filemimetype;
        $file_path = public_path('documents') . '/' . $file_alias;
        return response()->download($file_path, $document->name, ['Content-Type:' . $filemimetype]);
    }

    public function destroy(Document $document)
    {
        $document->delete();
        return view('documents.index');
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
            'tags' => 'exists:tags,id',
            'document_has_document' => 'exists:document_has_document,document_id',
        ]);
    }

    public function dumpArray($array) {
        echo "<pre>";
        var_dump($array);
        echo "</pre>";
    }
}
