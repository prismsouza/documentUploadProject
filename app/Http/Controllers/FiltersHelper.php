<?php

use App\Document;
use App\Tag;
use Illuminate\Support\Collection;

function searchByWord($word)
{
    $documents = Document::where('name','LIKE','%'.$word.'%')->orWhere('description','LIKE','%'.$word.'%')->get();
    return view('documents.index', ['documents' => $documents, 'category_option' => null])->withDetails($documents)->withQuery($word);
}

function searchByDate($first_date, $last_date)
{
    $documents = Document::where('date','>',$first_date , 'and', 'date', '<', $last_date)->get();
    return view('documents.index', ['documents' => $documents, 'category_option' => null])->withDetails($documents)->withQuery($first_date, $last_date);
}

function searchByYear($year)
{
    $documents = Document::whereYear('date','=',$year)->get();
    return view('documents.index', ['documents' => $documents, 'category_option' => null])->withDetails($documents)->withQuery($year);
}

function searchByTags($tags)
{
    $documents = new Collection([]);
    foreach($tags as $tag_id) {
        $docs = Tag::where('id', $tag_id)->firstOrFail()->documents;
        $documents->push($docs);
    }
    $documents = $documents->collapse();
    return view('documents.index', ['documents' => $documents, 'category_option' => null])->withDetails($documents)->withQuery($tags);
}
