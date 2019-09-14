<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Resources\Json\Resource;

class AppServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        //So that I can access a single result without the JSON data{} wrapping
        // but then I can't do the metadata feature.
        // Resource::withoutWrapping();
    }
}
