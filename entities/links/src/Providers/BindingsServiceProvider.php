<?php

namespace InetStudio\LinksPackage\Links\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;

/**
 * Class BindingsServiceProvider.
 */
class BindingsServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * @var  array
     */
    public $bindings = [
        'InetStudio\LinksPackage\Links\Contracts\Events\Back\ModifyItemEventContract' => 'InetStudio\LinksPackage\Links\Events\Back\ModifyItemEvent',
        'InetStudio\LinksPackage\Links\Contracts\Http\Controllers\Back\ItemsControllerContract' => 'InetStudio\LinksPackage\Links\Http\Controllers\Back\ItemsController',
        'InetStudio\LinksPackage\Links\Contracts\Http\Controllers\Back\ResourceControllerContract' => 'InetStudio\LinksPackage\Links\Http\Controllers\Back\ResourceController',
        'InetStudio\LinksPackage\Links\Contracts\Http\Requests\Back\SaveItemRequestContract' => 'InetStudio\LinksPackage\Links\Http\Requests\Back\SaveItemRequest',
        'InetStudio\LinksPackage\Links\Contracts\Http\Responses\Back\Resource\DestroyResponseContract' => 'InetStudio\LinksPackage\Links\Http\Responses\Back\Resource\DestroyResponse',
        'InetStudio\LinksPackage\Links\Contracts\Http\Responses\Back\Resource\SaveResponseContract' => 'InetStudio\LinksPackage\Links\Http\Responses\Back\Resource\SaveResponse',
        'InetStudio\LinksPackage\Links\Contracts\Http\Responses\Back\Resource\ShowResponseContract' => 'InetStudio\LinksPackage\Links\Http\Responses\Back\Resource\ShowResponse',
        'InetStudio\LinksPackage\Links\Contracts\Http\Responses\Back\GetItemsByIdsResponseContract' => 'InetStudio\LinksPackage\Links\Http\Responses\Back\GetItemsByIdsResponse',
        'InetStudio\LinksPackage\Links\Contracts\Models\LinkModelContract' => 'InetStudio\LinksPackage\Links\Models\LinkModel',
        'InetStudio\LinksPackage\Links\Contracts\Services\Back\ItemsServiceContract' => 'InetStudio\LinksPackage\Links\Services\Back\ItemsService',
        'InetStudio\LinksPackage\Links\Contracts\Services\Front\ItemsServiceContract' => 'InetStudio\LinksPackage\Links\Services\Front\ItemsService',
    ];

    /**
     * Получить сервисы от провайдера.
     *
     * @return  array
     */
    public function provides()
    {
        return array_keys($this->bindings);
    }
}
