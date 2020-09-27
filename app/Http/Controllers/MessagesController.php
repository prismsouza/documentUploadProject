<?php

namespace App\Http\Controllers;

use App\Helpers\CollectionHelper;
use Illuminate\Http\Request;
use App\Message;
require_once  ('../app/Helpers/'. 'MessagesFilterHelper.php');


class MessagesController extends Controller
{

    public function index(Request $request)
    {
        $messages = getFilteredMessages($request);
        $messages = $messages->sortBy('is_checked');
        $messages = CollectionHelper::paginate($messages , count($messages), CollectionHelper::perPage());
        return view('messages.index', ['messages' => $messages]);
    }

    public function create()
    {
        return view('documents/message_report');
    }

    public function store(Request $request, $doc_id)
    {
        $message = new Message($this->validateMessage());
        $message->document_id = $doc_id;
        $message->boletim_id = NULL;

        $message->is_checked = 0;
        $message->save();
        return redirect(route('documents.show', $doc_id));
    }

    public function edit(Message $message)
    {
        //return view('categories.edit', compact('category'));
    }

    public function update(Message $message)
    {
        if ($message->is_checked == 1) {
            $message->is_checked = 0;
        } else {
            $message->is_checked = 1;
        }
        $message->update();
        return redirect($message->path());
    }

    public function validateMessage()
    {
        return request()->validate([
            'message' => 'required'
        ]);
    }
}
