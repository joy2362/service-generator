<?php

namespace Joy2362\ServiceGenerator\Contracts;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

interface ApiServiceContract
{
    /**
     * @param Request $request
     * @return Collection
     */
    public function index(Request $request): Collection;

    /**
     * @param Request $request
     * @return Collection
     */
    public function store(Request $request): Collection;

    /**
     * @param $id
     * @return Collection
     */
    public function show($id): Collection;

    /**
     * @param Request $request
     * @param $id
     * @return Collection
     */
    public function update(Request $request, $id): Collection;

    /**
     * @param $id
     * @return Collection
     */
    public function destroy($id): Collection;
}