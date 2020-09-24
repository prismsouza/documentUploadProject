<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagRequest;
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

    public function store(TagRequest $request)
    {
        $request->validated();

        Tag::create($request->all());
        return redirect(route('tags.index'));
    }

    public function edit(Tag $tag)
    {
        return view('tags.edit', compact('tag'));
    }

    public function update(TagRequest $request, Tag $tag)
    {
        $request->validated();
        $tag->update($request->all());
        return redirect($tag->path());
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();
        return redirect(route('tags.index'))->with('successMsg', 'Tag deletada com sucesso');
    }

    public function validateTag()
    {
        return request()->validate([
            'name' => 'required|unique:tags'
        ]);
    }
}
