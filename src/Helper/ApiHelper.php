<?php

namespace Joy2362\ServiceGenerator\Helper;


use Illuminate\{Http\JsonResponse, Support\Collection};
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Filesystem\Filesystem;

class ApiHelper
{

    /**
     * @param $response
     * @return JsonResponse
     */
    public static function response($response): JsonResponse
    {
        return response()->json($response->except(['status']), $response['status']);
    }

    /**
     * @param array $items
     * @param int|null $status
     * @return Collection
     */
    public static function success(array $items = [], int $status = null): Collection
    {
        $res = [
            'success' => true,
            'status' => $status ?? Response::HTTP_OK,
        ];

        foreach ($items as $key => $item) {
            $res[$key] = $item;
        }

        return new Collection($res);
    }

    /**
     * @param array $items
     * @param int|null $status
     * @return Collection
     */
    public static function failed(array $items = [], int $status = null): Collection
    {
        $res = [
            'success' => false,
            'status' => $status ?? Response::HTTP_UNPROCESSABLE_ENTITY,
        ];

        foreach ($items as $key => $item) {
            $res[$key] = $item;
        }

        return new Collection($res);
    }

    public static function makeDirectory($path): void
    {
        $file = new Filesystem();
        if (!$file->isDirectory($path)) {
            $file->makeDirectory($path, 0777, true, true);
        }
    }

    public static function getSourceFilePath($nameSpace, $name): string
    {
        return base_path($nameSpace) . '/' . $name . '.php';
    }

    public static function createFile($path, $contents): bool
    {
        $file = new Filesystem();
        if (!$file->exists($path)) {
            $file->put($path, $contents);
            return true;
        }
        return false;
    }

    public static function generateStubContents($stub, $stubVariables = [], $separator = '$'): array|bool|string
    {
        $contents = file_get_contents($stub);

        foreach ($stubVariables as $search => $replace) {
            $contents = str_replace($separator . $search . $separator, $replace, $contents);
        }

        return $contents;
    }

}
