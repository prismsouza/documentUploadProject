<?php

namespace App\Http\Controllers;

use App\File;

class EmentarioController extends Controller
{

    public function edit()
    {
        return view('categories.ementario_edit');
    }

    public function update()
    {
        $fileObj = new FilesController();

        if ($_FILES['file_name_pdf']['error'])
            return redirect(route('ementario.edit'))->with('status', 'ERRO no upload do Ementário');

        $file_to_delete = File::all()->where('alias', 'ementario')->first();
        $fileObj->destroy($file_to_delete);

        $fileObj->uploadDetachedPDFFile('ementario');
        return redirect(route('documents.index'))->with('status', 'Ementário atualizado com sucesso!');
    }

    public function viewfile()
    {
        $file = File::where('alias', 'ementario')->first();
        $file_path = FilesController::validatePDF($file->hash_id);

        if ($file_path)
            return FilesController::viewPDFFIle($file_path);

        return redirect(route('documents.index'))->with('status', 'Erro ao tentar visualizar o Ementário');

    }

    public function download()
    {
        $file = File::all()->where('alias', 'ementario')->first();
        $file_path = FilesController::validatePDF($file->hash_id);

        if ($file_path) {
            $file_name = "Ementário - " . $file->created_at;
            return FilesController::downloadPDFFile($file_path, $file_name);
        }

        return redirect(route('documents.index'))->with('status', 'Erro ao tentar fazer download do Ementário');
    }
}
