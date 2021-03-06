<?php

namespace App\Http\Controllers;

use App\Category;
use App\Document;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\CategoryUpdateRequest;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        return view('categories.index', ['categories' => $categories]);
    }

    public function create()
    {
        return view('categories.create', ['categories' => Category::all()]);
    }

    public function store(CategoryRequest $request)
    {
        $request->validated();

        Category::create($request->all());
        return redirect(route('categories.index'));
    }

    public function show(Category $category)
    {
        return view('categories.show', ['category' => $category]);
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(CategoryUpdateRequest $request, Category $category)
    {
        //dd($request->all());
        $request->validated();
        $category->update($request->all());
        return redirect(route('categories.index'));
    }

    public function destroy(Category $category)
    {
        if ($category->id != 1 && $category->id != 2 && $category->id != 3 && $category->id != 24) {
            $category->delete();
            return redirect(route('categories.index'))->with('successMsg', 'Categoria apagada com sucesso');
        }
        return redirect(route('categories.index'))->with('successMsg', 'Essa categoria não pode ser apagada');
    }


    public function dumpArray($array) {
        echo "<pre>";
        var_dump($array);
        echo "</pre>";
    }
}
