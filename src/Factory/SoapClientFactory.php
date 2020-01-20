<?php

declare(strict_types=1);

namespace Setono\GLS\Webservice\Factory;

use SoapClient;
use SoapFault;

final class SoapClientFactory implements SoapClientFactoryInterface
{
    /** @var string */
    private $wsdl;

    public function __construct(string $wsdl)
    {
        $this->wsdl = $wsdl;
    }

    /**
     * @throws SoapFault
     */
    public function create(array $options = []): SoapClient
    {
        $options = array_merge([
            'trace' => true,
            'exceptions' => true,
        ], $options);

        return new SoapClient($this->wsdl, $options);
    }
}
