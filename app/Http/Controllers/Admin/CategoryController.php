<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;

class CategoryController extends Controller
{
    public function index()
    {
        $categories=Category::latest()->paginate(20);
        return view('admin.categories.index',compact('categories'));
    }

    public function create()
    {
        $categories=Category::where('parent_id',0)->get();
        $attributes=Attribute::all();
        return view('admin.categories.create',compact('categories','attributes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'slug'=>'required|unique:categories,slug',
            'parent_id'=>'required',
            'attribute_ids'=>'required',
            'attribute_ids.*'=>'exists:attributes,id',
            'attribute_is_filter_ids'=>'required',
            'attribute_is_filter_ids.*'=>'exists:attributes,id',
            'variation_id'=>'required|exists:attributes,id'
        ]);

        try {
            DB::beginTransaction();

            $category=Category::create([
                'name'=>$request->name,
                'parent_id'=>$request->parent_id,
                'slug'=>$request->slug,
                'description'=>$request->description,
                'is_active'=>$request->is_active,
                'icon'=>$request->icon
            ]);

            foreach ($request->attribute_ids as $attributeId){
                $attribute=Attribute::findOrFail($attributeId);
                $attribute->categories()->attach($category->id,[
                    'is_filter'=>in_array($attributeId,$request->attribute_is_filter_ids) ? 1 : 0,
                    'is_variation'=> $attributeId == $request->variation_id ? 1 : 0
                ]);
            }

            DB::commit();

        }catch(\Exception $ex){
            DB::rollBack();
            alert()->error($ex->getMessage(),'مشکل در ایجاد دسته بندی')->persistent('متوجه شدم');
            return redirect()->back();
        }

        alert()->success('دسته بندی مورد نظر ایجاد شد', 'با تشکر');

        return redirect()->route('admin.categories.index');

    }

    public function show(Category $category)
    {
        return view('admin.categories.show',compact('category'));
    }

    public function edit(Category $category)
    {
        $parentCategories=Category::where('parent_id',0)->get();
        $attributes=Attribute::all();
        return view('admin.categories.edit',compact('category','parentCategories','attributes'));
    }

    public function update(Request $request,Category $category)
    {
        $request->validate([
            'name'=>'required',
            'slug'=>'required|unique:categories,slug,'.$category->id,
            'parent_id'=>'required',
            'attribute_ids'=>'required',
            'attribute_ids.*'=>'exists:attributes,id',
            'attribute_is_filter_ids'=>'required',
            'attribute_is_filter_ids.*'=>'exists:attributes,id',
            'variation_id'=>'required|exists:attributes,id'
        ]);

        try {

            DB::beginTransaction();

            $category->update([
                'name'=>$request->name,
                'parent_id'=>$request->parent_id,
                'slug'=>$request->slug,
                'description'=>$request->description,
                'is_active'=>$request->is_active,
                'icon'=>$request->icon
            ]);

            $category->attributes()->detach();

            foreach ($request->attribute_ids as $attributeId){
                $attribute=Attribute::findOrFail($attributeId);
                $attribute->categories()->attach($category->id,[
                    'is_filter'=>in_array($attributeId,$request->attribute_is_filter_ids) ? 1 : 0,
                    'is_variation'=> $attributeId == $request->variation_id ? 1 : 0
                ]);
            }


            DB::commit();

        }catch(\Exception $ex){
            DB::rollBack();
            alert()->error($ex->getMessage(),'مشکل در ویرایش دسته بندی')->persistent('متوجه شدم');
            return redirect()->back();
        }

        alert()->success('دسته بندی مورد نظر ویرایش شد', 'با تشکر');

        return redirect()->route('admin.categories.index');
    }

    public function destroy($id)
    {
        //
    }

    //for create page products section attributes&variation/ by route category-attributes/{category}
    public function getCategoryAttributes(Category $category)
    {
        $attributes=$category->attributes()->wherePivot('is_variation',0)->get();
        $variation=$category->attributes()->wherePivot('is_variation',1)->first();
        return ['attributes'=>$attributes,'variation'=>$variation];
    }
    //end
}
