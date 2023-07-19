<?php

namespace Joy2362\ServiceGenerator;

use Illuminate\Support\ServiceProvider;
use Joy2362\ServiceGenerator\Command\{CSGenerator, ServiceGenerator, TraitGenerator};
use Joy2362\ServiceGenerator\Middleware\CustomRateLimiter;

class ServiceGeneratorServiceProvider extends ServiceProvider
{
    protected string $stubPath = __DIR__ . '/Stubs';
    protected string $lang = __DIR__ . '/Lang';

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

        $this->app['router']->aliasMiddleware('ApiHelperRateLimiter', CustomRateLimiter::class);

        if ($this->app->runningInConsole()) {
            $this->publishes([
                $this->stubPath => resource_path('stubs/joy2362'),
            ], 'service-generator-stub');
            
            $this->publishes([
                $this->lang => $this->app->langPath('joy2362/service-generator'),
            ], 'service-generator-lang');
        }
    }
}
