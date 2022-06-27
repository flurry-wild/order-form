<?php

namespace App\Providers;

use App\Clients\DadataClient;
use App\Http\Requests\StoreOrderPost;
use Illuminate\Support\Facades\Config;
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
        $this->app->bind(DadataClient::class, function () {
            return new DadataClient(Config::get('dadata.token'), Config::get('dadata.secret'));
        });

        $this->app->bind(StoreOrderPost::class, function () {
            $storeOrderPost = new StoreOrderPost();
            $storeOrderPost->setDadataClient($this->app->make(DadataClient::class));

            return $storeOrderPost;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
