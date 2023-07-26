<?php

namespace Joy2362\ServiceGenerator\Command;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Joy2362\ServiceGenerator\Helper\ApiHelper;
use Symfony\Component\Console\Command\Command as CommandAlias;

class TraitGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:trait {name : The trait name} ';


    protected $description = 'Create a new trait';

    public string $nameSpace = 'App\\Trait';
    public string $filePath = 'app/Trait';


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $path = ApiHelper::getSourceFilePath($this->filePath, $this->argument('name'));
        ApiHelper::makeDirectory(dirname($path));
        $contents = ApiHelper::generateStubContents($this->getStubPath(), $this->getStubVariables(), "$");

        ApiHelper::createFile($path, $contents) ?
            $this->info("Trait successfully created ") :
            $this->info("Trait : {$path} already exits");

        return CommandAlias::SUCCESS;
    }


    public function getStubPath(): string
    {
        $file = new Filesystem();

        $path = base_path('resources/stubs/joy2362/trait.stub');
        $realPath = __DIR__ . '/../Stubs/Trait.stub';

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
        ];
    }
}
