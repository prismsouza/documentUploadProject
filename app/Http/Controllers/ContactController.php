<?php


namespace App\Http\Controllers;


use App\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        if(!UsersController::isUserSuperAdmin())  return redirect(route('documents.index'));
        $messages = Contact::orderBy('created_at', 'DESC')->paginate(20);
        return view('contacts.index', ['contacts' => $messages]);

    }

    public function create()
    {
        return view('contacts.create');
    }

    public function store()
    {
        $message = new Contact($this->validateMessage());
        $message->user_masp = UsersController::getMasp();
        $message->save();
        return redirect(route('documents.index'))->with('status', 'Mensagem enviada');;
    }

    public function validateMessage()
    {
        return request()->validate([
            'message' => 'required'
        ]);
    }
}
