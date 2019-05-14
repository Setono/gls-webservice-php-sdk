<?php

declare(strict_types=1);

namespace Setono\GLS\Webservice\Factory;

use SoapClient;

interface SoapClientFactoryInterface
{
    /**
     * Creates a SoapClient instance.
     *
     * @return SoapClient
     */
    public function create(): SoapClient;
}
