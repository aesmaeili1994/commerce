<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{

    public function index()
    {
        $products=Product::latest()->paginate(20);
        return view('admin.products.index',compact('products'));
    }

    public function create()
    {
        $brands = Brand::all();
        $tags = Tag::all();
        $categories = Category::where('parent_id', '!=', 0)->get();
        return view('admin.products.create', compact('brands', 'tags', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'brand_id'=>'required',
            'is_active'=>'required',
            'tag_ids'=>'required',
            'description'=>'required',
            'category_id'=>'required',
            'attribute_ids'=>'required',
            'attribute_ids.*'=>'required',
            'variation_values'=>'required',
            'variation_values.*.*'=>'required',
            'variation_values.price.*'=>'integer',
            'variation_values.quantity.*'=>'integer',
            'delivery_amount'=>'required|integer',
            'delivery_amount_per_product'=>'nullable|integer',
            'primary_image'=>'required|mimes:jpg,jpeg,png,svg',
            'images'=>'required',
            'images.*'=>'mimes:jpg,jpeg,png,svg'
        ]);

        try {
            DB::beginTransaction();

            $productImageController = new ProductImageController();
            $fileNameImages = $productImageController->upload($request->primary_image, $request->images);

            $product = Product::create([
                'name' => $request->name,
                'brand_id' => $request->brand_id,
                'category_id' => $request->category_id,
                'primary_image' => $fileNameImages['fileNameImagePrimary'],
                'description' => $request->description,
                'is_active' => $request->is_active,
                'delivery_amount' => $request->delivery_amount,
                'delivery_amount_per_product' => $request->delivery_amount_per_product
            ]);

            foreach ($fileNameImages['fileNameImages'] as $fileNameImage) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $fileNameImage
                ]);
            }

            $productAttributeController = new ProductAttributeController();
            $productAttributeController->store($request->attribute_ids,$product->id);

            $category=Category::find($request->category_id);
            $productVariationController = new ProductVariationController();
            $productVariationController->store($request->variation_values,$category->attributes()->wherePivot('is_variation',1)->first()->id,$product->id);

            $product->tags()->attach($request->tag_ids);

            DB::commit();
        }catch (\Exception $ex){
            DB::rollBack();
            alert()->error($ex->getMessage(),'مشکل در ایجاد محصول')->persistent('متوجه شدم');
            return redirect()->back();
        }
        alert()->success('محصول مورد نظر ایجاد شد', 'با تشکر');

        return redirect()->route('admin.products.index');

    }

    public function show(Product $product)
    {
        $productAttributes=$product->attributes()->with('attribute')->get();
        $productVariations=$product->variations;
        $images=$product->images;
        return view('admin.products.show',compact('product','productAttributes','productVariations','images'));
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
