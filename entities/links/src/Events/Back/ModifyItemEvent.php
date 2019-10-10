<?php

namespace InetStudio\LinksPackage\Links\Events\Back;

use Illuminate\Queue\SerializesModels;
use InetStudio\LinksPackage\Links\Contracts\Models\LinkModelContract;
use InetStudio\LinksPackage\Links\Contracts\Events\Back\ModifyItemEventContract;

/**
 * Class ModifyItemEvent.
 */
class ModifyItemEvent implements ModifyItemEventContract
{
    use SerializesModels;

    /**
     * @var LinkModelContract
     */
    public $item;

    /**
     * ModifyItemEvent constructor.
     *
     * @param  LinkModelContract  $item
     */
    public function __construct(LinkModelContract $item)
    {
        $this->item = $item;
    }
}
