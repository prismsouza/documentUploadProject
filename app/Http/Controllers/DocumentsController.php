<?php

namespace App\Http\Controllers;

use App\Document;
use App\Tag;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;


class DocumentsController extends Controller
{
    public function searchByWord(Request $request)
    {
        $word = request('word');
        $documents = Document::where('name','LIKE','%'.$word.'%')->orWhere('description','LIKE','%'.$word.'%')->get();
        return view('documents.index', ['documents' => $documents, 'category_option' => null])->withDetails($documents)->withQuery($word);
    }

    public function searchByDate(Request $request)
    {
        $first_date = request('first_date');
        $last_date = request('last_date');
        $documents = Document::where('date','>',$first_date , 'and', 'date', '<', $last_date)->get();

        return view('documents.index', ['documents' => $documents, 'category_option' => null])->withDetails($documents)->withQuery($first_date, $last_date);
    }

    public function searchByYear(Request $request)
    {
        $year = request('year');
        $year_end = $year . "/12/30";
        $year = $year . "/01/01";

        $documents = Document::where('date','>=',$year , 'and', 'date', '<=', $year_end)->get();

        return view('documents.index', ['documents' => $documents, 'category_option' => null])->withDetails($documents)->withQuery($year);
    }

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
        $document = new Document(request(['category_id', 'name', 'description', 'date', 'is_active', 'file_name']));
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

    public function viewfile(Document $document)
    {
        $file_path = public_path('documents') . '/' . $document->file_name;
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
            $file_size = round($file_size, 1) . ' ' . $units[$i];

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
