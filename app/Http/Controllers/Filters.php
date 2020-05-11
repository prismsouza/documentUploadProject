<?php

use App\Document;

function searchByWord(Request $request)
{
    $word = request('word');
    $documents = Document::where('name','LIKE','%'.$word.'%')->orWhere('description','LIKE','%'.$word.'%')->get();
    return view('documents.index', ['documents' => $documents, 'category_option' => null])->withDetails($documents)->withQuery($word);
}

function searchByDate(Request $request)
{
    $first_date = request('first_date');
    $last_date = request('last_date');
    $documents = Document::where('date','>',$first_date , 'and', 'date', '<', $last_date)->get();

    return view('documents.index', ['documents' => $documents, 'category_option' => null])->withDetails($documents)->withQuery($first_date, $last_date);
}

function searchByYear(Request $request)
{
    $year = request('year');
    $year_end = $year . "/12/30";
    $year = $year . "/01/01";

    $documents = Document::where('date','>=',$year , 'and', 'date', '<=', $year_end)->get();

    return view('documents.index', ['documents' => $documents, 'category_option' => null])->withDetails($documents)->withQuery($year);
}
