<?php

namespace Joy2362\ServiceGenerator\Helper;


use Illuminate\{Http\JsonResponse, Support\Collection};
use Symfony\Component\HttpFoundation\Response;

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
    function failed(array $items = [], int $status = null): Collection
    {
        $res = [
            'success' => true,
            'status' => $status ?? Response::HTTP_UNPROCESSABLE_ENTITY,
        ];

        foreach ($items as $key => $item) {
            $res[$key] = $item;
        }

        return new Collection($res);
    }

}