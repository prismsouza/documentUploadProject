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
    //dd(Session::all());
    $documents = Document::all();

    if (Session::has('word')) {
        $word = Session::get('word');
        $documents = searchByWord($word, $documents);
    }

    if (request('categories') != NULL || Session::has('categories')) {
        $categories = Session::get('categories');
        $documents = searchByCategories($categories, $documents);
    }

    if (Session::has('first_date') || Session::has('last_date')) {
        $first_date = Session::get('first_date');
        $last_date = Session::get('last_date');
        if ($first_date == null) $first_date = "0000-00-00";
        if ($last_date == null) $last_date = date("Y-m-d");
        $documents = searchByDate($first_date, $last_date, $documents);
    }

    if (request('tags') != NULL) {

        $tags = Session::get('tags');
        $documents = searchByTags($tags, $documents);
    }

    if (Session::has('is_active')) {
        $is_active = Session::get('is_active');
        $documents = searchByStatus($is_active, $documents);
    }

    return $documents;
}

function searchByWord($sentence)
{
    $docs_sentences = new Collection();
    $docs = DB::select("select id, name, description from documents WHERE MATCH (name) AGAINST ('$sentence') OR MATCH (description) AGAINST ('$sentence') AND deleted_at IS NULL ");

    //dd($docs);
    foreach($docs as $doc) {
        $document = Document::where('id', $doc->id)->first();
        $docs_sentences->push($document);
    }
    Session::put('option', null);
    return $docs_sentences;
}

//function manipulateSentence($sentence) {}

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

/*function searchByWord($sentence) // OLD ONE
{
    $docs_sentences = new Collection();
    $sentence_array = explode(' ',$sentence);
    foreach ($sentence_array as $word) {
        $docs = Document::where('name','LIKE','%'.$word.'%')
                            ->orWhere('description','LIKE','%'.$word.'%')
                            ->get();
        foreach ($docs as $doc) {
            $doc = Document::where('id', $doc->id)->first();
            if ($doc != null and !$docs_sentences->contains($doc)) {
                $docs_sentences->push($doc);
            }
        }
    }
    return $docs_sentences;
}*/

