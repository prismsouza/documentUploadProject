<?php

use App\Document;
use App\Tag;
use App\Category;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

function getFilteredDocuments($request) {
    //dd($request->all());
    foreach ($request->all() as $key => $value) {
        Session::put($key, $value);
    }
   // dd(Session::all());
    $documents = Document::all();
    $query = [];

    if (Session::has('word')) {
        $word = Session::get('word');
        array_push($query, $word);
        $documents = searchByWord($word, $documents);
    }

    if (request('categories') != NULL) {
        $categories = Session::get('categories');
        array_push($query, $categories);
        $documents = searchByCategories($categories, $documents);
    }

    if (Session::has('first_date') || Session::has('last_date')) {
        $first_date = Session::get('first_date');
        $last_date = Session::get('last_date');
        if ($first_date == null) $first_date = "0000-00-00";
        if ($last_date == null) $last_date = date("Y-m-d");
        array_push($query, $first_date);
        array_push($query, $last_date);
        $documents = searchByDate($first_date, $last_date, $documents);
    }

    if (request('tags') != NULL) {

        $tags = Session::get('tags');
        array_push($query, $tags);
        $documents = searchByTags($tags, $documents);
    }

    if (Session::has('is_active')) {
        $is_active = Session::get('is_active');
        array_push($query, $is_active);
        $documents = searchByStatus($is_active, $documents);
    }

    $documents = $documents->sortByDesc('date');
    //dd($documents);
    return $documents;
    //return redirect(route('documents.index'))->with('documents', $documents);
    //return view('documents.index', ['documents' => $documents, 'category_option' => null, 'admin' => $user])->withDetails($documents)->withQuery($query);
}

function searchByWord($word)
{
    $docs = Document::where('name','LIKE','%'.$word.'%')
                        ->orWhere('description','LIKE','%'.$word.'%')
                        ->get();
    return $docs;
}

function searchByCategories($categories, $documents)
{
    $docs_categories = new Collection();

    foreach($categories as $category_id) {
        $docs = Category::where('id', $category_id)->firstOrFail()->documents;

        foreach ($docs as $doc) {
            $doc = $documents->where('id', $doc->id)->first();
            if ($doc != null and !$docs_categories->contains($doc)) {
                $docs_categories->push($doc);
            }
        }
    }
    return $docs_categories;
}

function searchByDate($first_date, $last_date, $documents)
{
    $docs = $documents->where('date','>=',$first_date)
                        ->where('date','<=',$last_date);
    return $docs;
}

function searchByTags($tags, $documents)
{

    $docs_tags = new Collection();
    if (gettype($tags) != "array") {
        $tags = Tag::where('name', $tags)->first()->id;
        $tags = array($tags);
    }

    foreach($tags as $tag_id) {

        $docs = Tag::where('id', $tag_id)->firstOrFail()->documents;
        foreach ($docs as $doc) {
            $doc = $documents->where('id', $doc->id)->first();
            if ($doc != null and !$docs_tags->contains($doc)) {
                $docs_tags->push($doc);
            }
        }
    }
    return $docs_tags;
}

function searchByStatus($is_active, $documents)
{
    if ($is_active == -1) $is_active = 0;
        $docs = $documents->where('is_active',$is_active);
    return $docs;
}


