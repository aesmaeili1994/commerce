<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductImageController extends Controller
{
    public function upload($primaryImage,$images)
    {
        $fileNameImagePrimary=generateFileName($primaryImage->getClientOriginalName());
        $primaryImage->move(public_path(env('PRODUCT_IMAGES_UPLOAD_PATH')),$fileNameImagePrimary);

        $fileNameImages=[];
        foreach ($images as $image){
            $fileNameImage=generateFileName($image->getClientOriginalName());
            $image->move(public_path(env('PRODUCT_IMAGES_UPLOAD_PATH')),$fileNameImage);
            array_push($fileNameImages,$fileNameImage);
        }
        return ['fileNameImagePrimary'=>$fileNameImagePrimary,'fileNameImages'=>$fileNameImages];
    }
}
