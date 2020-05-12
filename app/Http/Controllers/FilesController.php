<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\File;

class FilesController extends Controller
{
    public function uploadFile($request, $document, $type)
    {
        $file = new File(request(['name', 'extension', 'type', 'size', 'alias']));

        $file->name = $_FILES['file_name_'.$type]['name'];
        $file_ = $_FILES['file_name_'.$type]['name'];

        $file_info = new \SplFileInfo($file_);
        $extension = $file_info->getExtension();
        $file->extension = $extension;

        $file->type = $_FILES['file_name_'.$type]['type'];

        $units = ['B', 'KB', 'MB', 'GB'];
        $file_size = $request->file('file_name_'.$type)->getSize();
        for ($i = 0; $file_size > 1024; $i++) {
            $file_size /= 1000;
        }
        $file_size = round($file_size, 1) . ' ' . $units[$i];
        $file->size = $file_size;

        $file->alias = $document->name . '_' . $document->date . '.' . $file->extension;

        $file->document_id = $document->id;

        echo "<br>name " . $file->name;
        echo "<br>extension " . $file->extension;
        echo "<br>type " . $file->type;
        echo "<br>size " . $file->size;
        echo "<br>alias " . $file->alias;
        echo "<br>document id " . $file->document_id;

        $file->save();

        if ($type == 'pdf') {
            $request->file_name_pdf->storeAs('documents', $file->alias);
        }
        elseif ($type == 'doc') {
            $request->file_name_doc->storeAs('documents', $file->alias);
        }
    }
}
