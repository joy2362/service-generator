<?php

namespace Joy2362\ServiceGenerator\Command;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Console\Command;
use Joy2362\ServiceGenerator\Helper\ApiHelper;
use Symfony\Component\Console\Command\Command as CommandAlias;

class ServiceGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name : The service name}  {--api}';
    public string $nameSpace = 'App\\Services';
    public string $filePath = 'app/Services';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $path = ApiHelper::getSourceFilePath($this->filePath, $this->argument('name'));
        ApiHelper::makeDirectory(dirname($path));
        $contents = ApiHelper::generateStubContents($this->getStubPath(), $this->getStubVariables());
        ApiHelper::createFile($path, $contents) ?
            $this->info("Service successfully created ") :
            $this->info("Service : {$path} already exits");
        return CommandAlias::SUCCESS;
    }


    public function getStubPath(): string
    {
        $file = new Filesystem();

        $path = base_path('resources/stubs/joy2362/service.stub');
        $realPath = __DIR__ . '/../Stubs/Service.stub';
        if ($this->option('api')) {
            $path = base_path('resources/stubs/joy2362/service.api.stub');
            $realPath = __DIR__ . '/../Stubs/Service.api.stub';
        }
        if ($file->exists($path)) {
            return $path;
        } else {
            return $realPath;
        }
    }

    public function getStubVariables(): array
    {
        $nameSpace = $this->nameSpace;
        $names = explode('/', $this->argument('name'));
        $className = end($names);
        array_pop($names);

        if (!empty($names)) {
            foreach ($names as $name) {
                $nameSpace .= "\\{$name}";
            }
        }
        return [
            'NAMESPACE' => $nameSpace,
            'CLASS' => $className,
            'RESOURCE' => $this->option('api') ? ucfirst(str_replace('Service', '', $className)) : "",
        ];
    }
}
