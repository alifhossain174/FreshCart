<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    public function blogs(){
        $blogCategories = DB::table('blog_categories')->where('status', 1)->orderBy('serial', 'asc')->get();
        $randomBlogs = DB::table('blogs')->where('status', 1)->inRandomOrder()->skip(0)->limit(6)->get();
        $blogs = DB::table('blogs')
                    ->leftJoin('blog_categories', 'blogs.category_id', 'blog_categories.id')
                    ->select('blogs.*', 'blog_categories.name as category_name')
                    ->where('blogs.status', 1)
                    ->orderBy('blogs.id', 'desc')
                    ->paginate(2);

        return view('blogs', compact('blogs', 'blogCategories', 'randomBlogs'));
    }

    public function blogCategory($slug){
        $blogCategories = DB::table('blog_categories')->where('status', 1)->orderBy('serial', 'asc')->get();
        $blogCategory = DB::table('blog_categories')->where('slug', $slug)->first();
        $randomBlogs = DB::table('blogs')->where('status', 1)->inRandomOrder()->skip(0)->limit(6)->get();
        $blogs = DB::table('blogs')
                    ->leftJoin('blog_categories', 'blogs.category_id', 'blog_categories.id')
                    ->select('blogs.*', 'blog_categories.name as category_name')
                    ->where('blogs.status', 1)
                    ->where('blogs.category_id', $blogCategory->id)
                    ->orderBy('blogs.id', 'desc')
                    ->paginate(6);

        return view('blogs', compact('blogs', 'blogCategories', 'blogCategory', 'randomBlogs'));
    }

    public function blogDetails($slug){

        $blog = DB::table('blogs')
                ->leftJoin('blog_categories', 'blogs.category_id', 'blog_categories.id')
                ->select('blogs.*', 'blog_categories.name as category_name')
                ->where('blogs.slug', $slug)
                ->first();

        $blogCategories = DB::table('blog_categories')->where('status', 1)->orderBy('serial', 'asc')->get();
        $recentBlogs = DB::table('blogs')->where('status', 1)->where('id', '!=', $blog->id)->orderBy('id', 'desc')->skip(0)->limit(6)->get();
        $randomBlogs = DB::table('blogs')->where('status', 1)->where('id', '!=', $blog->id)->inRandomOrder()->skip(0)->limit(6)->get();
        return view('blog_details', compact('blog', 'blogCategories', 'recentBlogs', 'randomBlogs'));
    }
}
