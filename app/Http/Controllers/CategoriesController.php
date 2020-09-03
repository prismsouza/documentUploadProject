<?php

namespace App\Http\Controllers;

use App\Category;
use App\Document;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        /*foreach ($categories as $category) {
            if (count($category->hasparent)!=0) {
                $categories = $categories->except([$category->id]);
            }
        }*/

        return view('categories.index', ['categories' => $categories]);
    }

    public function create()
    {
        return view('categories.create', ['categories' => Category::all()]);
    }

    public function store(Request $request)
    {
        Category::create($this->validateCategory());
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

    public function update(Request $request, Category $category)
    {
        $category->update($this->validateCategory());
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

    public function validateCategory()
    {
        return request()->validate([
            'name' => 'required',
            'description' => 'required',
            'hint' => 'nullable'
        ]);
    }

    public function dumpArray($array) {
        echo "<pre>";
        var_dump($array);
        echo "</pre>";
    }
}
