<?php

namespace App\Http\Controllers;

use App\Boletim;
use App\Document;
use App\Helpers\Collection;
use App\Http\Requests\DocumentCreateRequest;
use App\Http\Requests\DocumentUpdateRequest;
use App\Tag;
use App\Category;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;

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
        if (User::where('masp', $masp)->first()) return 1;
        return 0;
    }

    public function index(Request $request)
    {
        $documents = getFilteredDocuments($request);
        return view('documents.index', ['documents' => $documents, 'category_option' => null, 'admin' => 0]);
    }

    public function getFilteredDocuments(Request $request)
    {

        foreach ($request->all() as $key => $value) {
            Session::put($key, $value);
        }

        $filter_word_name = [];
        $filter_word_description = [];
        $filtered_by_categories = new Collection();
        $filtered_by_tags = new Collection();
        $files = new Collection();
       // dd(Session::all());
        if (Session::has('word')) {
            array_push($filter_word_name, ['name', 'like', "%" . Session::get('word') . "%"]);
            array_push($filter_word_description, ['description', 'like', "%" . Session::get('word') . "%"]);
            $filter_word = new Collection(Document::where($filter_word_name)->orWhere($filter_word_description)->get());
        }

        if (Session::has('categories')) {
            $filtered_by_categories = searchByCategories(Session::get('categories'));
            foreach ($filtered_by_categories as $f) {
                dd($f);
                $files->merge($f);
            }
            dd($files);
        }

        if (Session::has('tags')) {
            $filtered_by_tags = searchByTags(Session::get('tags'));
        }

        //dd(Session::all());
        //$filtered_documents =  array_intersect($filter_word, $filter_category);
        dd([Session::all(), $filter_word, $filtered_by_categories, $filtered_by_tags]);
        //dd([$filter_query, $filtered_documents]);
        return $filtered_documents;//->paginate();
    }

    public function refresh()
    {
        Session::flush();
        return redirect(route('documents.index'));
    }

    public function index_admin()
    {
        if (request('tag')) {
            $documents = Tag::where('name', request('tag'))->firstOrFail()->documents;
        } else {
            $documents = Document::orderBy('date', 'desc')->paginate();
        }
        //dd($documents); die();
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

        storeLog($document->user_masp, $document->id, "create", 1);

        return redirect($document->path_admin())->with('status', 'Documento ' . $document->name . ' criado com sucesso!');
    }

    public function viewfile(Document $document, $file_id)
    {
        $file_path = public_path('documents') . '/' . $document->files->where('id', $file_id)->first()->hash_id;
        if (!file_exists($file_path)) {
            $file_path = $file_path . '.pdf';
            if (!file_exists($file_path)) {
                return redirect('/documentos')->with('status', 'Erro ao tentar visualizar o documento ' . $document->name);
            }
        }
        return  Response::make(file_get_contents($file_path), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline'
        ]);
    }

    public function showByCategory(Category $category)
    {
        Session::flush();
        if ($category->id == 1 || $category->id == 2 || $category->id == 3) {
            $documents = Boletim::orderBy('date', 'desc')->where('category_id', $category->id)->paginate();
        } else {
            $documents = Document::orderBy('date', 'desc')->where('category_id', $category->id)->paginate();
            //$documents = $documents->sortByDesc('date')->where('category_id', $category->id);//->paginate();
        }
        //dd($documents);
        $category_option = $category->name;

        Session::put('documents',  $documents);
       // dd(Session::get('documents'));
        //return redirect(route('documents_category.index', $category_option));
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

        Session::put('documents',  $documents);
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

        storeLog($this->getMasp(), $document->id, "update", 1);

        return redirect($document->path_admin())->with('status', 'Documento ' . $document->name . ' atualizado com sucesso!');
    }

    public function download(Document $document, $hash_id)
    {
        if ($hash_id != null) {
            $file_path = public_path('documents') . '/' . $hash_id;
            if (!file_exists($file_path)) {
                $file_path = $file_path . '.pdf';
                if (!file_exists($file_path)) {
                    return redirect('/documentos')->with('status', 'Erro ao tentar fazer download do documento ' . $document->name);
                }
            }

            $file_name = $document->files->where('hash_id', $hash_id)->first()->name;
            return response()->download($file_path, $file_name);
        }
        return 0;
    }

    public function destroy(Document $document)
    {
        $document_name = $document->name;
        $document->delete();
        storeLog($this->getMasp(), $document->id, "delete", 1);
        return redirect(route('documents_admin.index'))->with('status', 'Documento ' . $document_name . ' deletado com sucesso!');
    }

    public function restore(Document $document)
    {
        dd($document);die();
        $document->restore();
        storeLog($document->user_masp, $document->id, "restore", 1);
        //$document->files()->restore();
        //$document->messages()->restore();
        return redirect(route('documents.index'))->with('status', 'Documento restaurado com sucesso!');
    }

    public function filter(Request $request)
    {
      //
        Session::put('word',  $request->word);
        $documents = getFilteredDocuments($request, 0);
        //Session::put('documents',  $documents);
       // dd(Session::get('documents'));
        //dd(Session::all());
        //dd($documents);
        //return redirect(route('documents.index'));
        return view('documents.index', ['documents' => $documents, 'category_option' => null, 'admin' => 0]);
    }

    public function filter_admin(Request $request)
    {
        $documents = getFilteredDocuments($request, $this->isUserAdmin());
        Session::put('request',  $request->all());
        return view('documents.index', ['documents' => $documents, 'category_option' => null, 'admin' => $this->isUserAdmin()]);
    }

    public function sortDocuments() {
        if (request('option') == 'nomeAsc') {
            //$documents = Document::orderBy('name', 'ASC')->get();;
            $documents = $documents->sortBy('name', SORT_NATURAL|SORT_FLAG_CASE);
        } elseif (request('option') == 'nomeDesc') {
            //$documents = Document::orderBy('name', 'DESC')->get();//->paginate();
            $documents = $documents->sortByDesc('name', SORT_NATURAL|SORT_FLAG_CASE);//>paginate(20);
        }
        elseif (request('option') == 'dataAsc') {
            $documents = $documents->sortBy('date');
        } elseif (request('option') == 'dataDesc') {
            $documents = $documents->sortByDesc('date');
        }
        elseif (request('option') == 'dataCreatedAtAsc') {
            $documents = $documents->sortBy('created_at');
        } elseif (request('option') == 'dataCreatedAtDesc') {
            $documents = $documents->sortByDesc('created_at');
        }
        else {
            $documents = $documents->sortBy('date');
        }
        //$documents = CollectionHelper::paginate($documents , count($documents), CollectionHelper::perPage());

        return $documents;
    }

    public function sort(Request $request)
    {
        $documents = $this->sortDocuments();
        Session::put('request',  $request->all());
        //Session::put('documents',  $documents);
        $documents = Session::get('documents');
       // dd($documents);

        return redirect(route('documents.index'));
    }

    public function sort_admin()
    {
        $documents = $this->sortDocuments();
        Session::put('documents',  $documents);
        return view('documents.index', ['documents' => $documents, 'category_option' => null, 'admin' => $this->isUserAdmin()]);
    }

    public function logs()
    {
        $logs = \App\Log::orderBy('id', 'DESC')->whereNULL('boletim_id')->get();;
        return view('documents.logs', ['logs' => $logs]);
    }

    public function dumpArray($array) {
        echo "<pre>";
        var_dump($array);
        echo "</pre>";
    }
}
