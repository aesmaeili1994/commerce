<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    public function index()
    {
        $attributes=Attribute::latest()->paginate(20);
        return view('admin.attributes.index',compact('attributes'));
    }

    public function create()
    {
        return view('admin.attributes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required'
        ]);

        Attribute::create([
            'name'=>$request->name
        ]);

        alert()->success('ویژگی مورد نظر ایجاد شد', 'با تشکر');

        return redirect()->route('admin.attributes.index');
    }

    public function show(Attribute $attribute)
    {
        return view('admin.attributes.show',compact('attribute'));
    }

    public function edit(Attribute $attribute)
    {
        return view('admin.attributes.edit',compact('attribute'));
    }

    public function update(Request $request, Attribute $attribute)
    {
        $request->validate([
            'name'=>'required'
        ]);

        $attribute->update([
            'name'=>$request->name
        ]);

        alert()->success('ویژگی مورد نظر ویرایش شد', 'با تشکر');

        return redirect()->route('admin.attributes.index');
    }

    public function destroy($id)
    {
        //
    }
}
