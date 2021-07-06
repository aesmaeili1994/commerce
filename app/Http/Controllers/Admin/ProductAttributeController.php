<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductAttribute;
use Illuminate\Http\Request;

class ProductAttributeController extends Controller
{
    public function store($attribute_ids,$product_id)
    {
        foreach ($attribute_ids as $key => $value) {
            ProductAttribute::create([
                'attribute_id' =>$key,
                'product_id' =>$product_id,
                'value' =>$value
            ]);
        }
    }

    public function update($attribute_ids)
    {

        foreach ($attribute_ids as $key => $value) {
            $productAttribute=ProductAttribute::findOrFail($key);
            $productAttribute->update([
                'value' =>$value
            ]);
        }
    }

    public function change($attribute_ids,$product_id)
    {
        ProductAttribute::where('product_id',$product_id)->delete();

        foreach ($attribute_ids as $key => $value) {
            ProductAttribute::create([
                'attribute_id' =>$key,
                'product_id' =>$product_id,
                'value' =>$value
            ]);
        }
    }
}
