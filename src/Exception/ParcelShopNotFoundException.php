<?php

declare(strict_types=1);

namespace Setono\GLS\Webservice\Exception;

use InvalidArgumentException;

final class ParcelShopNotFoundException extends InvalidArgumentException implements ExceptionInterface
{
    public function __construct(string $parcelShopNumber)
    {
        parent::__construct(sprintf('The parcel shop with number %s was not found', $parcelShopNumber));
    }
}
