<?php

namespace App\Http\Controllers;

use App\Document;
use App\Tag;
use App\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


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
        return view('documents.create', ['tags' => Tag::all(), 'themes' => Theme::all()]);
    }

    public function store(Request $request)
    {
        $this->validateDocument('');
        $document = new Document(request(['theme_id', 'name', 'description', 'file_name']));
        $document->date = '2020-01-01';
        $document->user_id = 1;
        $document = $this->getFile($request, $document);
        $document->save();

        if (request()->has('tags')) {
            $document->tags()->attach(request('tags'));
        }

        return redirect(route('documents.index'));
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
        if (!request('file_name')) {
            $this->validateDocument("dont_update_path");
            //$this->update(request(['theme_id', 'name', 'description', 'user_id']));
        } else {
            $this->validateDocument('');
            //$this->update(request(['theme_id', 'name', 'description', 'file_name', 'user_id']));
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

    public function download(Document $document)
    {

        $file_path = public_path('documents') . '/' . $document->file_name;
        return response()->download($file_path, $document->name, ['Content-Type:' . $document->filemimetype]);
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
            'file_name' => 'required',
            'tags' => 'exists:tags,id'
        ]);
    }

    public function getFile($request, $document)
    {
        if ($request->hasFile('file_name')) {
            $file_name = $document->name . '_' . $document->date . '.pdf';// . $document->date;
            $request->file_name->storeAs('documents', $file_name);

            $units = ['B', 'KB', 'MB', 'GB'];
            $file_size = $request->file('file_name')->getSize();
            for ($i = 0; $file_size > 1024; $i++) {
                $file_size /= 1000;
            }
            $file_size = round($file_size, 2) . ' ' . $units[$i];

            $document->file_name = $file_name;
            $document->size = $file_size;
        }
        return $document;
    }
    public function dumpArray($array) {
        echo "<pre>";
        var_dump($array);
        echo "</pre>";
    }
}
