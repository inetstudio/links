<?php

namespace InetStudio\Links\Services\Front;

use InetStudio\AdminPanel\Services\Front\BaseService;
use InetStudio\Links\Contracts\Services\Front\LinksServiceContract;

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
}
