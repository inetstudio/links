<?php

namespace InetStudio\LinksPackage\Links\Http\Controllers\Back;

use Illuminate\Http\Request;
use InetStudio\AdminPanel\Base\Http\Controllers\Controller;
use InetStudio\LinksPackage\Links\Contracts\Http\Controllers\Back\ItemsControllerContract;
use InetStudio\LinksPackage\Links\Contracts\Http\Responses\Back\GetItemsByIdsResponseContract;

/**
 * Class ItemsController.
 */
class ItemsController extends Controller implements ItemsControllerContract
{
    /**
     * Получение объектов.
     *
     * @param  Request  $request
     * @param  GetItemsByIdsResponseContract  $response
     *
     * @return GetItemsByIdsResponseContract
     */
    public function getItemsByIds(Request $request, GetItemsByIdsResponseContract $response): GetItemsByIdsResponseContract
    {
        return $response;
    }
}
