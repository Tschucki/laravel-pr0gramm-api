# Laravel Pr0gramm API

[![Latest Version on Packagist](https://img.shields.io/packagist/v/tschucki/laravel-pr0gramm-api.svg?style=flat-square)](https://packagist.org/packages/tschucki/laravel-pr0gramm-api)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/tschucki/laravel-pr0gramm-api/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/tschucki/laravel-pr0gramm-api/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/tschucki/laravel-pr0gramm-api/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/tschucki/laravel-pr0gramm-api/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/tschucki/laravel-pr0gramm-api.svg?style=flat-square)](https://packagist.org/packages/tschucki/laravel-pr0gramm-api)

This package provides a Laravel wrapper for the [Pr0gramm API](https://github.com/pr0gramm-com/api-docs) by [Pr0gramm](https://pr0gramm.com).
This package is not affiliated with Pr0gramm. I created it for my own use on other projects.

I will try to keep this package up to date with the API and imporve it over time. If you find any bugs or have any suggestions, feel free to open an issue or a PR.

## Installation

You can install the package via composer:

```bash
composer require tschucki/laravel-pr0gramm-api
```

You don't need to publish any config files. The package will work out of the box. 
You just have to log in to Pr0gramm, to get some user related request. (For example conversations or votings)

But if you want to provide your pr0gramm cookie, you can add this to your `services.php`.

```php
    'pr0gramm' => [
        'cookie' => env('PR0GRAMM_COOKIE'),
    ]
```

## Usage

It is recommended to use the facade `Pr0grammApi` to access the API.

```php
Pr0grammApi::User()->me();
```

You can access all endpoints of the API:
- User
- Post
- Tag
- Comment
- Contact
- Inbox
- Profile

## Login to your account

To log in to your account, you can use the `login` method.
It will create a new Session and stores the cookie for you.
Afterwards you don't need to provide the cookie on every request.
When using a non-bot account, you have to provide a captcha and token parameter (You can get the captcha and token via `Pr0grammApi::Captcha`).

You can ignore this, when you already provided the cookie in your `services.php`. You can copy your Cookie from the Dev-Tools, while logged in for example.

```php
Pr0grammApi::login('Gamb', 'Quatschtütenwürger25')
```

## Logout of your account

Logging out will delete the session and the cookie.
You have to log in again, to access user related endpoints. Otherwise, you will get an Exception.

```php
Pr0grammApi::logout()
```

### Examples

#### Retrieving the current user

```php
$currentUser = Pr0grammApi::User()->me();
```

#### Retrieving info about a user

```php
$userInfo = Pr0grammApi::User()->info('Gamb');
```

#### Voting a post

```php
use Tschucki\Pr0grammApi\Enums\Vote;

Pr0grammApi::Post()->vote(1, Vote::UP);
```

#### Add a comment

```php
// Add comment to post with id 1
Pr0grammApi::Comment()->add(1, 'Das Ablecken von Türknöpfen ist auf anderen Planeten illegal.');

// Add comment to another comment
Pr0grammApi::Comment()->add(1, 'Ich bin ne gute Nudel', 22);
```

#### Get Comments from Inbox

```php
Pr0grammApi::Inbox()->comments();
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Feel free to open a PR or an issue. I will try to respond as soon as possible.

## Credits

- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
