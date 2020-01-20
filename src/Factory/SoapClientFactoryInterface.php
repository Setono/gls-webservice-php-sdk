<?php

declare(strict_types=1);

namespace Setono\GLS\Webservice\Factory;

use SoapClient;

interface SoapClientFactoryInterface
{
    /**
     * @param array $options Options to send to the constructor of the SoapClient (see https://www.php.net/manual/en/soapclient.soapclient.php)
     */
    public function create(array $options = []): SoapClient;
}
