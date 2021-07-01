<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
    //start test---------------------------------
//        $product=Product::find(10);
//        dd($product->quantity_check->price);
//        dd($product->getSaleCheck()->sale_price);
    //end test-----------------------------------

        //image slider
        $banners=Banner::where('type','slider')->where('is_active',1)->orderBy('priority')->get();

        //image top banner
        $bannersTop=Banner::where('type','index_top')->where('is_active',1)->orderBy('priority')->get();

        //image bottom banner
        $bannersBottom=Banner::where('type','index_bottom')->where('is_active',1)->orderBy('priority')->get();

        //get parentCategories
        $parentCategories=Category::where('parent_id',0)->get();

        //get products
        $products=Product::where('is_active',1)->get();

        return view('home.index',compact('banners','bannersTop','bannersBottom','parentCategories','products'));
    }
}
