<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Region;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {    
        if(Schema::hasTable('categories'))
        {
            $categories=Category::whereNull('parent_id')->get();
            View::share('categories',$categories);
        }
        
        if(Schema::hasTable('regions'))
        {
            $regions=Region::all();
            View::share('regions',$regions);
        }
    }
}
