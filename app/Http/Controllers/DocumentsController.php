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
        return view('documents.index', ['documents' => $documents, 'theme_option' =>null]);
    }

    public function home()
    {
        $documents = Document::latest();
        return view('documents.home', ['documents' => $documents]);
    }

    public function create()
    {
        return view('documents.create');
    }

    public function store(Request $request)
    {
        Document::create($this->validateDocument(''));
        return redirect(route('documents.index'));
    }

    public function show(Document $document)
    {
        $themes = Theme::all();
        return view('documents.show', ['document' => $document]);
    }

    public function showByTheme(Theme $theme)
    {
        $documents = $theme->documents;
        $theme_option = $theme->title;
        return view('documents.index', ['documents' => $documents, 'theme_option' => $theme_option]);
    }

    public function edit(Document $document)
    {
        return view('documents.edit', compact('document'));
    }

    public function update(Request $request, Document $document)
    {
        if (!request('file_path'))
            $document->update($this->validateDocument("dont_update_path"));
        else
            $document->update($this->validateDocument(''));
        return redirect($document->path());
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
                'theme_id' => 'required',
                'title' => 'required',
                'excerpt' => 'required',
                'user_id' => 'required'
            ]);
        }
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
