<?php

function uploadFile($request, $document, $type)
{
    $file = new App\File;
    $file->name = $_FILES['file_name_'.$type]['name'];
    $file_ = $_FILES['file_name_'.$type]['name'];

    $file_info = new SplFileInfo($file_);
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

    $date = date('d/m/Y', strtotime($document->date));
    $file->alias = $document->name . '_' . $date;

    $file->document_id = $document->id;

    $file->save();

    if ($type == 'pdf') {
        $request->file_name_pdf->storeAs('documents', $file->alias. '_' .$file->extension);
    }
    elseif ($type == 'doc') {
        $request->file_name_doc->storeAs('documents', $file->alias. '_' .$file->extension);
    }
}
