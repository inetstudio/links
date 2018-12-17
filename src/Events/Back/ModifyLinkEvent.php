<?php

namespace InetStudio\Links\Events\Back;

use Illuminate\Queue\SerializesModels;
use InetStudio\Links\Contracts\Events\Back\ModifyLinkEventContract;

/**
 * Class ModifyLinkEvent.
 */
class ModifyLinkEvent implements ModifyLinkEventContract
{
    use SerializesModels;

    public $object;

    /**
     * ModifyLinkEvent constructor.
     *
     * @param $object
     */
    public function __construct($object)
    {
        $this->object = $object;
    }
}
