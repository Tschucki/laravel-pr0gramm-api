<?php

namespace Tschucki\Pr0grammApi\Facades;

use Illuminate\Support\Facades\Facade;
use Tschucki\Pr0grammApi\Resources\User;

/**
 * @see \Tschucki\Pr0grammApi\Pr0grammApi
 */
class Pr0grammApi extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Tschucki\Pr0grammApi\Pr0grammApi::class;
    }

    public static function login($username, $password)
    {
        return static::getFacadeRoot()->login($username, $password);
    }

    public static function loggedIn()
    {
        return static::getFacadeRoot()->loggedIn();
    }

    public static function User(): User
    {
        return static::getFacadeRoot()->user();
    }
}
