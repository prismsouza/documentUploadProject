<?php

use App\Boletim;
use App\Document;
use App\Tag;
use App\Category;
use Illuminate\Support\Collection;

function getFilteredDocuments($request, $user) {
    $documents = Document::all();
    $boletins = Boletim::all();
    $query = [];

    if (request('word') != NULL) {
        $word = request('word');
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

    //$documents = $documents->collapse();
    return view('documents.index', ['documents' => $documents, 'category_option' => null, 'admin' => $user])->withDetails($documents)->withQuery($query);
}

function searchByWord($word, $documents, $boletins)
{
    $docs = Document::where('name','LIKE','%'.$word.'%')
                        ->orWhere('description','LIKE','%'.$word.'%')
                        ->get();
    $docs_boletins = Boletim::where('name','LIKE','%'.$word.'%')
        ->orWhere('description','LIKE','%'.$word.'%')
        ->get();

    
    $all_docs = $docs->merge($docs_boletins);
    $documents = new Collection($all_docs);

    return $documents;
}

function searchByCategories($categories, $documents, $boletins)
{
    $docs_categories = new Collection();
    foreach($categories as $category_id) {
        $docs = Category::where('id', $category_id)->firstOrFail()->documents;
        $bols = Category::where('id', $category_id)->firstOrFail()->boletins;

        foreach ($docs as $doc) {
            $doc = $documents->where('id', $doc->id)->first();
            if ($doc != null and !$docs_categories->contains($doc)) {
                $docs_categories->push($doc);
            }
        }
        foreach ($bols as $bol) {
            $bol = $boletins->where('id', $bol->id)->first();
            if ($bol != null and !$docs_categories->contains($bol)) {
                $docs_categories->push($bol);
            }
        }
    }

    return $docs_categories;//->collapse();
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

function searchByTags($tags, $documents)
{
    $docs_tags = new Collection();
    foreach($tags as $tag_id) {
        $docs = Tag::where('id', $tag_id)->firstOrFail()->documents;
        foreach ($docs as $doc) {
            $doc = $documents->where('id', $doc->id)->first();
            if ($doc != null and !$docs_tags->contains($doc))
                $docs_tags->push($doc);
        }
    }
    //dd($docs_tags);
    return $docs_tags;
}

function searchByStatus($is_active, $documents)
{
    if ($is_active == -1) $is_active = 0;
    $docs = $documents->where('is_active',$is_active);
    $documents = new Collection($docs);
    return $documents;
}


