<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /*        View::composer('backend.wizard.affected-gender', AffectedGenderComposer::class);*/
        /*        View::composer('admin::layouts.partials.navbar-message', MessageDropDownComposer::class);
                View::composer('admin::layouts.partials.navbar-shortcut', NavbarShortcutComposer::class);
                View::composer('admin::layouts.partials.navbar-notification', NotificationDropDownComposer::class);*/
        /*        View::composer(['admin::layouts.partials.navbar-user', 'admin::layouts.partials.menu-sidebar'], UserDropDownComposer::class);*/
    }
}
