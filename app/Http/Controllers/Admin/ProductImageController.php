<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductImageController extends Controller
{
    public function upload($primaryImage, $images)
    {
        $fileNameImagePrimary = generateFileName($primaryImage->getClientOriginalName());
        $primaryImage->move(public_path(env('PRODUCT_IMAGES_UPLOAD_PATH')), $fileNameImagePrimary);

        $fileNameImages = [];
        foreach ($images as $image) {
            $fileNameImage = generateFileName($image->getClientOriginalName());
            $image->move(public_path(env('PRODUCT_IMAGES_UPLOAD_PATH')), $fileNameImage);
            array_push($fileNameImages, $fileNameImage);
        }
        return ['fileNameImagePrimary' => $fileNameImagePrimary, 'fileNameImages' => $fileNameImages];
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit_images', compact('product'));
    }

    public function destroy(Request $request)
    {

        $request->validate([
            'image_id' => 'required|exists:product_images,id'
        ]);

        $imageName=ProductImage::findOrFail($request->image_id)->image;

        if(file_exists('upload/files/products/images/'.$imageName)){
            unlink('upload/files/products/images/'.$imageName);
        }

        ProductImage::destroy($request->image_id);

        alert()->success('تصویر محصول مورد نظر حذف شد', 'با تشکر');

        return redirect()->back();
    }

    public function setPrimary(Request $request, Product $product)
    {
        $request->validate([
            'image_id' => 'required|exists:product_images,id'
        ]);

        $productImage = ProductImage::findOrFail($request->image_id);

        if(file_exists('upload/files/products/images/'.$product->primary_image)){
            unlink('upload/files/products/images/'.$product->primary_image);
        }

        $product->update([
            'primary_image' => $productImage->image
        ]);


        ProductImage::destroy($productImage->id);

        alert()->success('ویرایش تصویر اصلی محصول با موفقیت انجام شد', 'با تشکر');

        return redirect()->back();
    }

    public function add(Request $request, Product $product)
    {

        $request->validate([
            'primary_image'=>'nullable|mimes:jpg,jpeg,png,svg',
            'images.*'=>'nullable|mimes:jpg,jpeg,png,svg'
        ]);

        if($request->primary_image == null && $request->images == null){
            return redirect()->back()->withErrors(['msg'=>'هیچ تصویری انتخاب نشده است']);
        }


        try {
            DB::beginTransaction();

            if ($request->has('primary_image')) {
                $fileNameImagePrimary = generateFileName($request->primary_image->getClientOriginalName());
                $request->primary_image->move(public_path(env('PRODUCT_IMAGES_UPLOAD_PATH')), $fileNameImagePrimary);
                if(file_exists('upload/files/products/images/'.$product->primary_image)){
                    unlink('upload/files/products/images/'.$product->primary_image);
                }
                $product->update([
                    'primary_image'=>$fileNameImagePrimary
                ]);
            }

            if ($request->has('images')) {
                foreach ($request->images as $image){
                    $fileNameImage = generateFileName($image->getClientOriginalName());
                    $image->move(public_path(env('PRODUCT_IMAGES_UPLOAD_PATH')), $fileNameImage);
                    ProductImage::create([
                        'product_id'=>$product->id,
                        'image'=>$fileNameImage
                    ]);
                }
            }

            DB::commit();
        }catch (\Exception $ex){
            DB::rollBack();
            alert()->error($ex->getMessage(),'مشکل در آپلود تصویر')->persistent('متوجه شدم');
            return redirect()->back();
        }

        alert()->success('آپلود تصاویر با موفقیت انجام شد', 'با تشکر');
        return redirect()->back();

    }
}
