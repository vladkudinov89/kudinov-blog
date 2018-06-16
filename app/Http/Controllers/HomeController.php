<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use App\Tag;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Post::paginate(2);

//        $postsPopular = Post::orderBy('views' , 'desc')->take(3)->get();

//        dd($postsPopular);
//        $postsFeature = Post::where('is_featured' , 1)->take(3)->get();
//        dd($postsFeature);
//        $postsRecent = Post::orderBy('date' , 'desc')->take(4)->get();
//        dd($postsRecent);

//        $categories = Category::all();
//        $categories = Category::orderBy('created_at' , 'desc')->take(2)->get();
//        dd($categories);


       return view('pages.index' , [
           'posts' => $posts,
//           'postsPopular' => $postsPopular,
//           'postsFeature' => $postsFeature,
//           'postsRecent' => $postsRecent,
//           'categories' => $categories,
       ]);
    }

    public function show($slug)
    {
        $post = Post::where('slug' , $slug)->firstOrFail();
        //dd($post->id);
//        return view('pages.show' , [
//            'post' => $post
//        ]);
        return view('pages.show' ,compact('post'));
    }

    public function tag($slug)
    {
        $tag = Tag::where('slug' , $slug)->firstOrFail();
        $posts = $tag->posts()->paginate(2);
        return view('pages.list' , ['posts' => $posts]);
    }

    public function category($slug)
    {
        $category = Category::where('slug' , $slug)->firstOrFail();
        $posts = $category->posts()->paginate(2);

        return view('pages.list' , ['posts' => $posts]);
    }
}
