<?php

namespace App\Providers;

use App\Category;
use App\Comment;
use App\Post;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('pages._sidebar' , function ($view){
            $view->with('postsPopular' , Post::getPostsPopular());
            $view->with('postsFeature' , Post::getPostsFeature());
            $view->with('postsRecent' , Post::getPostsRecent());
            $view->with('categories' , Category::all());
        });

        view()->composer('admin._sidebar' , function ($view){
            $view->with('newComments' , Comment::where('status' , 0)->count());
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
