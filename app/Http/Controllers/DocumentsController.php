<?php

namespace App\Http\Controllers;

use App\Document;
use App\Tag;
use App\Theme;
use Illuminate\Http\Request;

class DocumentsController extends Controller
{
    public function index()
    {
        if (request('tag')) {
            $documents = Tag::where('name', request('tag'))->firstOrFail()->documents;
        } else {
            $documents = Document::latest()->get();
        }
        return view('documents.index', ['documents' => $documents, 'theme_option' => null]);

        /*
        $documents = Document::all();
        return view('documents.index', ['documents' => $documents, 'theme_option' =>null]);
        */
    }

    public function home()
    {
        $documents = Document::latest();
        return view('documents.home', ['documents' => $documents]);
    }

    public function create()
    {
        return view('documents.create', ['tags' => Tag::all()]);
        //return view('documents.create');
    }

    public function store(Request $request)
    {
        $this->validateDocument('');
        $document = new Document(request(['theme_id', 'name', 'description', 'file_path']));
        $document->user_id = 1;
        $document->save();

        if (request()->has('tags')) {
            $document->tags()->attach(request('tags'));
        }

        return redirect(route('documents.index'));
        /*
        Document::create($this->validateDocument(''));
        return redirect(route('documents.index'));
        */
    }

    public function show(Document $document)
    {
        return view('documents.show', ['document' => $document]);
    }

    public function showByTheme(Theme $theme)
    {
        $documents = $theme->documents;
        $theme_option = $theme->name;
        return view('documents.index', ['documents' => $documents, 'theme_option' => $theme_option]);
    }

    public function edit(Document $document)
    {
        return view('documents.edit', compact('document'),['tags' => Tag::all()]);
    }

    public function update(Request $request, Document $document)
    {
        if (!request('file_path')) {
            $this->validateDocument("dont_update_path");
            //$this->update(request(['theme_id', 'name', 'description', 'user_id']));
        } else {
            $this->validateDocument('');
            //$this->update(request(['theme_id', 'name', 'description', 'file_path', 'user_id']));
        }

        if (request()->has('tags')) {
            $document->tags()->attach(request('tags'));
        }

        return redirect($document->path());

        /*if (!request('file_path'))
            $document->update($this->validateDocument("dont_update_path"));
        else
            $document->update($this->validateDocument(''));
        return redirect($document->path());*/
    }

    public function download()
    {
        
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
                'name' => 'required',
                'description' => 'required',
                'tags' => 'exists:tags,id'
            ]);
        }
        return request()->validate([
            'theme_id' => 'required',
            'name' => 'required',
            'description' => 'required',
            'file_path' => 'required',
            'tags' => 'exists:tags,id'
        ]);
    }

    public function dumpArray($array) {
        echo "<pre>";
        var_dump($array);
        echo "</pre>";
    }
}
