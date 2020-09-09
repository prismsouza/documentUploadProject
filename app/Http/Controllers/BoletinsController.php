<?php

namespace App\Http\Controllers;

use App\Boletim;
use App\Document;
use App\File;
use App\Http\Requests\BoletimRequest;
use App\Http\Requests\BoletimUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class BoletinsController extends Controller
{

    public function getMasp()
    {
        return TokenController::$payload->number; // $masp
    }

    public function isUserAdmin()
    {
        $masp = $this->getMasp();
        return app('App\User')->getUserByMasp($masp)['admin']; //isuseradmin
    }

    public function index()
    {
        $boletins = Boletim::orderBy('date', 'desc')->paginate();
        return view('boletins.index', ['boletins' => $boletins, 'category_option' => null, 'admin' => $this->isUserAdmin()]);
    }

    public function index_admin()
    {
        $boletins = Boletim::orderBy('date', 'desc')->paginate();
        return view('boletins.index', ['boletins' => $boletins, 'category_option' => null, 'admin' => $this->isUserAdmin()]);
    }

    public function show(Boletim $boletim)
    {
        if (count($boletim->files->where('alias')->all()) == 0)
            return $this->index();
        $boletim = Boletim::find($boletim->id);

        $pdf_file = $boletim->files->whereNotNull('alias')->last();
        $files = $boletim->files->whereNull('alias')->all();
        return view('boletins.show', ['boletim' => $boletim, 'files' => $files, 'pdf_file' => $pdf_file, 'admin' => 0]);
    }

    public function show_admin(Boletim $boletim)
    {
        if (count($boletim->files->where('alias')->all()) == 0)
            return view('boletins.edit', compact('document'));
        $boletim = Boletim::find($boletim->id);

        $pdf_file = $boletim->files->whereNotNull('alias')->last();
        $files = $boletim->files->whereNull('alias')->all();

        return view('boletins.show', ['boletim' => $boletim, 'files' => $files, 'pdf_file' => $pdf_file, 'admin' => $this->isUserAdmin()]);
    }

    public function create()
    {
        return view('boletins.create');
    }

    public function store(BoletimRequest $request)
    {
        $request->validated();
        $boletim = new Boletim(request(['category_id', 'name', 'description', 'date']));

        $boletim->user_masp = $this->getMasp();
        $boletim->save();

        $file_pdf = new FilesController();
        $file_pdf->uploadFile($request, $boletim, 'pdf', 0);

        //return redirect(route('boletins.index'))->with('status', "Boletim criado com sucesso!");
        return redirect($boletim->path_admin())->with('status', 'Boletim criado com sucesso!');

    }

    public function edit(Boletim $boletim)
    {
        return view('boletins.edit', compact('boletim'));
    }

    public function update(BoletimUpdateRequest $request, Boletim $boletim)
    {
        $boletim->update($request->validated());
        if (request('file_name_pdf') == null) {
            return $this->edit($boletim);
        }

        if (request('file_name_pdf')) {
            $file_pdf = new FilesController();
            $file_pdf->uploadFile($request, $boletim, 'pdf', 0);
            if (count($boletim->files->where('alias')->all()) != 0)
                $boletim->files->whereNotNull('alias')->first()->delete();
            //$old_pdf = $boletim->files->whereNotNull('alias')->first();
            //File::destroy($old_pdf->id);
        }

        return redirect($boletim->path_admin())->with('status', 'Boletim atualizado com sucesso!');
    }

    public function download(Boletim $boletim, $hash_id)
    {
        if ($hash_id != null) {
            $file_path = public_path('documents') . '/' . $hash_id  . '.pdf';
            $file_name = $boletim->files->where('hash_id', $hash_id)->first()->name;
            return response()->download($file_path, $file_name);
        }
        return 0;
    }

    public function viewfile(Boletim $boletim, $file_id)
    {
        $file_path = public_path('documents') . '/' . $boletim->files->where('id', $file_id)->first()->hash_id . '.pdf';
        return  Response::make(file_get_contents($file_path), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline'
        ]);
    }

    public function destroy(Boletim $boletim)
    {
        $boletim->delete();
        return redirect(route('boletins.index'))->with('status', 'Boletim deletado com sucesso!');

    }

    public function showFailedBoletins()
    {
        $boletins = Boletim::all();
        return view('boletins.failed_boletins', ['boletins' => $boletins]);
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
        return getFilteredBoletins($request, $this->isUserAdmin());
    }

    public function dumpArray($array) {
        echo "<pre>";
        var_dump($array);
        echo "</pre>";
    }
}
