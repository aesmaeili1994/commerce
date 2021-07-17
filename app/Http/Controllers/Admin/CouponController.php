<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons=Coupon::latest()->paginate(20);
        return view('admin.coupons.index',compact('coupons'));
    }

    public function create()
    {
        return view('admin.coupons.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'code'=>'required|unique:coupons,code',
            'type'=>'required',
            'amount'=>'required_if:type,=,amount',
            'percentage'=>'required_if:type,=,percentage',
            'max_percentage_amount'=>'required_if:type,=,percentage',
            'expired_at'=>'required',
        ]);

        Coupon::create([
            'name'=>$request->name,
            'code'=>$request->code,
            'type'=>$request->type,
            'amount'=>$request->amount,
            'percentage'=>$request->percentage,
            'max_percentage_amount'=>$request->max_percentage_amount,
            'expired_at'=>convertShamsiToMiladi($request->expired_at),
            'description'=>$request->description
        ]);

        alert()->success('کوپن مورد نظر با موفقیت ایجاد شد', 'با تشکر');
        return redirect()->route('admin.coupons.index');
    }

    public function show($id)
    {
        //
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
