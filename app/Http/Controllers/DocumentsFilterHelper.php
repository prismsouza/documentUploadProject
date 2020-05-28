<?php

use App\Document;
use App\Helpers\CollectionHelper;
use App\Tag;
use App\Category;
use Illuminate\Support\Collection;



function getFilteredDocuments($request) {
    $documents = Document::all();
    $query = [];

    /*if (request('word') != NULL) {
        $word = request('word');
        array_push($query, $word);
        $documents = searchByWord($word, $documents);
    }*/

    if (request('subject')) {
        $subject = request('subject');
        array_push($query, $subject);
        $documents = searchByWord($subject, $documents);
    }

    if (request('number')) {
        $number = request('number');
        array_push($query, $number);
        $documents = searchByWord($number, $documents);
    }

    if (request('category')) {

        $category = request('category');
        if ($category != "0") {
            array_push($query, $category);
            $documents = searchByCategory($category, $documents);
        }
    }

    if (request('first_date') || request('last_date')) {
        $first_date = request('first_date');
        $last_date = request('last_date');
        if ($first_date == null) $first_date = "0000-00-00";
        if ($last_date == null) $last_date = date("Y-m-d");
        array_push($query, $first_date);
        array_push($query, $last_date);
        $documents = searchByDate($first_date, $last_date, $documents);
    }

    if (request('year')) {
        $year = request('year');
        array_push($query, $year);
        $documents = searchByYear($year, $documents);
    }

    if (request('tags') != NULL) {
        $tags = request('tags');
        array_push($query, $tags);
        $documents = searchByTags($tags, $documents);
    }

    /*if (request('is_active') != NULL) {
        $is_active = request('is_active');
        array_push($query, $is_active);
        $documents = searchByStatus($is_active, $documents);
    }*/
    $perPage = 10;
    if (request('results_per_page')) {
        $results_per_page = request('results_per_page');
        $perPage = $results_per_page;
    }

    $total = $documents->count();
    $order_by = request('order_by') ? request('order_by') : 'created_at';
    $documents = $documents->sortByDesc($order_by);

    $documents = CollectionHelper::paginate($documents, $total, $perPage);

    return view('documents.index', ['documents' => $documents, 'total' => $total]);
}

function searchByWord($word, $documents)
{
    $docs = Document::where('description','LIKE','%'.$word.'%')
                        ->get();
    $documents = new Collection($docs);

    return $documents;
}

function searchByCategory($category, $documents)
{
    $docs_category = new Collection();
    $docs = Category::where('id', $category)->firstOrFail()->documents;
    foreach ($docs as $doc) {
        $doc = $documents->where('id', $doc->id)->first();
        if ($doc != null and !$docs_category->contains($doc)) $docs_category->push($doc);
    }
    return $docs_category;//->collapse();
}

function searchByDate($first_date, $last_date, $documents)
{
    $docs = $documents->where('date','>=',$first_date)
                        ->where('date','<=',$last_date);
    $documents = new Collection($docs);
    return $documents;
}

function searchByYear($year, $documents)
{
    $d = Document::whereYear('date', $year)->get();
    $documents = $d->intersect($documents);
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


