<?php

namespace InetStudio\Links\Http\Responses\Back\Links;

use Illuminate\Support\Str;
use Illuminate\Contracts\Support\Responsable;
use InetStudio\Links\Contracts\Models\LinkModelContract;
use InetStudio\Links\Contracts\Http\Responses\Back\Links\SaveResponseContract;

/**
 * Class SaveResponse.
 */
class SaveResponse implements SaveResponseContract, Responsable
{
    /**
     * @var LinkModelContract
     */
    private $item;

    /**
     * SaveResponse constructor.
     *
     * @param LinkModelContract $item
     */
    public function __construct(LinkModelContract $item)
    {
        $this->item = $item;
    }

    /**
     * Возвращаем ответ при сохранении объекта.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function toResponse($request)
    {
        $this->item = $this->item->fresh();

        return response()->json($this->item, 200);
    }
}
