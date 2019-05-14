# GLS Webservice PHP SDK

[![Latest Version][ico-version]][link-packagist]
[![Latest Unstable Version][ico-unstable-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
[![Build Status][ico-travis]][link-travis]
[![Quality Score][ico-code-quality]][link-code-quality]

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

$factory = new SoapClientFactory('https://www.gls.dk/webservices_v4/wsShopFinder.asmx?WSDL');

$client = new Client($factory->create());

/** @var ParcelShop[] $parcelShops */
$parcelShops = $client->searchNearestParcelShops('Street', '12313', 'DK');
```

[ico-version]: https://poser.pugx.org/setono/gls-webservice-php-sdk/v/stable
[ico-unstable-version]: https://poser.pugx.org/setono/gls-webservice-php-sdk/v/unstable
[ico-license]: https://poser.pugx.org/setono/gls-webservice-php-sdk/license
[ico-travis]: https://travis-ci.com/Setono/gls-webservice-php-sdk.svg?branch=master
[ico-code-quality]: https://img.shields.io/scrutinizer/g/Setono/gls-webservice-php-sdk.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/setono/gls-webservice-php-sdk
[link-travis]: https://travis-ci.com/Setono/gls-webservice-php-sdk
[link-code-quality]: https://scrutinizer-ci.com/g/Setono/gls-webservice-php-sdk
