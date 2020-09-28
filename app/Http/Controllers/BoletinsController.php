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

    public function viewfile(Boletim $boletim, $file_id)
    {
        $hash_id = $boletim->files->where('id', $file_id)->first()->hash_id;
        $file_path = FilesController::validatePDF($hash_id);

        if ($file_path)
            return FilesController::viewPDFFIle($file_path);

        return redirect('/boletins')->with('status', 'Erro ao tentar visualizar o documento ' . $boletim->name);
    }

    public function download(Boletim $boletim, $hash_id)
    {

        $file_path = FilesController::validatePDF($hash_id);
        if ($file_path) {
            $file_name = $boletim->files->where('hash_id', $hash_id)->first()->name;
            return FilesController::downloadPDFFile($file_path, $file_name);
        }

        return redirect(route('boletins.index'))->with('status', 'Erro ao tentar fazer download do boletim ' . $boletim->name);
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
        if(!UsersController::isUserSuperAdmin())  return redirect(route('boletins.index'));
        $boletins = Boletim::all();
        return view('boletins.failed_boletins', ['boletins' => $boletins]);
    }

    public function logs()
    {
        if(!UsersController::isUserSuperAdmin())  return redirect(route('boletins.index'));

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
