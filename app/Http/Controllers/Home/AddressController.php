<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Province;
use App\Models\UserAddress;
use Illuminate\Http\Request;

class AddressController extends Controller
{

    public function index()
    {
        $addresses=UserAddress::where('user_id',auth()->id())->get();
        $provinces=Province::all();
        return view('home.users_profile.addresses',compact('provinces','addresses'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validateWithBag('addressStore',[
            'title'=>'required',
            'cellphone' =>'required',
            'province_id' =>'required',
            'city_id' =>'required',
            'address' =>'required',
            'postal_code' =>'required'
        ]);
        UserAddress::create([
            'user_id'=>auth()->id(),
            'title'=>$request->title,
            'cellphone' =>$request->cellphone,
            'province_id' =>$request->province_id,
            'city_id' =>$request->city_id,
            'address' =>$request->address,
            'postal_code' =>$request->postal_code
        ]);
        alert()->success('آدرس با موفقیت ثبت شد','باتشکر');
        return redirect()->back();
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, UserAddress $address)
    {

        $validator = \Illuminate\Support\Facades\Validator::make($request->all(),[
            'title'=>'required',
            'cellphone' =>'required',
            'province_id' =>'required',
            'city_id' =>'required',
            'address' =>'required',
            'postal_code' =>'required'
        ]);

        if ($validator->fails()) {
            $validator->errors()->add('address_id',$address->id);
            return redirect()->back()->withErrors($validator,'addressUpdate')->withInput();
        }

        $address->update([
            'title'=>$request->title,
            'cellphone' =>$request->cellphone,
            'province_id' =>$request->province_id,
            'city_id' =>$request->city_id,
            'address' =>$request->address,
            'postal_code' =>$request->postal_code
        ]);
        alert()->success('آدرس با موفقیت ویرایش شد','باتشکر');
        return redirect()->route('home.addresses.index');
    }

    public function destroy($id)
    {
        //
    }

    public function getProvinceCitiesList(Request $request)
    {
        $cities=City::where('province_id',$request->province_id)->get();
        return $cities;
    }
}
