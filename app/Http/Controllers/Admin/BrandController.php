<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        $brands=Brand::latest()->paginate(20);
        return view('admin.brands.index',compact('brands'));
    }

    public function create()
    {
        return view('admin.brands.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required'
        ]);

        Brand::create([
            'name'=>$request->name,
            'is_active'=>$request->is_active
        ]);

        alert()->success('برند مورد نظر ایجاد شد', 'با تشکر');

        return redirect()->route('admin.brands.index');
    }

    public function show(Brand $brand)
    {
        return view('admin.brands.show',compact('brand'));
    }

    public function edit(Brand $brand)
    {
        return view('admin.brands.edit',compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'name'=>'required'
        ]);

        $brand->update([
            'name'=>$request->name,
            'is_active'=>$request->is_active
        ]);

        alert()->success('برند مورد نظر ویرایش شد', 'با تشکر');

        return redirect()->route('admin.brands.index');
    }

    public function destroy($id)
    {
        //
    }
}
