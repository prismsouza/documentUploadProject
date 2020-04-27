<?php

namespace App\Http\Controllers;

use App\Document;
use Illuminate\Http\Request;

class DocumentsController extends Controller
{
    public function index()
    {
        $documents = Document::all();
        return view('documents.index', ['documents' => $documents]);
    }

    public function create()
    {
        return view('documents.create');
    }

    public function store(Request $request)
    {
        Document::create($this->validateDocument());
        return redirect(route('documents.index'));
    }

    public function show(Document $document)
    {
        return view('documents.show', ['document' => $document]);
    }

    public function edit(Document $document)
    {
        //
    }

    public function update(Request $request, Document $document)
    {
        //
    }

    public function destroy(Document $document)
    {
        //
    }

    public function validateDocument()
    {
        return request()->validate([
            'title' => 'required',
            'excerpt' => 'required',
            'file_path' => 'required',
            'author_cod' => 'required'
        ]);
    }

    public function dumpArray($array) {
        echo "<pre>";
        var_dump($array);
        echo "</pre>";
    }
}
