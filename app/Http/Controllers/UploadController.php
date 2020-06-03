<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Document;
use App\Http\Requests\UploadRequest;

class UploadController extends Controller
{
    public function uploadForm()
    {
        return view('upload_form');
    }

    public function uploadSubmit(Request $request)
    {
        $document = Document::find(196);
        foreach ($request->files as $file) {
            $filename = $file->store('documents');
            File::create([
                'document_id' => $document->id,
                'name' => $filename
            ]);
            echo $filename;
        }
        return 'Upload successful!';

        $product = Product::create($request->all());
        foreach ($request->photos as $photo) {
            $filename = $photo->store('photos');
            ProductsPhoto::create([
                'product_id' => $product->id,
                'filename' => $filename
            ]);
        }
        return 'Upload successful!';
    }
}
