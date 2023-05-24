<?php

namespace Joy2362\ServiceGenerator\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class BaseCommand extends Command
{

    public function makeDirectory($path): void
    {
        $file = new Filesystem();
        if (!$file->isDirectory($path)) {
            $file->makeDirectory($path, 0777, true, true);
        }
    }

    public function getSourceFilePath($nameSpace, $name): string
    {
        return base_path($nameSpace) . '/' . $name . '.php';
    }

    public function createFile($path, $contents): bool
    {
        $file = new Filesystem();
        if (!$file->exists($path)) {
            $file->put($path, $contents);
            return true;
        }
        return false;
    }


    public function generateStubContents($stub, $stubVariables = [], $separator = '$'): array|bool|string
    {
        $contents = file_get_contents($stub);

        foreach ($stubVariables as $search => $replace) {
            $contents = str_replace($separator . $search . $separator, $replace, $contents);
        }

        return $contents;
    }

}