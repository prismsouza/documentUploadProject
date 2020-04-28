<?php

namespace App\Http\Controllers;

use App\Document;
use App\Theme;
use Illuminate\Http\Request;

class DocumentsController extends Controller
{
    public function index()
    {
        $documents = Document::all();
        return view('documents.index', ['documents' => $documents, 'themes' => Theme::all()]);
    }

    public function home()
    {
        $documents = Document::latest();
        return view('documents.home', ['documents' => $documents, 'themes' => Theme::all()]);
    }

    public function create()
    {
        return view('documents.create', ['themes' => Theme::all()]);
    }

    public function store(Request $request)
    {
        Document::create($this->validateDocument());
        return redirect(route('documents.index'));
    }

    public function show(Document $document)
    {
        $themes = Theme::all();
        return view('documents.show', ['document' => $document, 'themes' => $themes]);
    }

    public function showByTheme(Theme $theme)
    {
        $documents = $theme->documents;
        return view('documents.index', ['documents' => $documents, 'themes' => Theme::all()]);
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
            'theme_id' => 'required',
            'title' => 'required',
            'excerpt' => 'required',
            'file_path' => 'required',
            'user_id' => 'required'
        ]);
    }

    public function dumpArray($array) {
        echo "<pre>";
        var_dump($array);
        echo "</pre>";
    }
}
