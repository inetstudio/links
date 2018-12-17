<?php

namespace InetStudio\Links\Repositories;

use InetStudio\AdminPanel\Repositories\BaseRepository;
use InetStudio\Links\Contracts\Models\LinkModelContract;
use InetStudio\Links\Contracts\Repositories\LinksRepositoryContract;

/**
 * Class LinksRepository.
 */
class LinksRepository extends BaseRepository implements LinksRepositoryContract
{
    /**
     * LinksRepository constructor.
     *
     * @param LinkModelContract $model
     */
    public function __construct(LinkModelContract $model)
    {
        $this->model = $model;

        $this->defaultColumns = [
            'id', 'type', 'linkable_type', 'linkable_id', 'additional_info', 'created_at', 'updated_at', 'deleted_at',
        ];
    }
}
