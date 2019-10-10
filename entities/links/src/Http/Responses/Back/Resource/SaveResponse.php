<?php

namespace InetStudio\LinksPackage\Links\Http\Responses\Back\Resource;

use Illuminate\Http\Request;
use InetStudio\LinksPackage\Links\Contracts\Services\Back\ItemsServiceContract;
use InetStudio\LinksPackage\Links\Contracts\Http\Responses\Back\Resource\SaveResponseContract;

/**
 * Class SaveResponse.
 */
class SaveResponse implements SaveResponseContract
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
     * Возвращаем ответ при сохранении объекта.
     *
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        $id = $request->route('id', 0);
        $data = $request->all();

        $item = $this->resourceService->save($data, $id);

        return response()->json($item, 200);
    }
}
