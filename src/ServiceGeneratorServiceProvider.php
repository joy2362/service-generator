<?php

namespace Joy2362\ServiceGenerator;

use Illuminate\Support\ServiceProvider;
use Joy2362\ServiceGenerator\Command\ServiceGenerator;

class ServiceGeneratorServiceProvider extends ServiceProvider
{
    protected string $serviceStubPath = __DIR__ . '/Stubs/Service.stub';
    protected string $apiServiceStubPath = __DIR__ . '/Stubs/Service.api.stub';
    protected string $traitStubPath = __DIR__ . '/Stubs/Trait.stub';

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                ServiceGenerator::class,
            ]);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                $this->serviceStubPath => resource_path('stubs/joy2362/service.stub'),
                $this->apiServiceStubPath => resource_path('stubs/joy2362/service.api.stub'),
                $this->traitStubPath => resource_path('stubs/joy2362/trait.stub'),
            ], 'service-generator');
        }
    }
}
