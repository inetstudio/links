<?php

namespace InetStudio\LinksPackage\Links\Http\Controllers\Back;

use Illuminate\Http\Request;
use InetStudio\AdminPanel\Base\Http\Controllers\Controller;
use InetStudio\LinksPackage\Links\Contracts\Http\Requests\Back\SaveItemRequestContract;
use InetStudio\LinksPackage\Links\Contracts\Http\Controllers\Back\ResourceControllerContract;
use InetStudio\LinksPackage\Links\Contracts\Http\Responses\Back\Resource\SaveResponseContract;
use InetStudio\LinksPackage\Links\Contracts\Http\Responses\Back\Resource\ShowResponseContract;
use InetStudio\LinksPackage\Links\Contracts\Http\Responses\Back\Resource\DestroyResponseContract;

/**
 * Class ResourceController.
 */
class ResourceController extends Controller implements ResourceControllerContract
{
    /**
     * Создание объекта.
     *
     * @param  SaveItemRequestContract  $request
     * @param  SaveResponseContract  $response
     *
     * @return SaveResponseContract
     */
    public function store(SaveItemRequestContract $request, SaveResponseContract $response): SaveResponseContract
    {
        return $response;
    }

    /**
     * Получение объекта.
     *
     * @param  Request  $request
     * @param  ShowResponseContract  $response
     *
     * @return ShowResponseContract
     */
    public function show(Request $request, ShowResponseContract $response): ShowResponseContract
    {
        return $response;
    }

    /**
     * Обновление объекта.
     *
     * @param  SaveItemRequestContract  $request
     * @param  SaveResponseContract  $response
     *
     * @return SaveResponseContract
     */
    public function update(SaveItemRequestContract $request, SaveResponseContract $response): SaveResponseContract
    {
        return $response;
    }

    /**
     * Удаление объекта.
     *
     * @param  Request  $request
     * @param  DestroyResponseContract  $response
     *
     * @return DestroyResponseContract
     */
    public function destroy(Request $request, DestroyResponseContract $response): DestroyResponseContract
    {
        return $response;
    }
}
