<?php

namespace App\Http\Controllers;

use App\File;
use Illuminate\Support\Facades\Response;

class FilesController extends Controller
{
    public function uploadMultipleFiles($request, $document, $isDocument)
    {
        $files = (request('files'));
        $fileNamesToUpload = explode(',', request('filesToUpload')[0]);
        //$this->dumpArray($fileNamesToUpload);
        //die();

        $choosen_files = [];
        foreach ($files as $f) {
            if (in_array($f->getClientOriginalName(), $fileNamesToUpload)) {
                //echo $f->getClientOriginalName();
                array_push($choosen_files, $f);
            }
        }

            foreach ($choosen_files as $file) {
                $file_toUpload = new File(request(['name', 'extension', 'type', 'size', 'alias']));
                if ($isDocument) $file_toUpload->document_id = $document->id;
                else $file_toUpload->boletim_id = $document->id;
                $file_toUpload->name = $file->getClientOriginalName();
                $file_toUpload->extension = $file->extension();
                $file_toUpload->type = $file->getMimeType();
                $file_toUpload->size = $this->convertSize($file->getSize());
                $file_toUpload->alias = null;
                $file_toUpload->hash_id = sha1_file($file);
                $file->storeAs('documents', $file_toUpload->hash_id);
                $file_toUpload->save();
            }
    }

    public function uploadFile($request, $document, $type , $isDocument)
    {
        $file = new File(request(['name', 'extension', 'type', 'size', 'alias']));
        //$this->dumpArray($request->all());
        //echo "----- NEXTTTT ----  ";
        //$this->dumpArray($file);

            $file->name = $_FILES['file_name_' . $type]['name'];

            $file_ = $_FILES['file_name_' . $type]['name'];
            $file->hash_id = sha1_file($request->file_name_pdf);

            $file_info = new \SplFileInfo($file_);
            $extension = $file_info->getExtension();
            $file->extension = $extension;

            $file->type = $_FILES['file_name_' . $type]['type'];

            $file->size = $this->convertSize($request->file('file_name_' . $type)->getSize());

            $date = date('d-m-Y', strtotime($document->date));
            $file->alias = $document->name . '_' . $date . '.' . $file->extension;

            if ($isDocument)
                $file->document_id = $document->id;
            else
                $file->boletim_id = $document->id;

            $file->save();

            $request->file_name_pdf->storeAs('documents', $file->hash_id);
    }

    public function convertSize($file_size)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        for ($i = 0; $file_size > 1024; $i++) {
            $file_size /= 1000;
        }
        return round($file_size, 2) . ' ' . $units[$i];
    }

    public function deleteFile($files_id)
    {
        foreach ($files_id as $file_id) {
            $file = File::where('id', $file_id);
            $file->delete();
        }
    }

    public function destroy(File $file)
    {
        $file->delete();
        return redirect(route('documents.index'))->with('successMsg', 'Documento deletado');
    }

    public function uploadDetachedFile() {
        File::all()->where('alias', 'ementario')->first()->delete();

        $file = request('file_name_pdf');
        $file_toUpload = new File(request(['name', 'extension', 'type', 'size', 'alias']));
        //dd($file_toUpload);

        $file_toUpload->name = $_FILES['file_name_pdf']['name'];
        $file_toUpload->extension = 'pdf';
        $file_toUpload->type = 'application/pdf';
        $file_toUpload->size = $this->convertSize($_FILES['file_name_pdf']['size']);
        $file_toUpload->alias = 'ementario';
        $file_toUpload->hash_id = sha1_file($file);

        $file->storeAs('documents', $file_toUpload->hash_id);
        $file_toUpload->save();
    }

    public function download()
    {
        $files = File::all();
        $file = $files->where('alias', 'ementario')->first();

        $file_path = public_path('documents') . '/' . $file->hash_id;
        $file_name = "Ementario " . $file->created_at;
        return response()->download($file_path, $file_name);
    }

    public function viewfile()
    {
        $files = File::all();
        $file = $files->where('alias', 'ementario')->first();

        $file_path = public_path('documents') . '/' . $file->hash_id;

        return  Response::make(file_get_contents($file_path), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline'
        ]);
    }

    public function dumpArray($array) {
        echo "<pre>";
        var_dump($array);
        echo "</pre>";
    }
}
