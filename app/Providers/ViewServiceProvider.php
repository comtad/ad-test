<?php

namespace App\Providers;

use App\Category;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function register(){}

    public function boot()
    {
        View::composer('partials.header', function ($view) {
            $categories = Category::orderBy('name')->get(['id', 'name', 'slug']);
            $view->with('categories', $categories);
        });
    }
}
