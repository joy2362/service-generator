<?php

namespace Joy2362\ServiceGenerator\Command;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Joy2362\ServiceGenerator\Helper\ApiHelper;
use Symfony\Component\Console\Command\Command as CommandAlias;

class CSGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:c-s {name}  {--api}';
    public string $nameSpace = 'App\\Services';
    public bool $isCrud = false;
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
        $models = ApiHelper::getModelList();
        if(array_search(ucfirst($this->argument('name')),$models)){
            $this->isCrud = true;
        }
        
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
        $path = ApiHelper::getSourceFilePath($this->ControllerFilePath, $this->argument('name') . "Controller");
        ApiHelper::makeDirectory(dirname($path));
        $contents = ApiHelper::generateStubContents(
            $this->getControllerStubPath(),
            $this->getControllerStubVariables()
        );
        return ApiHelper::createFile($path, $contents);
    }

    public function createService(): bool
    {
        $path = ApiHelper::getSourceFilePath($this->filePath, $this->argument('name') . "Service");
        ApiHelper::makeDirectory(dirname($path));
        $contents = ApiHelper::generateStubContents($this->getServiceStubPath(), $this->getServiceStubVariables());
        return ApiHelper::createFile($path, $contents);
    }

    public function getControllerStubPath(): string
    {
        $file = new Filesystem();

        $path = base_path('resources/stubs/joy2362/controller.stub');
        $realPath = __DIR__ . '/../Stubs/Controller.stub';
        if ($this->option('api')) {
            $path = base_path('resources/stubs/joy2362/controller.api.stub');
            $realPath = __DIR__ . '/../Stubs/Controller.api.stub';
        }
        return $file->exists($path) ? $path : $realPath;
    }


    public function getServiceStubPath(): string
    {
        
        $file = new Filesystem();

        $path = base_path('resources/stubs/joy2362/service.stub');
        $realPath = __DIR__ . '/../Stubs/Service.stub';
        if ($this->option('api')) {
            if($this->isCrud){
                $path = base_path('resources/stubs/joy2362/service.crud.stub');
                $realPath = __DIR__ . '/../Stubs/Service.crud.stub';
            }else{
                $path = base_path('resources/stubs/joy2362/service.api.stub');
                $realPath = __DIR__ . '/../Stubs/Service.api.stub';
            }
        }
       
        return $file->exists($path) ? $path : $realPath;
    }

    public function getServiceStubVariables(): array
    {
        $variable =  [
            'NAMESPACE' => $this->nameSpace,
            'CLASS' => $this->argument('name') . "Service",
            'RESOURCE' => $this->option('api') || $this->isCrud  ? ucfirst($this->argument('name')) : "",
        ];

        if($this->isCrud){
            $variable['RESOURCE_NAMESPACE'] = ucfirst($this->argument('name'));
            $variable['RESOURCE_NAME'] = lcfirst($this->argument('name'));  
        }
        
        return $variable;
    }

    public function getControllerStubVariables(): array
    {
        return [
            'NAMESPACE' => $this->ControllerNameSpace,
            'CLASS' => $this->argument('name') . "Controller",
            'SERVICE' => $this->argument('name') . "Service",
            'SERVICE-NAMESPACE' => $this->nameSpace . "\\" . $this->argument('name') . "Service",
            'REQUEST-NAMESPACE' => $this->option('api') ? 'use ' . $this->RequestNameSpace . "\\" . $this->argument(
                    'name'
                ) . "Request" : '',
            'REQUEST' => $this->option('api') ?  $this->argument(
                    'name'
                ) . "Request" : 'Request',

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
        $file = new Filesystem();
        $path = base_path('resources/stubs/joy2362/request.stub');
        $realPath = __DIR__ . '/../Stubs/Request.stub';
        return $file->exists($path) ? $path : $realPath;
    }

    public function createRequest(): bool
    {
        $path = ApiHelper::getSourceFilePath($this->RequestFilePath, $this->argument('name') . "Request");
        ApiHelper::makeDirectory(dirname($path));
        $contents = ApiHelper::generateStubContents($this->getRequestStubPath(), $this->getRequestStubVariables());
        return ApiHelper::createFile($path, $contents);
    }
}
