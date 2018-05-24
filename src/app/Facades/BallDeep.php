<?php

namespace Lainga9\BallDeep\app\Facades;

// use Lainga9\BallDeep\app\BallDeep;
use Illuminate\Support\Facades\Facade;

class BallDeep extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'BallDeep';
    }
}
