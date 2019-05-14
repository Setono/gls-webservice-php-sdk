<?php

declare(strict_types=1);

namespace Setono\GLS\Webservice\Client;

use PHPUnit\Framework\TestCase;
use Setono\GLS\Webservice\Model\ParcelShop;
use stdClass;

final class ParcelShopTest extends TestCase
{
    /**
     * @test
     */
    public function it_parses(): void
    {
        $data = new stdClass();
        $data->Number = '1234';
        $data->CompanyName = 'Shell';
        $data->Streetname = 'Street 1';
        $data->Streetname2 = 'Street 2';
        $data->ZipCode = '556677';
        $data->CityName = 'City';
        $data->CountryCodeISO3166A2 = 'DK';
        $data->Telephone = '434 4321 12';
        $data->Longitude = '12.1231';
        $data->Latitude = '54.777';
        $data->DistanceMetersAsTheCrowFlies = 999;
        $data->OpeningHours = new stdClass();
        $data->OpeningHours->Weekday = [];

        $data->OpeningHours->Weekday[0] = new stdClass();
        $data->OpeningHours->Weekday[0]->day = 'Monday';
        $data->OpeningHours->Weekday[0]->openAt = new stdClass();
        $data->OpeningHours->Weekday[0]->openAt->From = '06:00';
        $data->OpeningHours->Weekday[0]->openAt->To = '23:00';

        $parcelShop = ParcelShop::createFromStdClass($data);

        $this->assertSame('1234', $parcelShop->getNumber());
        $this->assertSame('Shell', $parcelShop->getCompanyName());
        $this->assertSame('Street 1', $parcelShop->getStreetName());
        $this->assertSame('Street 2', $parcelShop->getStreetName2());
        $this->assertSame('556677', $parcelShop->getZipCode());
        $this->assertSame('City', $parcelShop->getCity());
        $this->assertSame('DK', $parcelShop->getCountryCode());
        $this->assertSame('434 4321 12', $parcelShop->getTelephone());
        $this->assertSame('12.1231', $parcelShop->getLongitude());
        $this->assertSame('54.777', $parcelShop->getLatitude());
        $this->assertSame(999, $parcelShop->getDistanceMetersAsTheCrowFlies());

        $openingHours = $parcelShop->getOpeningHours();
        $this->assertCount(1, $openingHours);

        foreach ($parcelShop->getOpeningHours() as $openingHour) {
            $this->assertSame('Monday', $openingHour->getDay());
            $this->assertSame('06:00', $openingHour->getOpenFrom());
            $this->assertSame('23:00', $openingHour->getOpenTo());
        }
    }
}
