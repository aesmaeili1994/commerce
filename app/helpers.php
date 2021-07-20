<?php

use Carbon\Carbon;

function generateFileName($name){
    $year=Carbon::now()->year;
    $month=Carbon::now()->month;
    $day=Carbon::now()->day;
    $hour=Carbon::now()->hour;
    $minute=Carbon::now()->minute;
    $second=Carbon::now()->second;
    $microsecond=Carbon::now()->microsecond;
    return $year.'_'.$month.'_'.$day.'_'.$hour.'_'.$minute.'_'.$second.'_'.$microsecond.'_'.$name;
}

function convertShamsiToMiladi($dateTimeShamsi){
    if ($dateTimeShamsi == null) {
        return null;
    }

    //  [-\s] => \s => any space  &  - => -
    $pattern="/[-\s]/";
    $shamsiDateSplit=preg_split($pattern,$dateTimeShamsi);
    $dateMiladi=Verta::getGregorian($shamsiDateSplit[0],$shamsiDateSplit[1],$shamsiDateSplit[2]);
    $dateTimeMiladi=implode("-",$dateMiladi)." ".$shamsiDateSplit[3];
    return $dateTimeMiladi;
}

function cartTotalSaleAmount(){
    $cartTotalSaleAmount=0;
    foreach (\Cart::getContent() as $item){
        if ($item->attributes->is_sale) {
            $cartTotalSaleAmount += $item->quantity * ($item->attributes->price - $item->attributes->sale_price );
        }
    }
    return $cartTotalSaleAmount;
}

function cartTotalDeliveryAmount(){
    $cartTotalDeliveryAmount = 0;
    foreach (\Cart::getContent() as $item){
        $cartTotalDeliveryAmount += $item->associatedModel->delivery_amount;
    }
    return $cartTotalDeliveryAmount;
}

function cartTotalAmount(){
    if (session()->has('coupon')) {
        if ( session()->get('coupon.amount') > \Cart::getTotal() ) {
            return 0;
        }else{
            return \Cart::getTotal() - session()->get('coupon.amount');
        }
    }else{
        return \Cart::getTotal();
    }
}

function checkCoupon($code){
    $coupon = \App\Models\Coupon::where('code',$code)->where('expired_at','>',Carbon::now())->first();
    if ($coupon == null) {
        session()->forget('coupon');
        return ['error'=>'کد تخفیف وارد شده وجود ندارد'];
    }

    if ( \App\Models\Order::where('user_id',auth()->id())->where('coupon_id',$coupon->id)->where('payment_status',1)->exists()  ) {
        session()->forget('coupon');
        return ['error'=>'این کد تخفیف قبلا استفاده شده است'];
    }

    if ($coupon->getRawOriginal('type')=='amount' ) {
        session()->put('coupon',['id' => $coupon->id ,'code' => $coupon->code , 'amount' => $coupon->amount]);
    }else{
        $total=\Cart::getTotal();
        $amount=(($total*$coupon->percentage)/100) > $coupon->max_percentage_amount ? $coupon->max_percentage_amount : (($total*$coupon->percentage)/100);
        session()->put('coupon',['id' => $coupon->id ,'code' => $coupon->code , 'amount' => $amount]);
    }
    return ['success'=>'کد تخفیف برای شما ثبت شد'];
}

function province_name($provinceId){
    return \App\Models\Province::findOrFail($provinceId)->name;
}

function city_name($cityId){
    return \App\Models\City::findOrFail($cityId)->name;
}



