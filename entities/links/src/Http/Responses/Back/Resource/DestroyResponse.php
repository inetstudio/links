<?php

namespace InetStudio\LinksPackage\Links\Http\Responses\Back\Resource;

use Illuminate\Http\Request;
use InetStudio\LinksPackage\Links\Contracts\Services\Back\ItemsServiceContract;
use InetStudio\LinksPackage\Links\Contracts\Http\Responses\Back\Resource\DestroyResponseContract;

/**
 * Class DestroyResponse.
 */
class DestroyResponse implements DestroyResponseContract
{
    /**
     * @var ItemsServiceContract
     */
    protected $resourceService;

    /**
     * FormResponse constructor.
     *
     * @param  ItemsServiceContract  $resourceService
     */
    public function __construct(ItemsServiceContract $resourceService)
    {
        $this->resourceService = $resourceService;
    }

    /**
     * Возвращаем ответ при удалении объекта.
     *
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        $id = $request->route('id');

        $result = $this->resourceService->destroy($id);

        return response()->json([
            'success' => $result,
        ]);
    }
}
