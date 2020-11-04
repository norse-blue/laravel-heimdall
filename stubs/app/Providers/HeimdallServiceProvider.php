<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HeimdallServiceProvider extends ServiceProvider
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
        $this->configurePermissions();
        $this->configureRoles();
    }

    /**
     * Configure additional permissions that are available within the application.
     *
     * @return void
     */
    protected function configurePermissions()
    {
        // 
    }
    
    /**
     * Configure additional roles that are available within the application.
     *
     * @return void
     */
    protected function configureRoles()
    {
        // 
    }
}
