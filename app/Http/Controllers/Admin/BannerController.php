<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use function PHPUnit\Framework\fileExists;

class BannerController extends Controller
{
    public function index()
    {
        $banners=Banner::latest()->paginate(20);
        return view('admin.banners.index',compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'priority' => 'required|integer',
            'type' => 'required',
            'image'=>'required|mimes:jpg,jpeg,png,svg'
        ]);

        $fileName=generateFileName($request->image->getClientOriginalName());
        $request->image->move(public_path(env('BANNER_IMAGES_UPLOAD_PATH')), $fileName);

        Banner::create([
            'image' =>$fileName,
            'title' => $request->title,
            'text' => $request->text,
            'priority' => $request->priority,
            'is_active' => $request->is_active,
            'type' => $request->type,
            'button_text' => $request->button_text,
            'button_link' => $request->button_link,
            'button_icon' => $request->button_icon
        ]);

        alert()->success('بنر مورد نظر ایجاد شد', 'با تشکر');

        return redirect()->route('admin.banners.index');
    }

    public function show($id)
    {
        dd('reza inja show ast');
    }

    public function edit(Banner $banner)
    {
        return view('admin.banners.edit',compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'priority' => 'required|integer',
            'type' => 'required',
            'image'=>'nullable|mimes:jpg,jpeg,png,svg'
        ]);

        if ($request->has('image')) {
            $fileName=generateFileName($request->image->getClientOriginalName());
            $request->image->move(public_path(env('BANNER_IMAGES_UPLOAD_PATH')), $fileName);

            if(file_exists(public_path(env('BANNER_IMAGES_UPLOAD_PATH')).$banner->image)) {
                unlink(public_path(env('BANNER_IMAGES_UPLOAD_PATH').$banner->image));
            }
        }

        $banner->update([
            'image' => $request->has('image') ? $fileName : $banner->image,
            'title' => $request->title,
            'text' => $request->text,
            'priority' => $request->priority,
            'is_active' => $request->is_active,
            'type' => $request->type,
            'button_text' => $request->button_text,
            'button_link' => $request->button_link,
            'button_icon' => $request->button_icon
        ]);

        alert()->success('بنر مورد نظر ویرایش شد', 'با تشکر');

        return redirect()->route('admin.banners.index');
    }

    public function destroy(Banner $banner)
    {
        $banner->delete();
        if(file_exists(public_path(env('BANNER_IMAGES_UPLOAD_PATH')).$banner->image)) {
            unlink(public_path(env('BANNER_IMAGES_UPLOAD_PATH').$banner->image));
        }

        alert()->success('بنر مورد نظر حذف شد', 'با تشکر');

        return redirect()->route('admin.banners.index');
    }
}
