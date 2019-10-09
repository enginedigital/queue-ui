<?php

namespace EngineDigital\QueueUi;

use Illuminate\Support\Facades\Facade;

/**
 * @see \EngineDigital\QueueUi\Skeleton\SkeletonClass
 */
class QueueUiFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'queue-ui';
    }
}
