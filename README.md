# Dev.to for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/ronildo-sousa/devto-for-laravel.svg?style=flat-square)](https://packagist.org/packages/ronildo-sousa/devto-for-laravel)
[![Total Downloads](https://img.shields.io/packagist/dt/ronildo-sousa/devto-for-laravel.svg?style=flat-square)](https://packagist.org/packages/ronildo-sousa/devto-for-laravel)
<!-- [![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/ronildo-sousa/devto-for-laravel/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/ronildo-sousa/devto-for-laravel/actions?query=workflow%3Arun-tests+branch%3Amain) -->
<!-- [![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/ronildo-sousa/devto-for-laravel/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/ronildo-sousa/devto-for-laravel/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain) -->

A service wrapper around the Dev.to API
## 🛠️ In progress

## Installation

You can install the package via composer:

```bash
composer require ronildo-sousa/devto-for-laravel
```

<!-- You can publish the config file with:

```bash
php artisan vendor:publish --tag="devto-for-laravel-config"
```

This is the contents of the published config file:

```php
return [
];
``` -->
## Usage

See the [documentation](https://developers.forem.com/api/v1) for details

## Published articles

This allows the client to retrieve a list of articles.

```php
 DevtoForLaravel::articles()
    ->get();
```

you have some options like:

### Pagination

```php
 DevtoForLaravel::articles()
    ->perPage(5)
    ->get();
```

### Filters

```php
 DevtoForLaravel::articles()
    ->withTags(['tag1', 'tag2'])
    ->withoutTags(['tag3', 'tag4'])
    ->get();
```

```php
 DevtoForLaravel::articles()
    ->from('username')
    ->get();
```
### Sort articles

This allows to retrieve a list of articles. ordered by descending publish date.

```php
 DevtoForLaravel::articles()
    ->latest()
    ->get();
```
### Find by ID

you can get an article by id:

```php
 DevtoForLaravel::articles()
    ->find(258)
```

## Testing

```bash
composer test
```
## Credits

- [Ronildo Sousa](https://github.com/Ronildo-Sousa)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
