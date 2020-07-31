<?php

namespace App\Http\Controllers;

use App\Boletim;
use App\File;
use App\Http\Requests\BoletimCreateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class BoletinsController extends Controller
{
    public function index()
    {
        $boletins = Boletim::orderBy('date', 'desc')->paginate();
        return view('boletins.index', ['boletins' => $boletins, 'category_option' => null]);
    }

    public function show(Boletim $boletim)
    {
        $boletim = \App\Boletim::find($boletim->id);

        $pdf_file = $boletim->files->whereNotNull('alias')->last();
        $files = $boletim->files->whereNull('alias')->all();
        return view('boletins.show', ['boletim' => $boletim, 'files' => $files, 'pdf_file' => $pdf_file]);
    }

    public function create()
    {
        return view('boletins.create');
    }

    public function store(BoletimCreateRequest $request)
    {
        $request->validated();
        $boletim = new Boletim(request(['category_id', 'name', 'description', 'date']));
        $boletim->user_id = 1;
        $boletim->save();

        if (request()->has('files')) {
            $files = new FilesController();
            $files->uploadMultipleFiles($request, $boletim, 0);
        }

        $file_pdf = new FilesController();
        $file_pdf->uploadFile($request, $boletim, 'pdf', 0);



        return redirect(route('boletins.index'))->with('status', "Boletim criado com sucesso!");
    }

    public function edit(Boletim $boletim)
    {
        return view('boletins.edit', compact('boletim'));
    }

    public function update(Request $request, Boletim $boletim)
    {

        //dd($request->all());
        if (request('file_name_pdf') == NULL) {
            $boletim->update($this->validateBoletim("dont_update_path"));
        } else {
            $boletim->update($this->validateBoletim(''));
            $file_pdf = new FilesController();
            //$this->dumpArray(request('file_name_pdf'));
            $file_pdf->uploadFile($request, $boletim, 'pdf', 0);
            $old_pdf = $boletim->files->whereNotNull('alias')->first();
            File::destroy($old_pdf->id);
        }

        //dd(request()->all());
        if (request()->has('files')) {
            $files = new FilesController();
            $files->uploadMultipleFiles($request, $boletim, 0);

        }

        return redirect($boletim->path())->with('status', 'Boletim atualizado com sucesso!');
    }

    public function download(Boletim $boletim, $hash_id)
    {
        if ($hash_id != null) {
            $file_path = public_path('documents') . '/' . $hash_id;
            $file_name = $boletim->files->where('hash_id', $hash_id)->first()->name;
            return response()->download($file_path, $file_name);
        }
        return 0;
    }

    public function viewfile(Boletim $boletim, $file_id)
    {
        $file_path = public_path('documents') . '/' . $boletim->files->where('id', $file_id)->first()->hash_id;
        return  Response::make(file_get_contents($file_path), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline'
        ]);
    }

    public function destroy(Boletim $boletim)
    {
        $boletim->delete();
        return redirect(route('boletins.index'))->with('successMsg', 'Boletim Successfully Deleted');

    }

    public function validateBoletim($option)
    {
        if ($option == "dont_update_path"){
            return request()->validate([
                'category_id' => 'required',
                'name' => 'required',
                'description' => 'required',
                'date' => 'required'
            ]);
        }
        return request()->validate([
            'category_id' => 'required',
            'name' => 'required',
            'description' => 'required',
            'file_name_pdf' => 'required',
            'date' => 'required'
        ]);
    }

    public function filter(Request $request)
    {
        return getFilteredDocuments($request);
    }

    public function dumpArray($array) {
        echo "<pre>";
        var_dump($array);
        echo "</pre>";
    }
}
