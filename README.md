# GLS Webservice PHP SDK

[![Latest Version][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
[![Build Status][ico-github-actions]][link-github-actions]
[![Code Coverage][ico-code-coverage]][link-code-coverage]
[![Mutation testing][ico-infection]][link-infection]

A PHP SDK for the [GLS webservice](https://www.gls.dk/webservices_v4/wsShopFinder.asmx) which is very commonly used to search for nearby pickup points.

## Installation

Open a command console, enter your project directory and execute the following command to download the latest stable version of this library:

```bash
$ composer require setono/gls-webservice-php-sdk
```

This command requires you to have Composer installed globally, as explained in the [installation chapter](https://getcomposer.org/doc/00-intro.md) of the Composer documentation.

## Usage
```php
<?php
use Setono\GLS\Webservice\Client\Client;
use Setono\GLS\Webservice\Factory\SoapClientFactory;
use Setono\GLS\Webservice\Model\ParcelShop;

$client = new Client(new SoapClientFactory('https://www.gls.dk/webservices_v4/wsShopFinder.asmx?WSDL'));

/** @var ParcelShop[] $parcelShops */
$parcelShops = $client->searchNearestParcelShops('Street', '12313', 'DK');
```

[ico-version]: https://poser.pugx.org/setono/gls-webservice-php-sdk/v/stable
[ico-license]: https://poser.pugx.org/setono/gls-webservice-php-sdk/license
[ico-github-actions]: https://github.com/Setono/gls-webservice-php-sdk/workflows/build/badge.svg
[ico-code-coverage]: https://codecov.io/gh/Setono/gls-webservice-php-sdk/branch/master/graph/badge.svg
[ico-infection]: https://img.shields.io/endpoint?style=flat&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2FSetono%2Fgls-webservice-php-sdk%2Fmaster

[link-packagist]: https://packagist.org/packages/setono/gls-webservice-php-sdk
[link-github-actions]: https://github.com/Setono/gls-webservice-php-sdk/actions
[link-code-coverage]: https://codecov.io/gh/Setono/gls-webservice-php-sdk
[link-infection]: https://dashboard.stryker-mutator.io/reports/github.com/Setono/gls-webservice-php-sdk/master
