<?php

use App\Boletim;
use App\Document;
use App\Tag;
use App\Category;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

function getFilteredDocuments($request, $user) {
    $documents = Document::all();
    $boletins = Boletim::all();
    $query = [];

    if (session('word')) {
        $word = session('word');
        //dd($word);
        array_push($query, $word);
        $documents = searchByWord($word, $documents, $boletins);
    }

    if (request('categories') != NULL) {
        $categories = request('categories');
        array_push($query, $categories);
        $documents = searchByCategories($categories, $documents, $boletins);
    }

    if (request('first_date') || request('last_date') != NULL) {
        $first_date = request('first_date');
        $last_date = request('last_date');
        if ($first_date == null) $first_date = "0000-00-00";
        if ($last_date == null) $last_date = date("Y-m-d");
        array_push($query, $first_date);
        array_push($query, $last_date);
        $documents = searchByDate($first_date, $last_date, $documents, $boletins);
    }

    if (request('tags') != NULL) {
        $tags = request('tags');
        array_push($query, $tags);
        $documents = searchByTags($tags, $documents);
    }

    if (request('is_active') != NULL) {
        $is_active = request('is_active');
        array_push($query, $is_active);
        $documents = searchByStatus($is_active, $documents);
    }

    $documents = $documents->sortByDesc('date');
    //dd($documents);
    return $documents;
    //return redirect(route('documents.index'))->with('documents', $documents);
    //return view('documents.index', ['documents' => $documents, 'category_option' => null, 'admin' => $user])->withDetails($documents)->withQuery($query);
}


function searchByCategories($categories)
{
    $filter_by_categories = [];
    foreach($categories as $category_id) {
        $docs = Category::where('id', $category_id)->firstOrFail()->documents;
        foreach ($docs as $doc) {
            array_push($filter_by_categories, Document::where('id', $doc->id)->first()->get());
        }
    }
    //dd($filter_by_category);
    return $filter_by_categories;//->collapse();
}

function searchByTags($tags)
{
    $filter_by_tags = [];
    foreach($tags as $tag_id) {
        $docs = Tag::where('id', $tag_id)->firstOrFail()->documents;
        foreach ($docs as $doc) {
            array_push($filter_by_tags, Document::where('id', $doc->id)->first()->get());
        }
    }
    //dd($filter_by_tags);
    return $filter_by_tags;
}

function searchByDate($first_date, $last_date, $documents, $boletins)
{
    $docs = $documents->where('date','>=',$first_date)
                        ->where('date','<=',$last_date);
    $bols = $boletins->where('date','>=',$first_date)
        ->where('date','<=',$last_date);
    $all_docs = $docs->merge($bols);
    $documents = new Collection($all_docs);
    return $documents;
}



function searchByStatus($is_active, $documents)
{
    if ($is_active == -1) $is_active = 0;
    $docs = $documents->where('is_active',$is_active);
    $documents = new Collection($docs);
    return $documents;
}


