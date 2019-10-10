<?php

namespace InetStudio\LinksPackage\Links\Http\Responses\Back\Resource;

use Illuminate\Http\Request;
use InetStudio\LinksPackage\Links\Contracts\Services\Back\ItemsServiceContract;
use InetStudio\LinksPackage\Links\Contracts\Http\Responses\Back\Resource\ShowResponseContract;

/**
 * Class ShowResponse.
 */
class ShowResponse implements ShowResponseContract
{
    /**
     * @var ItemsServiceContract
     */
    protected $resourceService;

    /**
     * ShowResponse constructor.
     *
     * @param  ItemsServiceContract  $resourceService
     */
    public function __construct(ItemsServiceContract $resourceService)
    {
        $this->resourceService = $resourceService;
    }

    /**
     * Возвращаем ответ при получении объекта.
     *
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        $id = $request->route('link');

        $item = $this->resourceService->getItemById($id);

        return response()->json($item);
    }
}
