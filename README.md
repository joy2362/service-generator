# service-generator

A set of tools to make working with service easier in Laravel

[![Latest Version](https://img.shields.io/github/release/joy2362/service-generator.svg?style=flat-square)](https://github.com/joy2362/service-generator/releases)
[![MIT Licensed](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Total Downloads](https://img.shields.io/packagist/dt/joy2362/service-generator.svg?style=flat-square)](https://packagist.org/packages/joy2362/service-generator)

## Top features:

-   Creates trait by using artisan command
-   Creates service by using artisan command
-   Creates controller service by using artisan command
-   Add common functions that require to create API

## Installation

You can install this package using [Composer](https://getcomposer.org).

```bash
composer require joy2362/service-generator
```

Publish lang file:

```bash
php artisan vendor:publish --tag="service-generator-stub"
```

Publish stub file:

```bash
php artisan vendor:publish  --tag="service-generator-lang"
```

## Usage

### 1. Create trait

File location app/trait

```php
php artisan make:trait NotifiableTrait
```

### 2. Create service

File location app/service

```php
php artisan make:service CategoryService
```

### 3. Create controller service

### i. create controller and service file only
File location app/service && app/Http/Controllers 

```php
php artisan make:c-s Category
```

### ii. create controller and service with API crud operation
File location app/service && app/Http/Controllers && app/Http/Requests

```php
php artisan make:c-s Category --api
```

**Tip:** *if the name matches with any model then it will generate crud operation*

## Changelog

Please see [Releases](../../releases) for more information on what has changed recently.

## Contributing

Pull requests are more than welcome. You must follow the PSR coding standards.

## Security

If you discover any security-related issues, please email abdullahzahidjoy@gmail.com instead of using the issue tracker.



