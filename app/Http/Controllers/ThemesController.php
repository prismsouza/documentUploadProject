<?php

namespace App\Http\Controllers;

use App\Theme;
use Illuminate\Http\Request;

class ThemesController extends Controller
{
    public function index()
    {
        $themes = Theme::all();
        return view('themes.index', ['themes' => $themes]);
    }

    public function create()
    {
        return view('themes.create', ['themes' => Theme::all()]);
    }

    public function store(Request $request)
    {
        Theme::create($this->validateTheme());
        return redirect(route('themes.index'));
    }

    public function show(Theme $theme)
    {
        return view('themes.show', ['theme' => $theme]);
    }

    public function edit(Theme $theme)
    {
        return view('themes.edit', compact('theme'));
    }

    public function update(Request $request, Theme $theme)
    {
        $theme->update($this->validateTheme());
        return redirect($theme->path());
    }

    public function destroy(Theme $theme)
    {
        //
    }

    public function validateTheme()
    {
        return request()->validate([
            'name' => 'required',
            'description' => 'required'
        ]);
    }

    public function dumpArray($array) {
        echo "<pre>";
        var_dump($array);
        echo "</pre>";
    }
}
