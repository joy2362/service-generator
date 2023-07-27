# service-generator

A set of tools to make working with service easier in Laravel

[![Latest Version](https://img.shields.io/github/release/joy2362/service-generator.svg?style=flat-square)](https://github.com/joy2362/service-generator/releases)
[![MIT Licensed](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Total Downloads](https://img.shields.io/packagist/dt/joy2362/service-generator.svg?style=flat-square)](https://packagist.org/packages/joy2362/service-generator)

## Basics

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

```php
php artisan make:trait NotifiableTrait
```
