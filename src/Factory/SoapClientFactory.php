<?php

declare(strict_types=1);

namespace Setono\GLS\Webservice\Factory;

use SoapClient;

final class SoapClientFactory implements SoapClientFactoryInterface
{
    private string $wsdl;

    /** @var array<string, mixed> */
    private array $defaultOptions;

    /**
     * @param array<string, mixed> $defaultOptions
     */
    public function __construct(string $wsdl, array $defaultOptions = [])
    {
        $this->wsdl = $wsdl;

        $this->defaultOptions = array_merge([
            'trace' => true,
            'exceptions' => true,
        ], $defaultOptions);
    }

    public function create(array $options = []): SoapClient
    {
        return new SoapClient($this->wsdl, array_merge($this->defaultOptions, $options));
    }
}
