<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        $this->bootDoximitySocialite();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        if ($this->app->environment() == 'local') {
            $this->app->register('Hesto\MultiAuth\MultiAuthServiceProvider');
        }
    }

    private function bootDoximitySocialite()
    {
        $socialite = $this->app->make('Laravel\Socialite\Contracts\Factory');
        $socialite->extend(
            'doximity',
            function ($app) use ($socialite) {
                $config = $app['config']['services.doximity'];
                return $socialite->buildProvider(\App\Libraries\Doximity\Provider::class, $config);
            }
        );
    }

}
