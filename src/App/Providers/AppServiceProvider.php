<?php

namespace App\Providers;

use App\Application;
use App\Web\Homepage\Controllers\HomeController;
use Domain\IpAddressInfo\Actions\GuaranteedIpDataByIpForDriverAction;
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
        $this->app->when(GuaranteedIpDataByIpForDriverAction::class)
            ->needs('$drivers')
            ->give(
                Collection::make(Config::get('services.ip_resolver_drivers_in_use'))
                    ->map(function (string $driverName) {
                        return $this->app->make($driverName);
                    })->toArray()
            );
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
