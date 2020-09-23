<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
require_once  ('../app/Helpers/'. 'MessagesFilterHelper.php');


class MessagesController extends Controller
{

    public function index()
    {
        $messages = Message::orderBy('is_checked', 'ASC')->paginate();
        return view('messages.index', ['messages' => $messages]);
    }

    public function create()
    {
        return view('documents/message_report');
    }

    public function store(Request $request, $doc_id)
    {
        $message = new Message($this->validateMessage());
        //if ($isdoc) {
            $message->document_id = $doc_id;
            $message->boletim_id = NULL;
        /*} else {
            $message->document_id = NULL;
            $message->boletim_id = $doc_id;
        }*/
        $message->is_checked = 0;
        $message->save();
        //if ($isdoc) {
            return redirect(route('documents.show', $doc_id));
        //}
        //return redirect(route('boletins.show', $doc_id));
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

    public function filter(Request $request)
    {
        return getFilteredMessages($request);
    }
}
