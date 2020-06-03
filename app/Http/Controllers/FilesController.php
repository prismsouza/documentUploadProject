<?php

namespace App\Http\Controllers;

use App\File;

class FilesController extends Controller
{
    public function uploadMultipleFiles($request, $document) {

        $files = $request->file('files');
        if($request->hasFile('files')){
            foreach ($files as $file) {
                $file->name = $file->getClientOriginalName();

                echo $file->name;
                //$file->name = $_FILES['Agendamento Doacao de Sangue Priscila.pdf']['name'];
                //$extension = $file->mimeType();
                //echo "e: " . $extension;
              //  dd($file);
                //$file->move('images',$name);
                //$productImage = ProductImage::create(['image'=>$name]);
               // $input ['product_image_id'] = $document->id;
            }
        }

           // dd($request);
        $file = new File(request(['name', 'extension', 'type', 'size', 'alias']));
        $file->name = "arquivoteste";
        $request->originalName->storeAs('documents', $file->alias);
    }

    public function uploadFile($request, $document, $type)
    {
        dd($request);
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

        $date = date('d-m-Y', strtotime($document->date));
        $file->alias = $document->name . '_' . $date . '.' . $file->extension;

        $file->document_id = $document->id;


        $file->save();
        $request->file_name_pdf->storeAs('documents', $file->alias);
    }
}
