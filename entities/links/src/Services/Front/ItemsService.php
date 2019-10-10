<?php

namespace InetStudio\LinksPackage\Links\Services\Front;

use InetStudio\AdminPanel\Base\Services\BaseService;
use InetStudio\LinksPackage\Links\Contracts\Models\LinkModelContract;
use InetStudio\LinksPackage\Links\Contracts\Services\Front\ItemsServiceContract;

/**
 * Class ItemsService.
 */
class ItemsService extends BaseService implements ItemsServiceContract
{
    /**
     * ItemsService constructor.
     *
     * @param  LinkModelContract  $model
     */
    public function __construct(LinkModelContract $model)
    {
        parent::__construct($model);
    }
}
