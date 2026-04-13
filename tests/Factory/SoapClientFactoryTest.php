<?php

declare(strict_types=1);

namespace Setono\GLS\Webservice\Factory;

use PHPUnit\Framework\TestCase;
use SoapClient;

final class SoapClientFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function it_creates_soap_client(): void
    {
        $factory = new SoapClientFactory('https://www.gls.dk/webservices_v4/wsShopFinder.asmx?WSDL');

        $client = $factory->create();

        self::assertInstanceOf(SoapClient::class, $client);
    }

    /**
     * @test
     */
    public function it_creates_soap_client_with_options(): void
    {
        $factory = new SoapClientFactory('https://www.gls.dk/webservices_v4/wsShopFinder.asmx?WSDL', [
            'connection_timeout' => 5,
        ]);

        $client = $factory->create();

        self::assertInstanceOf(SoapClient::class, $client);
    }
}
