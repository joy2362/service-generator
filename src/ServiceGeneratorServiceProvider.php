<?php

namespace Joy2362\ServiceGenerator;

use Illuminate\Support\ServiceProvider;
use Joy2362\ServiceGenerator\Command\{CSGenerator, ServiceGenerator, TraitGenerator};

class ServiceGeneratorServiceProvider extends ServiceProvider
{
    protected string $serviceStubPath = __DIR__ . '/Stubs/Service.stub';
    protected string $apiServiceStubPath = __DIR__ . '/Stubs/Service.api.stub';
    protected string $controllerStubPath = __DIR__ . '/Stubs/Controller.stub';
    protected string $apiControllerStubPath = __DIR__ . '/Stubs/Controller.api.stub';
    protected string $requestStubPath = __DIR__ . '/Stubs/Request.stub';
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
                TraitGenerator::class,
                CSGenerator::class,
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
        $this->loadTranslationsFrom(__DIR__.'/Lang/en/resource.php', 'apiHelper');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                $this->serviceStubPath => resource_path('stubs/joy2362/service.stub'),
                $this->apiServiceStubPath => resource_path('stubs/joy2362/service.api.stub'),
                $this->traitStubPath => resource_path('stubs/joy2362/trait.stub'),
                $this->controllerStubPath => resource_path('stubs/joy2362/controller.stub'),
                $this->apiControllerStubPath => resource_path('stubs/joy2362/controller.api.stub'),
                $this->requestStubPath => resource_path('stubs/joy2362/request.stub'),
            ], 'service-generator');
        }
    }
}
