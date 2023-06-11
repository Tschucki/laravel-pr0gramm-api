<?php

namespace Tschucki\Pr0grammApi\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Tschucki\Pr0grammApi\Pr0grammApi
 */
class Pr0grammApi extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Tschucki\Pr0grammApi\Pr0grammApi::class;
    }
}
