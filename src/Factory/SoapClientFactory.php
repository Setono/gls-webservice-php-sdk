<?php

declare(strict_types=1);

namespace Setono\GLS\Webservice\Factory;

use SoapClient;
use SoapFault;

final class SoapClientFactory implements SoapClientFactoryInterface
{
    /**
     * @var string
     */
    private $wsdl;

    public function __construct(string $wsdl)
    {
        $this->wsdl = $wsdl;
    }

    /**
     * @return SoapClient
     *
     * @throws SoapFault
     */
    public function create(): SoapClient
    {
        return new SoapClient($this->wsdl, [
            'trace' => true,
            'exceptions' => true,
        ]);
    }
}
