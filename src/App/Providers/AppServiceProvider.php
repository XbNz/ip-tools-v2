<?php

namespace App\Providers;

use App\Application;
use App\Web\Homepage\Controllers\HomeController;
use Domain\IpAddressInfo\Actions\AdvancedIpDataAction;
use Domain\IpAddressInfo\Actions\GuaranteedIpDataAction;
use Hoa\Protocol\Bin\Resolve;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use XbNz\Resolver\Domain\Ip\Builders\DriverBuilder;
use XbNz\Resolver\Resolver\Resolver;
use XbNz\Resolver\Support\Drivers\Driver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->when([GuaranteedIpDataAction::class, AdvancedIpDataAction::class])
            ->needs('$drivers')
            ->give(function ($app) {
                return Collection::make(Config::get('services.ip_resolver_drivers_in_use'))
                    ->map(function (string $driverName) use ($app) {
                        return $app->make($driverName);
                    })->toArray();
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
