<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    public function index()
    {
        $tags = Tag::orderBy('name', 'asc')->get();
        //$documents = Document::orderBy('date', 'desc')->paginate();
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

    public function edit(Tag $tag)
    {
        return view('tags.edit', compact('tag'));
    }

    public function update(Request $request, Tag $tag)
    {
        $tag->update($this->validateTag());
        return redirect($tag->path());
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();
        return redirect(route('tags.index'))->with('successMsg', 'Tag Successfully Deleted');
    }

    public function validateTag()
    {
        return request()->validate([
            'name' => 'required'
        ]);
    }
}
