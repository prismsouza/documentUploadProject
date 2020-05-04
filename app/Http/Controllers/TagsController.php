<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    public function index()
    {
        $tags = Tag::all();
        return view('tags.index', ['tags' => $tags]);
    }

    public function create()
    {
        return view('tags.create', ['tags' => Tag::all()]);
    }

    public function store(Request $request)
    {
        Tag::create($this->validateTag());
        return redirect(route('tags.index'));
    }

    public function validateTag()
    {
        return request()->validate([
            'name' => 'required'
        ]);
    }
}
