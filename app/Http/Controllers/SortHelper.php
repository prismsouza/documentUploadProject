<?php

function getOrderedDocuments($request, $documents)
{
    foreach ($request->all() as $key => $value) {
        Session::put($key, $value);
    }
    if (Session::get('option') == 'nomeAsc') {
        //$documents = Document::orderBy('name', 'ASC')->get();;
        $documents = $documents->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE);
    } elseif (Session::get('option') == 'nomeDesc') {
        //$documents = Document::orderBy('name', 'DESC')->get();//->paginate();
        $documents = $documents->sortByDesc('name', SORT_NATURAL | SORT_FLAG_CASE);//>paginate(20);
    } elseif (Session::get('option') == 'dataAsc') {
        $documents = $documents->sortBy('date');
    } elseif (Session::get('option') == 'dataDesc') {
        $documents = $documents->sortByDesc('date');
    } elseif (Session::get('option') == 'dataCreatedAtAsc') {
        $documents = $documents->sortBy('created_at');
    } elseif (Session::get('option') == 'dataCreatedAtDesc') {
        $documents = $documents->sortByDesc('created_at');
    } else {
        $documents = $documents->sortBy('date');
    }
    //$documents = CollectionHelper::paginate($documents , count($documents), CollectionHelper::perPage());

    return $documents;
}
