<?php

namespace App\Http\Controllers;

use App\Boletim;
use App\Helpers\CollectionHelper;
use App\Http\Requests\BoletimRequest;
use App\Http\Requests\BoletimUpdateRequest;
use App\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;

require_once  ('../app/Helpers/'. 'BoletinsFilterHelper.php');
require_once  ('../app/Helpers/'. 'SortHelper.php');
require_once  ('../app/Helpers/'. 'LogsHelper.php');
require_once  ('../app/Helpers/'. 'Session.php');

class BoletinsController extends Controller
{
    public function refreshSession()
    {
        sessionRefresh();
        return redirect(route('boletins.index'));
    }

    public function index(Request $request)
    {
        if (!Session::has('admin')) {
            UsersController::setViewAsUser();
        }
        $boletins = getFilteredBoletins($request);
        $boletins = getOrderedDocuments($request, $boletins);
        $boletins = CollectionHelper::paginate($boletins , count($boletins), CollectionHelper::perPage());
        return view('boletins.index', ['boletins' => $boletins, 'admin' => UsersController::isAdminView()]);
    }

    public function show(Boletim $boletim)
    {
        if (count($boletim->files->where('alias')->all()) == 0) {
            if (UsersController::isAdminView())
                return view('boletins.edit', compact('document'));
            return $this->index();
        }
        $boletim = Boletim::find($boletim->id);

        $pdf_file = $boletim->files->whereNotNull('alias')->last();
        $files = $boletim->files->whereNull('alias')->all();
        return view('boletins.show', ['boletim' => $boletim, 'files' => $files, 'pdf_file' => $pdf_file, 'admin' => UsersController::isAdminView()]);
    }

    public function create()
    {
        return view('boletins.create');
    }

    public function store(BoletimRequest $request)
    {
        $request->validated();
        $boletim = new Boletim(request(['category_id', 'name', 'description', 'date']));

        $boletim->user_masp = UsersController::getMasp();
        $boletim->save();

        $file_pdf = new FilesController();
        $file_pdf->uploadFile($request, $boletim, 'pdf', 0);

        storeLog(UsersController::getMasp(), $boletim->id, "create", 0);

        //return redirect(route('boletins.index'))->with('status', "Boletim criado com sucesso!");
        return redirect($boletim->path())->with('status', 'Boletim ' . $boletim->name . ' criado com sucesso!');

    }

    public function edit(Boletim $boletim)
    {
        return view('boletins.edit', compact('boletim'));
    }

    public function update(BoletimUpdateRequest $request, Boletim $boletim)
    {
        $files = new FilesController();
        $boletim->update($request->validated());

        if (request('file_name_pdf')) {
            $file_pdf = new FilesController();
            $file_pdf->uploadFile($request, $boletim, 'pdf', 0);
            if (count($boletim->files->where('alias')->all()) != 0)
                $boletim->files->whereNotNull('alias')->first()->delete();
            $files->uploadFile($request, $boletim, 'pdf', 0);

            //$old_pdf = $boletim->files->whereNotNull('alias')->first();
            //File::destroy($old_pdf->id);
        }

        storeLog(UsersController::getMasp(), $boletim->id, "update", 0);

        return redirect($boletim->path())->with('status', 'Documento ' . $boletim->name . ' atualizado com sucesso!');
    }

    public function download(Boletim $boletim, $hash_id)
    {
        if ($hash_id != null) {
            $file_path = public_path('documents') . '/' . $hash_id;
            if (!file_exists($file_path)) {
                $file_path = $file_path . '.pdf';
                if (!file_exists($file_path)) {
                    return redirect(route('boletins.index'))->with('status', 'Erro ao tentar fazer download da(o) ' . $boletim->name);

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
        storeLog(UsersController::getMasp(), $boletim->id, "delete", 0);

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

    public function logs()
    {
        $logs = Log::orderBy('id', 'DESC')->whereNULL('document_id')->get();
        $logs = CollectionHelper::paginate($logs , count($logs), CollectionHelper::perPage());

        return view('boletins.logs', ['logs' => $logs]);
    }

    public function dumpArray($array) {
        echo "<pre>";
        var_dump($array);
        echo "</pre>";
    }
}
