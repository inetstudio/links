<?php

namespace InetStudio\Links\Http\Responses\Back\Links;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Support\Responsable;
use InetStudio\Links\Contracts\Models\LinkModelContract;
use InetStudio\Links\Contracts\Http\Responses\Back\Links\ShowResponseContract;

/**
 * Class ShowResponse.
 */
class ShowResponse implements ShowResponseContract, Responsable
{
    /**
     * @var LinkModelContract
     */
    private $item;

    /**
     * ShowResponse constructor.
     *
     * @param LinkModelContract $item
     */
    public function __construct(LinkModelContract $item)
    {
        $this->item = $item;
    }

    /**
     * Возвращаем ответ при получении объекта.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return JsonResponse
     */
    public function toResponse($request): JsonResponse
    {
        return response()->json($this->item);
    }
}
