<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index(){
        $sliders = DB::table('banners')->where('type', 1)->where('status', 1)->orderBy('serial', 'asc')->get();
        $topBanners = DB::table('banners')->where('type', 2)->where('position', 'top')->where('status', 1)->orderBy('serial', 'asc')->get();
        $categories = DB::table('categories')->where('status', 1)->where('show_on_navbar', 1)->orderBy('serial', 'asc')->get();
        $featuredCategories = DB::table('categories')->where('status', 1)->where('featured', 1)->orderBy('serial', 'asc')->get();
        return view('index', compact('sliders', 'topBanners', 'categories', 'featuredCategories'));
    }
}
