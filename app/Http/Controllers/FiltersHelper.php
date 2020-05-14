<?php

use App\Document;
use App\Tag;
use App\Category;
use Illuminate\Support\Collection;


function getFilteredDocuments($request) {
    $documents = Document::all();
    $query = [];

    if (request('word') != NULL) {
        $word = request('word');
        array_push($query, $word);
        $documents = searchByWord($word, $documents);
    }

    if (request('categories') != NULL) {
        $categories = request('categories');
        array_push($query, $categories);
        $documents = searchByCategories($categories, $documents);
    }

    if (request('first_date') || request('last_date') != NULL) {
        $first_date = request('first_date');
        $last_date = request('last_date');
        array_push($query, $first_date);
        array_push($query, $last_date);
        $documents = searchByDate($first_date, $last_date, $documents);
    }

    if (request('tags') != NULL) {
        $tags = request('tags');
        array_push($query, $tags);
        $documents = searchByTags($tags, $documents);
    }

    //$documents = $documents->collapse();
    return view('documents.index', ['documents' => $documents, 'category_option' => null])->withDetails($documents)->withQuery($query);
}

function searchByWord($word, $documents)
{
    $docs = Document::where('name','LIKE','%'.$word.'%')->orWhere('description','LIKE','%'.$word.'%')->get();
    $documents = new Collection($docs);
    //dd($documents);
    return $documents;
}

function searchByCategories($categories, $documents)
{
    $docs_categories = new Collection();
    foreach($categories as $category_id) {
        $docs = Category::where('id', $category_id)->firstOrFail()->documents;
        foreach ($docs as $doc) {
            $doc = $documents->where('id', $doc->id)->first();
            if ($doc != null and !$docs_categories->contains($doc)) $docs_categories->push($doc);
        }
    }
    //dd($docs_categories);
    return $docs_categories;//->collapse();
}

function searchByDate($first_date, $last_date, $documents)
{
    $docs = $documents->where('date','>',$first_date , 'and', 'date', '<', $last_date);
    $documents = new Collection($docs);
    //dd($documents);
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


