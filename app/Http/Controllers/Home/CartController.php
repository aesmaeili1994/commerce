<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariation;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $request->validate([
            'product_id'=>'required',
            'qtybutton'=>'required'
        ]);

        $product=Product::findOrFail($request->product_id);
        $productVariation=ProductVariation::findOrFail(json_decode($request->variation)->id);

        if ($request->qtybutton > $productVariation->quantity) {
            alert()->error('محدودیت تعداد لطفا تعداد کمتری انتخاب کنید','توجه کنید');
            return redirect()->back();
        }

        $rowId = $product->id.'-'.$productVariation->id;

        if (\Cart::get($rowId) == null) {

            // add the product to cart
            \Cart::add(array(
                'id' => $rowId,
                'name' => $product->name,
                'price' => $productVariation->is_sale ? $productVariation->sale_price : $productVariation->price,
                'quantity' => $request->qtybutton,
                'attributes' => $productVariation->toArray(),
                'associatedModel' => $product
            ));

        }else{
            alert()->warning('این محصول قبلا به سبد خرید شما اضافه شده است','دقت کنید');
            return redirect()->back();
        }

        alert()->success('محصول مورد نظر به سبد خرید شما اضافه شد','با تشکر');
        return redirect()->back();

    }


    public function index()
    {
        return view('home.cart.index');
    }

    public function update(Request $request)
    {
        $request->validate([
            'qtybutton'=>'required'
        ]);

        foreach ($request->qtybutton as $rowId => $quantity){
            $item=\Cart::get($rowId);
            if ($quantity > $item->attributes->quantity) {
                alert()->error('تعداد وارد شده از محصول درست نمی باشد','توجه کنید');
                return redirect()->back();
            }
            \Cart::update($rowId,array(
                'quantity'=>array(
                    'relative'=>false,
                    'value'=> $quantity
                ),
            ));
        }
        alert()->success('سبد خرید شما به روز شد','با تشکر');
        return redirect()->back();
    }

    public function remove($rowId)
    {
        \Cart::remove($rowId);
        alert()->success('محصول مورد نظر از سبد خرید شما حذف شد','با تشکر');
        return redirect()->back();
    }

    public function clear()
    {
        \Cart::clear();
        alert()->warning('سبد خرید شما خالی شد','دقت کنید');
        return redirect()->back();
    }

    public function checkCoupon(Request $request)
    {
        $request->validate([
            'code'=>'required'
        ]);

        if (! auth()->check()) {
            alert()->error('برای استفاده از کد تخفیف ابتدا وارد سایت شوید','دقت کنید');
            return redirect()->back();
        }

        $result = checkCoupon($request->code);

        if (array_key_exists('error',$result)) {
            alert()->error($result['error'],'دقت کنید');
        }else{
            alert()->success($result['success'],'باتشکر');
        }

        return redirect()->back();
    }
}
