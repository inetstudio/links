<?php

namespace InetStudio\Links\Services\Back;

use InetStudio\AdminPanel\Services\Back\BaseService;
use InetStudio\Links\Contracts\Models\LinkModelContract;
use InetStudio\Links\Contracts\Services\Back\LinksServiceContract;
use InetStudio\Links\Contracts\Http\Requests\Back\SaveLinkRequestContract;

/**
 * Class LinksService.
 */
class LinksService extends BaseService implements LinksServiceContract
{
    /**
     * LinksService constructor.
     */
    public function __construct()
    {
        parent::__construct(app()->make('InetStudio\Links\Contracts\Repositories\LinksRepositoryContract'));
    }

    /**
     * Сохраняем модель.
     *
     * @param SaveLinkRequestContract $request
     * @param int $id
     *
     * @return LinkModelContract
     */
    public function save(SaveLinkRequestContract $request, int $id): LinkModelContract
    {
        $item = $this->repository->save($request->only($this->repository->getModel()->getFillable()), $id);

        event(app()->makeWith('InetStudio\Links\Contracts\Events\Back\ModifyLinkEventContract', [
            'object' => $item,
        ]));

        return $item;
    }
}
