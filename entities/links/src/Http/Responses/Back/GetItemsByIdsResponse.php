<?php

namespace InetStudio\LinksPackage\Links\Http\Responses\Back;

use Illuminate\Http\Request;
use InetStudio\LinksPackage\Links\Contracts\Services\Back\ItemsServiceContract;
use InetStudio\LinksPackage\Links\Contracts\Http\Responses\Back\GetItemsByIdsResponseContract;

/**
 * Class GetItemsByIdsResponse.
 */
class GetItemsByIdsResponse implements GetItemsByIdsResponseContract
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
        $ids = $request->get('ids');

        $items = $this->resourceService->getItemById($ids);

        $items = $items->map(function ($item) {
            return [
                'model' => $item,
            ];
        });

        return response()->json($items);
    }
}
