<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\ContactUs;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;
use TimeHunter\LaravelGoogleReCaptchaV3\Validations\GoogleReCaptchaV3ValidationRule;

class HomeController extends Controller
{
    public function index()
    {
    //start test---------------------------------
//        $product=Product::find(8);
//        dd($product->attributes()->with('attribute')->first()->attribute->name);
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

    public function aboutUs()
    {
        $bannersAbout=Banner::where('type','index_bottom')->where('is_active',1)->orderBy('priority')->get();
        return view('home.about-us',compact('bannersAbout'));
    }

    public function contactUs()
    {
        $setting=Setting::findOrFail(1);
        return view('home.contact-us',compact('setting'));
    }

    public function contactUsForm(Request $request)
    {
        $request->validate([
            'name'=>'required|string|min:4|max:50',
            'email'=>'required|email',
            'subject'=>'required|string|min:4|max:100',
            'text'=>'required|string|min:4|max:3000',
            'g-recaptcha-response'=>[new GoogleReCaptchaV3ValidationRule('contact_us')]
        ]);

        ContactUs::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'subject'=>$request->subject,
            'text'=>$request->text
        ]);

        alert()->success('پیام با موفقیت ارسال شد','باتشکر');
        return redirect()->back();
    }
}
