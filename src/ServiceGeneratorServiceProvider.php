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
    protected string $lang = __DIR__ . '/Lang/resource.php';

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
        $this->loadTranslationsFrom($this->lang, 'ApiHelper');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/Stubs' => resource_path('stubs/joy2362'),
            ], 'service-generator-stub');
            $this->publishes([
                __DIR__ . '/Lang' => $this->app->langPath('joy2362'),
            ], 'service-generator-lang');
        }
    }
}
