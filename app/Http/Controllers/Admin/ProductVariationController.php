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
}
