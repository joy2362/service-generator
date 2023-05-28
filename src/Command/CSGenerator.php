<?php

namespace Joy2362\ServiceGenerator\Command;

use Illuminate\Console\Command;
use Joy2362\ServiceGenerator\Helper\ApiHelper;
use Symfony\Component\Console\Command\Command as CommandAlias;

class CSGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:c-s {name: The service controller name}  {--api}';
    public string $nameSpace = 'App\\Services';
    public string $filePath = 'app/Services';

    public string $ControllerNameSpace = 'App\Http\Controllers';
    public string $ControllerFilePath = 'app/Http/Controllers';

    public string $RequestNameSpace = 'App\Http\Requests';
    public string $RequestFilePath = 'app/Http/Requests';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new controller service';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->createService() ?
            $this->createController() ?
                $this->option('api') ?
                    $this->createRequest() ?
                        $this->info(
                            "C-S created successfully"
                        ) : $this->info(
                        "C-S failed to create"
                    ) : $this->info(
                    "C-S successfully created "
                ) : $this->info(
                "C-S failed to create"
            ) : $this->info("C-S failed to create");
        return CommandAlias::SUCCESS;
    }

    public function createController(): bool
    {
        $path =  ApiHelper::getSourceFilePath($this->ControllerFilePath, $this->argument('name') . "Controller");
        ApiHelper::makeDirectory(dirname($path));
        $contents =  ApiHelper::generateStubContents($this->getControllerStubPath(), $this->getControllerStubVariables());
        return  ApiHelper::createFile($path, $contents);
    }

    public function createService(): bool
    {
        $path = ApiHelper:: getSourceFilePath($this->filePath, $this->argument('name') . "Service");
        ApiHelper::makeDirectory(dirname($path));
        $contents =  ApiHelper::generateStubContents($this->getServiceStubPath(), $this->getServiceStubVariables());
        return  ApiHelper::createFile($path, $contents);
    }

    public function getControllerStubPath(): string
    {
        if ($this->option('api')) {
            return base_path('stubs') . '/Controller.api.stub';
        }
        return base_path('stubs') . '/Controller.stub';
    }


    public function getServiceStubPath(): string
    {
        if ($this->option('api')) {
            return base_path('stubs') . '/Service.api.stub';
        }
        return base_path('stubs') . '/Service.stub';
    }

    public function getServiceStubVariables(): array
    {
        return [
            'NAMESPACE' => $this->nameSpace,
            'CLASS_NAME' => $this->argument('name') . "Service",
            'RESOURCE' => $this->option('api') ? ucfirst($this->argument('name')) : "",
        ];
    }

    public function getControllerStubVariables(): array
    {
        return [
            'NAMESPACE' => $this->ControllerNameSpace,
            'CLASS' => $this->argument('name') . "Controller",
            'SERVICE' => $this->argument('name') . "Service",
            'SERVICE-NAMESPACE' => $this->nameSpace . "\\" . $this->argument('name') . "Service",
            'REQUEST-NAMESPACE' => $this->option('api') ? $this->nameSpace . "\\" . $this->argument(
                    'name'
                ) . "Request" : '',
        ];
    }

    public function getRequestStubVariables(): array
    {
        $nameSpace = $this->RequestNameSpace;
        return [
            'NAMESPACE' => $nameSpace,
            'CLASS' => $this->argument('name') . "Request",
        ];
    }

    public function getRequestStubPath(): string
    {
        return base_path('stubs') . '/Request.stub';
    }

    public function createRequest(): bool
    {
        $path =  ApiHelper::getSourceFilePath($this->RequestFilePath, $this->argument('name') . "Request");
        ApiHelper::makeDirectory(dirname($path));
        $contents =  ApiHelper::generateStubContents($this->getRequestStubPath(), $this->getRequestStubVariables());
        return  ApiHelper::createFile($path, $contents);
    }
}
