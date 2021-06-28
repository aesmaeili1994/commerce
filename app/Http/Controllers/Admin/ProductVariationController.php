<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductVariation;
use Illuminate\Http\Request;

class ProductVariationController extends Controller
{
    public function store($variations,$attributeId,$productId)
    {
        $count=count($variations['value']);
        for ($i=0 ; $i<$count ; $i++){
            ProductVariation::create([
                'attribute_id'=>$attributeId,
                'product_id'=>$productId,
                'value'=>$variations['value'][$i],
                'price'=>$variations['price'][$i],
                'quantity'=>$variations['quantity'][$i],
                'sku'=>$variations['sku'][$i]
            ]);
        }
    }

    public function update($variation_ids)
    {
        foreach ($variation_ids as $key => $values){
            $productVariatin=ProductVariation::findOrFail($key);

            $productVariatin->update([
                 'price'=>$values['price'],
                 'quantity'=>$values['quantity'],
                 'sku'=>$values['sku'],
                 'sale_price'=>$values['sale_price'],
                 'date_on_sale_from'=>convertShamsiToMiladi($values['date_on_sale_from']),
                 'date_on_sale_to'=>convertShamsiToMiladi($values['date_on_sale_to'])
             ]);
        }
    }

    public function change($variations,$attributeId,$productId)
    {
        ProductVariation::where('product_id',$productId)->delete();

        $count=count($variations['value']);
        for ($i=0 ; $i<$count ; $i++){
            ProductVariation::create([
                'attribute_id'=>$attributeId,
                'product_id'=>$productId,
                'value'=>$variations['value'][$i],
                'price'=>$variations['price'][$i],
                'quantity'=>$variations['quantity'][$i],
                'sku'=>$variations['sku'][$i]
            ]);
        }
    }

}
