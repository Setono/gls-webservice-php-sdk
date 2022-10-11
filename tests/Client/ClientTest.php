<?php

declare(strict_types=1);

namespace Setono\GLS\Webservice\Client;

use PHPUnit\Framework\TestCase;
use Setono\GLS\Webservice\Exception\ConnectionException;
use Setono\GLS\Webservice\Exception\ParcelShopNotFoundException;
use Setono\GLS\Webservice\Factory\SoapClientFactory;
use Setono\GLS\Webservice\Factory\SoapClientFactoryInterface;
use Setono\GLS\Webservice\Model\ParcelShop;
use SoapClient;
use SoapFault;

final class ClientTest extends TestCase
{
    /************************************
     * Testing method getAllParcelShops *
     ***********************************/

    /**
     * @test
     */
    public function it_returns_all_parcel_shops(): void
    {
        $client = $this->getClient();

        $parcelShops = $client->getAllParcelShops('DK');
        self::assertNotEmpty($parcelShops);
        self::assertContainsOnlyInstancesOf(ParcelShop::class, $parcelShops);
    }

    /***********************************
     * Testing method getOneParcelShop *
     **********************************/

    /**
     * @test
     */
    public function it_throws_exception_when_parcel_shop_does_exist(): void
    {
        $client = $this->getClient();

        $this->expectException(ParcelShopNotFoundException::class);

        $client->getOneParcelShop('abc');
    }

    /**
     * @test
     */
    public function it_returns_a_parcel_shop(): void
    {
        $client = $this->getClient();

        $parcelShop = $client->getOneParcelShop('97891');

        self::assertInstanceOf(ParcelShop::class, $parcelShop);
    }

    /*******************************************
     * Testing method searchNearestParcelShops *
     ******************************************/

    /**
     * @test
     */
    public function it_returns_empty_array_when_no_eligible_result_is_found(): void
    {
        $client = $this->getClient();

        $result = $client->searchNearestParcelShops('1234', '1234', 'NOT_A_COUNTRY');

        self::assertEmpty($result);
    }

    /**
     * @test
     */
    public function it_returns_parcel_shops(): void
    {
        $client = $this->getClient();

        $parcelShops = $client->searchNearestParcelShops('Købmagergade 10', '1160', 'DK');

        self::assertNotEmpty($parcelShops);
        foreach ($parcelShops as $parcelShop) {
            self::assertInstanceOf(ParcelShop::class, $parcelShop);
        }
    }

    /**************
     * Misc tests *
     *************/

    /**
     * @test
     */
    public function it_handles_timeout(): void
    {
        $soapClient = new class() extends SoapClient {
            public function __construct($wsdl = 'https://www.gls.dk/webservices_v4/wsShopFinder.asmx?WSDL', array $options = null)
            {
                parent::__construct($wsdl, []);
            }

            public function __doRequest($request, $location, $action, $version, $one_way = 0): void
            {
                throw new SoapFault('HTTP', 'Could not connect to host');
            }
        };

        $client = $this->getClient($soapClient);

        $this->expectException(ConnectionException::class);

        $client->getAllParcelShops('DK');
    }

    private function getClient(SoapClient $soapClient = null): Client
    {
        $factory = new SoapClientFactory('https://www.gls.dk/webservices_v4/wsShopFinder.asmx?WSDL');

        if (null !== $soapClient) {
            $factory = new class($soapClient) implements SoapClientFactoryInterface {
                private SoapClient $soapClient;

                public function __construct(SoapClient $soapClient)
                {
                    $this->soapClient = $soapClient;
                }

                public function create(array $options = []): SoapClient
                {
                    return $this->soapClient;
                }
            };
        }

        return new Client($factory);
    }
}
