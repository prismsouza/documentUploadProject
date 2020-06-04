<?php

namespace App\Http\Controllers;

use App\File;

class FilesController extends Controller
{
    public function uploadMultipleFiles($request, $document)
    {

        $files = $request->file('files');
        if ($request->hasFile('files')) {
            foreach ($files as $file) {
                $file_toUpload = new File(request(['name', 'extension', 'type', 'size', 'alias']));
                $file_toUpload->document_id = $document->id;
                $file_toUpload->name = $file->getClientOriginalName();
                $file_toUpload->extension = $file->extension();
                $file_toUpload->type = $file->getMimeType();
                $file_toUpload->size = $this->convertSize($file->getSize());
                $file_toUpload->alias = null;
                $file->storeAs('documents', $file_toUpload->name);
                $file_toUpload->save();
            }
        }
    }

    public function uploadFile($request, $document, $type)
    {
        $file = new File(request(['name', 'extension', 'type', 'size', 'alias']));

        $file->name = $_FILES['file_name_' . $type]['name'];
        $file_ = $_FILES['file_name_' . $type]['name'];

        $file_info = new \SplFileInfo($file_);
        $extension = $file_info->getExtension();
        $file->extension = $extension;

        $file->type = $_FILES['file_name_' . $type]['type'];

        /*$units = ['B', 'KB', 'MB', 'GB'];
        $file_size = $request->file('file_name_'.$type)->getSize();
        for ($i = 0; $file_size > 1024; $i++) {
            $file_size /= 1000;
        }
        $file_size = round($file_size, 1) . ' ' . $units[$i];
        $file->size = $file_size;*/

        $file->size = $this->convertSize($request->file('file_name_' . $type)->getSize());

        $date = date('d-m-Y', strtotime($document->date));
        $file->alias = $document->name . '_' . $date . '.' . $file->extension;

        $file->document_id = $document->id;


        $file->save();
        $request->file_name_pdf->storeAs('documents', $file->alias);
    }

    public function convertSize($file_size)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        for ($i = 0; $file_size > 1024; $i++) {
            $file_size /= 1000;
        }
        return round($file_size, 2) . ' ' . $units[$i];
    }
}
