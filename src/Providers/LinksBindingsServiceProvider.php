<?php

namespace InetStudio\Links\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;

/**
 * Class LinksBindingsServiceProvider.
 */
class LinksBindingsServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
    * @var  array
    */
    public $bindings = [
        'InetStudio\Links\Contracts\Events\Back\ModifyLinkEventContract' => 'InetStudio\Links\Events\Back\ModifyLinkEvent',
        'InetStudio\Links\Contracts\Http\Controllers\Back\LinksControllerContract' => 'InetStudio\Links\Http\Controllers\Back\LinksController',
        'InetStudio\Links\Contracts\Http\Requests\Back\SaveLinkRequestContract' => 'InetStudio\Links\Http\Requests\Back\SaveLinkRequest',
        'InetStudio\Links\Contracts\Http\Responses\Back\Links\DestroyResponseContract' => 'InetStudio\Links\Http\Responses\Back\Links\DestroyResponse',
        'InetStudio\Links\Contracts\Http\Responses\Back\Links\ItemsByIDsResponseContract' => 'InetStudio\Links\Http\Responses\Back\Links\ItemsByIDsResponse',
        'InetStudio\Links\Contracts\Http\Responses\Back\Links\SaveResponseContract' => 'InetStudio\Links\Http\Responses\Back\Links\SaveResponse',
        'InetStudio\Links\Contracts\Http\Responses\Back\Links\ShowResponseContract' => 'InetStudio\Links\Http\Responses\Back\Links\ShowResponse',
        'InetStudio\Links\Contracts\Models\LinkModelContract' => 'InetStudio\Links\Models\LinkModel',
        'InetStudio\Links\Contracts\Repositories\LinksRepositoryContract' => 'InetStudio\Links\Repositories\LinksRepository',
        'InetStudio\Links\Contracts\Services\Back\LinksServiceContract' => 'InetStudio\Links\Services\Back\LinksService',
        'InetStudio\Links\Contracts\Services\Front\LinksServiceContract' => 'InetStudio\Links\Services\Front\LinksService',
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
