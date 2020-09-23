<?php


namespace App\Http\Controllers;


use App\Contact;

class ContactController extends Controller
{
    public function index()
    {
        $messages = Contact::orderBy('created_at', 'DESC')->paginate();
        return view('contacts.index', ['contacts' => $messages]);

    }

    public function create()
    {

    }

    public function store()
    {

    }
}
