<?php

use App\Boletim;
use App\Tag;
use App\Category;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

function getFilteredBoletins($request) {
    foreach ($request->all() as $key => $value) {
        Session::put($key, $value);
    }

    $documents = Boletim::all();


    if (Session::has('word')) {
        $word = Session::get('word');
        $documents = searchByWord($word, $documents);
    }

    //if (Session::has('categories') && $request->categories != null) {
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

    return $documents;
}

function searchByWord($sentence)
{
    //dd([Session::get('word')]);
    $docs_sentences = new Collection();
    $docs = DB::select("select id, name, description from boletins WHERE MATCH (name, description) AGAINST ('$sentence') AND deleted_at IS NULL ");

    foreach($docs as $doc) {
        $document = Boletim::where('id', $doc->id)->first();
        $docs_sentences->push($document);
    }
    Session::put('option', null);
    return $docs_sentences;
}

function searchByCategories($categories, $documents)
{
    $docs_categories = new Collection();
    foreach($categories as $category_id) {
        $docs = Category::where('id', $category_id)->firstOrFail()->boletins;
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
