<?php

namespace InetStudio\Links\Http\Responses\Back\Links;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Support\Responsable;
use InetStudio\Links\Contracts\Http\Responses\Back\Links\ItemsByIDsResponseContract;

/**
 * Class ItemsByIDsResponse.
 */
class ItemsByIDsResponse implements ItemsByIDsResponseContract, Responsable
{
    /**
     * @var Collection
     */
    private $items;

    /**
     * ItemsByIDsResponse constructor.
     *
     * @param Collection $items
     */
    public function __construct(Collection $items)
    {
        $this->items = $items;
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
        $items = $this->items->map(function ($item) {
            return [
                'model' => $item,
            ];
        });

        return response()->json($items);
    }
}
