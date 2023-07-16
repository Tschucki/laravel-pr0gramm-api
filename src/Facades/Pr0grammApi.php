<?php

namespace Tschucki\Pr0grammApi\Facades;

use Illuminate\Support\Facades\Facade;
use Tschucki\Pr0grammApi\Collections\Captcha;
use Tschucki\Pr0grammApi\Resources\Comment;
use Tschucki\Pr0grammApi\Resources\Inbox;
use Tschucki\Pr0grammApi\Resources\Post;
use Tschucki\Pr0grammApi\Resources\Profile;
use Tschucki\Pr0grammApi\Resources\Tag;
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

    public static function login(string $username, string $password, string $captcha = null, string $token = null): mixed
    {
        return static::getFacadeRoot()->login($username, $password, $captcha, $token);
    }

    public static function Captcha(): Captcha
    {
        return static::getFacadeRoot()->captcha();
    }

    public static function loggedIn(): mixed
    {
        return static::getFacadeRoot()->loggedIn();
    }

    public static function logout(): mixed
    {
        return static::getFacadeRoot()->logout();
    }

    public static function User(): User
    {
        return static::getFacadeRoot()->user();
    }

    public static function Post(): Post
    {
        return static::getFacadeRoot()->post();
    }

    public static function Comment(): Comment
    {
        return static::getFacadeRoot()->comment();
    }

    public static function Profile(): Profile
    {
        return static::getFacadeRoot()->profile();
    }

    public static function Tag(): Tag
    {
        return static::getFacadeRoot()->tag();
    }

    public static function Inbox(): Inbox
    {
        return static::getFacadeRoot()->inbox();
    }
}
