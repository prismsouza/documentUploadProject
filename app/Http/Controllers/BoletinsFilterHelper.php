<?php

use App\Boletim;
use App\Tag;
use App\Category;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

function getFilteredBoletins($request) {

   // dd($request->all());
    foreach ($request->all() as $key => $value) {
        Session::put($key, $value);
    }

    $documents = Boletim::all();
    $query = [];

    if (Session::has('word')) {
        $word = Session::get('word');
        array_push($query, $word);
        $documents = searchByWord($word, $documents);
    }

    if (Session::has('categories')) {
        $categories = request('categories');
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

    $documents = $documents->sortByDesc('date');
    //dd($documents);
    return $documents;
    //return redirect(route('documents.index'))->with('documents', $documents);
    //return view('documents.index', ['documents' => $documents, 'category_option' => null, 'admin' => $user])->withDetails($documents)->withQuery($query);
}

function searchByWord($word, $documents)
{
    $docs = Boletim::where('name','LIKE','%'.$word.'%')
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
    foreach($tags as $tag_id) {
        $docs = Tag::where('id', $tag_id)->firstOrFail()->documents;
        foreach ($docs as $doc) {
            $doc = $documents->where('id', $doc->id)->first();
            if ($doc != null and !$docs_tags->contains($doc))
                $docs_tags->push($doc);
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


