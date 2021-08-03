<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function index()
    {
        return view('home.users_profile.index');
    }

    public function logout()
    {
        auth()->logout();
        alert()->success('خروج شما موفقیت آمیز بود','باتشکر');
        return redirect()->route('home.index');
    }
}
