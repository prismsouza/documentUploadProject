<?php

use App\Message;
use App\Category;
use Illuminate\Support\Collection;

function getFilteredMessages($request) {
    $messages = Message::all();
    $query = [];

    if (request('word') != NULL) {
        $word = request('word');
        array_push($query, $word);
        $messages = searchByWord($word);
    }

    if (request('categories') != NULL) {
        $categories = request('categories');
        array_push($query, $categories);
        $messages  = searchByCategories($categories);
    }

    if (request('first_date') || request('last_date') != NULL) {
        $first_date = request('first_date');
        $last_date = request('last_date');
        if ($first_date == null) $first_date = "0000-00-00 00:00:00";
        if ($last_date == null) $last_date = date("Y-m-d");
        array_push($query, $first_date);
        array_push($query, $last_date);
        $last_date = $last_date . " 23:59:59";
        $messages = searchByDate($first_date, $last_date, $messages);
    }

    if (request('is_checked') != NULL) {
        $is_checked = request('is_checked');
        array_push($query, $is_checked);
        $messages  = searchByStatus($is_checked, $messages);
    }

    return view('messages.index', ['messages' => $messages])->withDetails($messages)->withQuery($query);
}

function getMessages($docs) {
    $msgs_docs = new Collection();
    $msgs = Message::all()->pluck('document_id');
    $intersected_id_doc_msgs = $docs->intersect($msgs);

    foreach ($intersected_id_doc_msgs as $id) {
        $messages = Message::where('document_id', $id)->get();
        foreach ($messages as $message) {
            $message = $messages->where('id', $message->id)->first();
            $msgs_docs->push($message);
        }
    }
    return $msgs_docs;
}

function searchByWord($word)
{
    $docs = App\Document::where('name','LIKE','%'.$word.'%')
                        //->orWhere('description','LIKE','%'.$word.'%')
                        ->get()->pluck('id');
    return getMessages($docs);
}

function searchByCategories($categories)
{
    $docs_categories = new Collection();
    foreach($categories as $category_id) {
        $docs = Category::where('id', $category_id)->firstOrFail()->documents;
        foreach ($docs as $doc) {
            $docs_categories->push($doc->id);
        }
    }
    return getMessages($docs_categories);
}

function searchByDate($first_date, $last_date, $messages)
{
    $msgs = $messages->where('created_at','>=',$first_date)
                        ->where('created_at','<=',$last_date);
    $messages = new Collection($msgs);

    return $messages;
}

function searchByStatus($is_checked, $messages)
{
    if ($is_checked == -1) {
        $is_checked = 0;
    } elseif ($is_checked == 2) {
        return $messages;
    }

    $msgs = $messages->where('is_checked', $is_checked);
    $messages = new Collection($msgs);
    return $messages;
}


