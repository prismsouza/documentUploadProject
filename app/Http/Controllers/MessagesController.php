<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;

class MessagesController extends Controller
{
    public function create()
    {
        return view('documents/message_report');
    }

    public function store(Request $request, $document_id)
    {
        $message = new Message($this->validateMessage());
        $message->document_id = $document_id;
        $message->save();
        return redirect(route('documents.show', $document_id));
    }

    public function validateMessage()
    {
        return request()->validate([
            'message' => 'required'
        ]);
    }
}
