<?php

namespace Joy2362\ServiceGenerator\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Joy2362\ServiceGenerator\ServiceGeneratorServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            ServiceGeneratorServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        /*
        $migration = include __DIR__.'/../database/migrations/create_skeleton_table.php.stub';
        $migration->up();
        */
    }
}