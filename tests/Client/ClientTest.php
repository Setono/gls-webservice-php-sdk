<?php

declare(strict_types=1);

namespace Setono\GLS\Webservice\Client;

use PHPUnit\Framework\TestCase;
use Setono\GLS\Webservice\Exception\ParcelShopNotFoundException;
use Setono\GLS\Webservice\Factory\SoapClientFactory;
use Setono\GLS\Webservice\Model\ParcelShop;

final class ClientTest extends TestCase
{
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

        $this->assertInstanceOf(ParcelShop::class, $parcelShop);
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

        $this->assertEmpty($result);
    }

    /**
     * @test
     */
    public function it_returns_parcel_shops(): void
    {
        $client = $this->getClient();

        $parcelShops = $client->searchNearestParcelShops('Købmagergade 10', '1160', 'DK');

        $this->assertNotEmpty($parcelShops);
        foreach ($parcelShops as $parcelShop) {
            $this->assertInstanceOf(ParcelShop::class, $parcelShop);
        }
    }

    private function getClient(): Client
    {
        $factory = new SoapClientFactory('https://www.gls.dk/webservices_v4/wsShopFinder.asmx?WSDL');

        return new Client($factory->create());
    }
}
