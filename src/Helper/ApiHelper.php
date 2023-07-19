<?php

namespace Joy2362\ServiceGenerator\Helper;


use Illuminate\{Http\JsonResponse, Support\Collection};
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;


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

    public static function upload($file, $path, $old = null)
    {
        $code = date('ymdhis') . '-' . rand(1111, 9999);
        if (!empty($old)) {
            $oldFile = self::oldFile($old);
            if (Storage::disk('public')->exists($oldFile)) {
                Storage::disk('public')->delete($oldFile);
            }
        }
        //FILE UPLOAD
        if (!empty($file)) {
            $fileName = $code . "." . $file->getClientOriginalExtension();
            self::makeDir($path);
            return Storage::disk('public')->putFileAs('upload/' . $path, $file, $fileName);
        }
    }

    public static function makeDir($folder): void
    {
        $main_dir = storage_path("app/public/upload/{$folder}");
        if (!file_exists($main_dir)) {
            mkdir($main_dir, 0777, true);
        }
    }

    public static function oldFile($file): string
    {
        $ex = explode('storage/', $file);
        return $ex[0] ?? "";
    }

    public static function deleteFile($file): void
    {
        if (Storage::disk('public')->exists($file)):
            Storage::delete($file);
        endif;
    }

    public static function getModelList($path = null)
    {
        $cPath = $path ?? app_path('Models'); 
        $models = [];
        $results = scandir($cPath);
        
        foreach($results as $result){
            if ($result === '.' or $result === '..') continue;
            if(!str_ends_with( $result , '.php' )){
                $nastedPath = "{$cPath}/{$result}";
                if(is_dir($nastedPath)){
                    $models = array_merge($models , self::getModelList($nastedPath));
                }
            }else{
                $models[] = substr( $result , 0,-4);
            }
        }
        return $models;
    }

}
