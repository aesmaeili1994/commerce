<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function add(Product $product)
    {
        if (auth()->check()) {
            if ($product->checkUserWishlist(auth()->id())) {
                alert()->warning('این محصول قبلا به لیست علاقه مندی های شما اضافه شده است ','توجه کنید')->persistent('حله');
                return redirect()->back();
            }else{
                Wishlist::create([
                    'user_id'=>auth()->id(),
                    'product_id'=>$product->id
                ]);
                alert()->success('محصول مورد نظر به لیست علاقه مندی های شما اضافه شد', 'با تشکر');
                return redirect()->back();
            }
        }else{
            alert()->warning('برای افزودن به لیست علاقه مندی ها ابتدا وارد سایت شوید','توجه کنید')->persistent('حله');
            return redirect()->back();
        }
    }

    public function remove(Product $product)
    {
        if (auth()->check()) {
            $wishlist=Wishlist::where('product_id',$product->id)->where('user_id',auth()->id())->firstOrFail();
            if($wishlist){
                Wishlist::where('product_id',$product->id)->where('user_id',auth()->id())->delete();
            }
            alert()->success('محصول مورد نظر از لیست علاقه مندی ها حذف شد','با تشکر');
            return redirect()->back();
        }else{
            alert()->warning('برای حذف از لیست علاقه مندی ها ابتدا وارد سایت شوید','توجه کنید')->persistent('حله');
            return redirect()->back();
        }
    }

    public function usersProfileIndex()
    {
        $wishlist=Wishlist::where('user_id',auth()->id())->get();
        return view('home.users_profile.wishlist',compact('wishlist'));
    }
}
