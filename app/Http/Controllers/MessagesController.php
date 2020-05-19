<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;

class MessagesController extends Controller
{

    public function index()
    {
        $messages = Message::orderBy('is_checked', 'ASC')->get();
        return view('messages/index', ['messages' => $messages]);
    }

    public function create()
    {
        return view('documents/message_report');
    }

    public function store(Request $request, $document_id)
    {
        $message = new Message($this->validateMessage());
        $message->document_id = $document_id;
        $message->is_checked = 0;
        $message->save();
        return redirect(route('documents.show', $document_id));
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
