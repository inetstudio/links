<?php

namespace InetStudio\Links\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use InetStudio\Links\Contracts\Http\Requests\Back\SaveLinkRequestContract;
use InetStudio\Links\Contracts\Http\Controllers\Back\LinksControllerContract;
use InetStudio\Links\Contracts\Http\Responses\Back\Links\SaveResponseContract;
use InetStudio\Links\Contracts\Http\Responses\Back\Links\ShowResponseContract;
use InetStudio\Links\Contracts\Http\Responses\Back\Links\DestroyResponseContract;
use InetStudio\Links\Contracts\Http\Responses\Back\Links\ItemsByIDsResponseContract;

/**
 * Class LinksController.
 */
class LinksController extends Controller implements LinksControllerContract
{
    /**
     * Используемые сервисы.
     *
     * @var array
     */
    protected $services;

    /**
     * LinksController constructor.
     */
    public function __construct()
    {
        $this->services['links'] = app()->make('InetStudio\Links\Contracts\Services\Back\LinksServiceContract');
    }

    /**
     * Получение объекта.
     *
     * @param int $id
     *
     * @return ShowResponseContract
     */
    public function show(int $id = 0): ShowResponseContract
    {
        $item = $this->services['links']->getItemById($id);

        return app()->makeWith(ShowResponseContract::class, [
            'item' => $item,
        ]);
    }

    /**
     * Создание объекта.
     *
     * @param SaveLinkRequestContract $request
     *
     * @return SaveResponseContract
     */
    public function store(SaveLinkRequestContract $request): SaveResponseContract
    {
        return $this->save($request);
    }

    /**
     * Обновление объекта.
     *
     * @param SaveLinkRequestContract $request
     * @param int $id
     *
     * @return SaveResponseContract
     */
    public function update(SaveLinkRequestContract $request, int $id = 0): SaveResponseContract
    {
        return $this->save($request, $id);
    }

    /**
     * Сохранение объекта.
     *
     * @param SaveLinkRequestContract $request
     * @param int $id
     *
     * @return SaveResponseContract
     */
    private function save(SaveLinkRequestContract $request, int $id = 0): SaveResponseContract
    {
        $item = $this->services['links']->save($request, $id);

        return app()->makeWith(SaveResponseContract::class, [
            'item' => $item,
        ]);
    }

    /**
     * Удаление объекта.
     *
     * @param int $id
     *
     * @return DestroyResponseContract
     */
    public function destroy(int $id = 0): DestroyResponseContract
    {
        $result = $this->services['links']->destroy($id);

        return app()->makeWith(DestroyResponseContract::class, [
            'result' => ($result === null) ? false : $result,
        ]);
    }

    /**
     * Возвращаем объекты по id.
     *
     * @param Request $request
     *
     * @return ItemsByIDsResponseContract
     */
    public function getItemsByIDs(Request $request): ItemsByIDsResponseContract
    {
        $ids = $request->get('ids') ?? [];

        $items = $this->services['links']->getItemsByIDs($ids);

        return app()->makeWith(ItemsByIDsResponseContract::class, [
            'items' => $items,
        ]);
    }
}
