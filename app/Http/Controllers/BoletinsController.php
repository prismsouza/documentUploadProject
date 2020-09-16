<?php

namespace App\Http\Controllers;

use App\Boletim;
use App\Http\Requests\BoletimRequest;
use App\Http\Requests\BoletimUpdateRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

include "LogsHelper.php";

class BoletinsController extends Controller
{

    public function getMasp()
    {
        return TokenController::$payload->number; // $masp
    }

    public function isUserAdmin()
    {
        $masp = $this->getMasp();
        if (User::where('masp', $masp)->first()) return 1;
        return 0;
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

        storeLog($boletim->user_masp, $boletim->id, "create", 0);

        //return redirect(route('boletins.index'))->with('status', "Boletim criado com sucesso!");
        return redirect($boletim->path_admin())->with('status', 'Boletim ' . $boletim->name . ' criado com sucesso!');

    }

    public function edit(Boletim $boletim)
    {
        return view('boletins.edit', compact('boletim'));
    }

    public function update(BoletimUpdateRequest $request, Boletim $boletim)
    {
       // dd(request('file_name_pdf'));die();
        $files = new FilesController();
        $boletim->update($request->validated());

        /*if (request('file_name_pdf') == null) {
            return $this->edit($boletim);
        }*/
        if (request('file_name_pdf')) {
            //dd(request('file_name_pdf'));
            $file_pdf = new FilesController();
            $file_pdf->uploadFile($request, $boletim, 'pdf', 0);
            if (count($boletim->files->where('alias')->all()) != 0)
                $boletim->files->whereNotNull('alias')->first()->delete();
            $files->uploadFile($request, $boletim, 'pdf', 0);

            //$old_pdf = $boletim->files->whereNotNull('alias')->first();
            //File::destroy($old_pdf->id);
        }

        storeLog($this->getMasp(), $boletim->id, "update", 0);

        return redirect($boletim->path_admin())->with('status', 'Documento ' . $boletim->name . ' atualizado com sucesso!');
    }

    public function download(Boletim $boletim, $hash_id)
    {
        if ($hash_id != null) {
            $file_path = public_path('documents') . '/' . $hash_id;
            if (!file_exists($file_path)) {
                $file_path = $file_path . '.pdf';
                if (!file_exists($file_path)) {
                    return redirect('/boletins')->with('status', 'Erro ao tentar fazer download da(o) ' . $boletim->name);

                }
            }
            $file_name = $boletim->files->where('hash_id', $hash_id)->first()->name;
            return response()->download($file_path, $file_name);
        }
        return 0;
    }

    public function viewfile(Boletim $boletim, $file_id)
    {
        $file_path = public_path('documents') . '/' . $boletim->files->where('id', $file_id)->first()->hash_id;
        if (!file_exists($file_path)) {
            $file_path = $file_path . '.pdf';
            if (!file_exists($file_path)) {
                return redirect('/boletins')->with('status', 'Erro ao tentar visualizar o documento ' . $boletim->name);
            }
        }

        return  Response::make(file_get_contents($file_path), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline'
        ]);
    }

    public function destroy(Boletim $boletim)
    {
        $boletim_name = $boletim->name;
        $boletim->delete();
        storeLog($this->getMasp(), $boletim->id, "delete", 0);

        return redirect(route('boletins.index'))->with('status', 'Boletim ' . $boletim_name . ' deletado com sucesso!');

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

    public function logs()
    {
        //$logs = \App\Log2::orderBy('id', 'DESC')->get();
        $logs = \App\Log::orderBy('id', 'DESC')->whereNULL('document_id')->get();
        return view('boletins.logs', ['logs' => $logs]);
    }

    public function dumpArray($array) {
        echo "<pre>";
        var_dump($array);
        echo "</pre>";
    }
}
